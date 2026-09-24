/**
 * Balaji Computech - Firebase Messaging Service Worker
 * Handles background push notifications, system alerts, and notification click events.
 */

importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging-compat.js');

// Fetch public config or initialize when available
let isFirebaseInitialized = false;

function initFirebaseInWorker(config) {
    if (isFirebaseInitialized || !config || !config.apiKey || !config.projectId) {
        return;
    }
    try {
        firebase.initializeApp({
            apiKey: config.apiKey,
            authDomain: config.authDomain,
            projectId: config.projectId,
            storageBucket: config.storageBucket,
            messagingSenderId: config.messagingSenderId,
            appId: config.appId,
        });
        const messaging = firebase.messaging();
        isFirebaseInitialized = true;

        messaging.onBackgroundMessage(function (payload) {
            console.log('[firebase-messaging-sw.js] Background message received:', payload);
            const notificationTitle = (payload.notification && payload.notification.title) ||
                                     (payload.data && payload.data.title) ||
                                     'Balaji Computech Alert';

            const notificationBody  = (payload.notification && payload.notification.body) ||
                                     (payload.data && payload.data.body) ||
                                     'You have a new update.';

            const notificationIcon  = (payload.notification && payload.notification.icon) ||
                                     (payload.data && payload.data.icon) ||
                                     '/favicon.ico';

            const targetUrl         = (payload.data && payload.data.url) ||
                                     (payload.fcmOptions && payload.fcmOptions.link) ||
                                     '/';

            const tag               = (payload.notification && payload.notification.tag) ||
                                     (payload.data && payload.data.tag) ||
                                     'balaji-notification-' + Date.now();

            const notificationOptions = {
                body: notificationBody,
                icon: notificationIcon,
                badge: '/favicon.ico',
                tag: tag,
                renotify: true,
                vibrate: [200, 100, 200],
                data: {
                    url: targetUrl,
                    payload: payload.data || {}
                }
            };

            return self.registration.showNotification(notificationTitle, notificationOptions);
        });
    } catch (err) {
        console.error('[firebase-messaging-sw.js] Worker init error:', err);
    }
}

// Check message events from main thread to pass config
self.addEventListener('message', function (event) {
    if (event.data && event.data.type === 'SET_FIREBASE_CONFIG') {
        initFirebaseInWorker(event.data.config);
    }
});

// Standard Push Event fallback handler
self.addEventListener('push', function (event) {
    if (!event.data) {
        return;
    }

    try {
        const payload = event.data.json();
        console.log('[firebase-messaging-sw.js] Push event raw payload:', payload);

        const title = (payload.notification && payload.notification.title) ||
                      (payload.data && payload.data.title) ||
                      'Balaji Computech Alert';

        const body  = (payload.notification && payload.notification.body) ||
                      (payload.data && payload.data.body) ||
                      'You have a new notification.';

        const icon  = (payload.notification && payload.notification.icon) ||
                      (payload.data && payload.data.icon) ||
                      '/favicon.ico';

        const url   = (payload.data && payload.data.url) ||
                      (payload.fcmOptions && payload.fcmOptions.link) ||
                      '/';

        const tag   = (payload.notification && payload.notification.tag) ||
                      (payload.data && payload.data.tag) ||
                      'balaji-notification-' + Date.now();

        const options = {
            body: body,
            icon: icon,
            badge: '/favicon.ico',
            tag: tag,
            renotify: true,
            vibrate: [200, 100, 200],
            data: {
                url: url,
                payload: payload.data || {}
            }
        };

        event.waitUntil(self.registration.showNotification(title, options));
    } catch (e) {
        console.warn('[firebase-messaging-sw.js] Push event text fallback:', event.data.text());
        const options = {
            body: event.data.text(),
            icon: '/favicon.ico',
            badge: '/favicon.ico',
            vibrate: [200, 100, 200],
            data: { url: '/' }
        };
        event.waitUntil(self.registration.showNotification('Balaji Computech', options));
    }
});

// Handle Notification Click Action
self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    const targetUrl = (event.notification.data && event.notification.data.url) ? event.notification.data.url : '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            // Check if there is already a window open with matching target URL
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                if (client.url === targetUrl && 'focus' in client) {
                    return client.focus();
                }
            }
            // Otherwise open a new window
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
