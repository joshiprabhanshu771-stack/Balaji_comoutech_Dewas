/**
 * Balaji Computech - Firebase Web Push Notification Manager
 * Handles FCM token lifecycle, permission requests, and foreground alerts.
 */

(function () {
    'use strict';

    let firebaseAppInstance = null;
    let firebaseMessagingInstance = null;
    let firebaseWebConfig = null;
    let swRegistration = null;
    let currentFcmToken = null;

    // Check Push & Service Worker Support
    function isPushSupported() {
        return ('serviceWorker' in navigator && 'PushManager' in window && 'Notification' in window);
    }

    // Load Firebase Web SDK scripts asynchronously if not already loaded
    function loadScript(src) {
        return new Promise((resolve, reject) => {
            if (document.querySelector(`script[src="${src}"]`)) {
                return resolve();
            }
            const script = document.createElement('script');
            script.src = src;
            script.async = true;
            script.onload = () => resolve();
            script.onerror = (err) => reject(err);
            document.head.appendChild(script);
        });
    }

    async function loadFirebaseSdk() {
        if (typeof firebase !== 'undefined' && firebase.messaging) {
            return;
        }
        await loadScript('https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js');
        await loadScript('https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging-compat.js');
    }

    // Fetch Firebase public configuration from backend
    async function fetchFirebaseConfig() {
        if (firebaseWebConfig) {
            return firebaseWebConfig;
        }
        try {
            const res = await fetch(window.location.origin + '/notifications/config', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            if (data.status === 'success' && data.config) {
                firebaseWebConfig = data.config;
                return firebaseWebConfig;
            }
        } catch (e) {
            console.error('[NotificationManager] Failed to fetch Firebase config:', e);
        }
        return null;
    }

    // Initialize Firebase client and Service Worker
    async function initFirebaseClient() {
        if (!isPushSupported()) {
            updateUIStatus('unsupported');
            return null;
        }

        const config = await fetchFirebaseConfig();
        if (!config || !config.apiKey || !config.projectId) {
            console.warn('[NotificationManager] Firebase credentials not configured in backend.');
            updateUIStatus('unconfigured');
            return null;
        }

        await loadFirebaseSdk();

        if (!firebase.apps.length) {
            firebaseAppInstance = firebase.initializeApp({
                apiKey: config.apiKey,
                authDomain: config.authDomain,
                projectId: config.projectId,
                storageBucket: config.storageBucket,
                messagingSenderId: config.messagingSenderId,
                appId: config.appId,
            });
        } else {
            firebaseAppInstance = firebase.app();
        }

        firebaseMessagingInstance = firebase.messaging();

        // Register Service Worker
        try {
            swRegistration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
            console.log('[NotificationManager] Service Worker registered successfully.');

            // Send config to active service worker
            if (navigator.serviceWorker.controller) {
                navigator.serviceWorker.controller.postMessage({
                    type: 'SET_FIREBASE_CONFIG',
                    config: config
                });
            }
        } catch (swErr) {
            console.error('[NotificationManager] Service worker registration error:', swErr);
        }

        // Listen for foreground notifications
        firebaseMessagingInstance.onMessage((payload) => {
            console.log('[NotificationManager] Foreground message received:', payload);
            handleForegroundMessage(payload);
        });

        // Update UI based on initial permission
        checkCurrentPermission();

        return firebaseMessagingInstance;
    }

    // Handle interactive notification banner when website is open in foreground
    function handleForegroundMessage(payload) {
        const title = (payload.notification && payload.notification.title) ||
                      (payload.data && payload.data.title) ||
                      'Balaji Computech Notification';

        const body  = (payload.notification && payload.notification.body) ||
                      (payload.data && payload.data.body) ||
                      'You have a new update.';

        const url   = (payload.data && payload.data.url) ||
                      (payload.fcmOptions && payload.fcmOptions.link) ||
                      '#';

        if (typeof showToast === 'function') {
            const actionBtn = url !== '#' ? `<br><a href="${url}" class="btn btn-sm btn-light text-primary fw-bold mt-2"><i class="bi bi-box-arrow-up-right me-1"></i> Open Details</a>` : '';
            showToast(`<strong>${title}</strong><br>${body}${actionBtn}`, 'primary');
        } else {
            alert(`${title}\n${body}`);
        }
    }

    // Check permission and sync token
    async function checkCurrentPermission() {
        if (!isPushSupported()) {
            updateUIStatus('unsupported');
            return;
        }

        const permission = Notification.permission;
        if (permission === 'granted') {
            updateUIStatus('granted');
            // Check if token needs to be retrieved/refreshed
            await retrieveAndRegisterToken(false);
        } else if (permission === 'denied') {
            updateUIStatus('denied');
        } else {
            updateUIStatus('default');
        }
    }

    // User action: Request permission and register token
    async function enableNotifications() {
        if (!isPushSupported()) {
            alert('Push notifications are not supported by your current browser.');
            return;
        }

        const messaging = await initFirebaseClient();
        if (!messaging) {
            alert('Firebase push notifications are not configured yet. Please check site settings.');
            return;
        }

        try {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                updateUIStatus('granted');
                const token = await retrieveAndRegisterToken(true);
                if (token) {
                    if (typeof showToast === 'function') {
                        showToast('Push notifications enabled successfully for this device! 🔔', 'success');
                    } else {
                        alert('Push notifications enabled successfully!');
                    }
                }
            } else if (permission === 'denied') {
                updateUIStatus('denied');
                alert('Notification permission was blocked in your browser settings. Please enable notifications in your browser address bar/site settings.');
            } else {
                updateUIStatus('default');
            }
        } catch (err) {
            console.error('[NotificationManager] Permission error:', err);
            alert('Failed to enable push notifications: ' + err.message);
        }
    }

    // Retrieve FCM token and send to backend
    async function retrieveAndRegisterToken(showFeedback = false) {
        if (!firebaseMessagingInstance || !firebaseWebConfig) {
            return null;
        }

        try {
            const tokenOptions = {
                vapidKey: firebaseWebConfig.vapidKey,
            };
            if (swRegistration) {
                tokenOptions.serviceWorkerRegistration = swRegistration;
            }

            const token = await firebaseMessagingInstance.getToken(tokenOptions);
            if (token) {
                currentFcmToken = token;
                await sendTokenToBackend(token);
                updateUIStatus('active');
                return token;
            } else {
                console.warn('[NotificationManager] No registration token available.');
            }
        } catch (err) {
            console.error('[NotificationManager] Error retrieving FCM token:', err);
            if (showFeedback) {
                if (typeof showToast === 'function') {
                    showToast('Unable to obtain FCM token. Please verify VAPID key in settings.', 'danger');
                }
            }
        }
        return null;
    }

    // Send token to CodeIgniter backend
    async function sendTokenToBackend(token) {
        try {
            const res = await fetch(window.location.origin + '/notifications/register-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    token: token,
                    device_type: /Mobile|Android|iP(hone|od|ad)/i.test(navigator.userAgent) ? 'mobile' : 'desktop',
                    browser: navigator.userAgent.includes('Chrome') ? 'Chrome' : (navigator.userAgent.includes('Firefox') ? 'Firefox' : 'Browser'),
                    platform: navigator.platform || 'Unknown'
                })
            });
            const data = await res.json();
            if (data.status === 'success') {
                console.log('[NotificationManager] Token registered on server.');
                refreshDashboardDeviceCount();
            } else if (res.status === 401) {
                console.log('[NotificationManager] User not logged in, token not linked yet.');
            }
        } catch (e) {
            console.error('[NotificationManager] Failed to register token with backend:', e);
        }
    }

    // Send test notification
    async function sendTestNotification() {
        const btn = document.getElementById('btnSendTestNotification');
        if (btn) btn.disabled = true;

        try {
            const res = await fetch(window.location.origin + '/notifications/send-test', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await res.json();
            if (data.status === 'success') {
                if (typeof showToast === 'function') {
                    showToast(data.message, 'success');
                } else {
                    alert(data.message);
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Failed to send test alert.', 'warning');
                } else {
                    alert(data.message || 'Failed to send test alert.');
                }
            }
        } catch (err) {
            console.error('[NotificationManager] Test push error:', err);
            if (typeof showToast === 'function') {
                showToast('Failed to connect to test push endpoint.', 'danger');
            }
        } finally {
            if (btn) btn.disabled = false;
        }
    }

    // Update UI status badges and buttons
    function updateUIStatus(state) {
        const badge = document.getElementById('notificationStatusBadge');
        const enableBtn = document.getElementById('btnEnableNotifications');
        const testBtn = document.getElementById('btnSendTestNotification');
        const blockedAlert = document.getElementById('notificationBlockedAlert');
        const descText = document.getElementById('notificationDescText');

        if (!badge && !enableBtn) return;

        if (state === 'unsupported') {
            if (badge) {
                badge.className = 'badge bg-secondary';
                badge.textContent = 'Not Supported in Browser';
            }
            if (enableBtn) enableBtn.style.display = 'none';
            if (testBtn) testBtn.style.display = 'none';
        } else if (state === 'denied') {
            if (badge) {
                badge.className = 'badge bg-danger';
                badge.textContent = 'Blocked in Browser ✕';
            }
            if (enableBtn) {
                enableBtn.disabled = true;
                enableBtn.textContent = 'Notifications Blocked';
            }
            if (testBtn) testBtn.style.display = 'none';
            if (blockedAlert) blockedAlert.classList.remove('d-none');
        } else if (state === 'granted' || state === 'active') {
            if (badge) {
                badge.className = 'badge bg-success';
                badge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Enabled ✓';
            }
            if (enableBtn) {
                enableBtn.className = 'btn btn-outline-success btn-sm fw-bold';
                enableBtn.innerHTML = '<i class="bi bi-check2-all me-1"></i> Notifications Active';
            }
            if (testBtn) testBtn.classList.remove('d-none');
            if (blockedAlert) blockedAlert.classList.add('d-none');
            if (descText) descText.textContent = 'Push notifications are active on this device. You will receive real-time alerts with sound/vibration where supported.';
        } else {
            // Default / Not yet enabled
            if (badge) {
                badge.className = 'badge bg-warning text-dark';
                badge.textContent = 'Disabled / Not Enabled';
            }
            if (enableBtn) {
                enableBtn.className = 'btn btn-primary btn-sm fw-bold';
                enableBtn.innerHTML = '<i class="bi bi-bell-fill me-1"></i> Enable Push Notifications';
                enableBtn.disabled = false;
            }
            if (testBtn) testBtn.classList.add('d-none');
            if (blockedAlert) blockedAlert.classList.add('d-none');
        }
    }

    // Refresh active device count from backend
    async function refreshDashboardDeviceCount() {
        const countBadge = document.getElementById('notificationDeviceCountBadge');
        if (!countBadge) return;

        try {
            const res = await fetch(window.location.origin + '/notifications/status', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            if (data.is_logged_in) {
                countBadge.textContent = data.active_devices_count + ' Registered Device(s)';
            }
        } catch (e) {
            // ignore
        }
    }

    // Expose global methods
    window.BalajiNotifications = {
        init: initFirebaseClient,
        enable: enableNotifications,
        sendTest: sendTestNotification,
        refresh: checkCurrentPermission
    };

    // Auto-init on page load
    document.addEventListener('DOMContentLoaded', function () {
        initFirebaseClient();

        const enableBtn = document.getElementById('btnEnableNotifications');
        if (enableBtn) {
            enableBtn.addEventListener('click', function (e) {
                e.preventDefault();
                enableNotifications();
            });
        }

        const testBtn = document.getElementById('btnSendTestNotification');
        if (testBtn) {
            testBtn.addEventListener('click', function (e) {
                e.preventDefault();
                sendTestNotification();
            });
        }
    });

})();
