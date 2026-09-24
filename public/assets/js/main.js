/**
 * Balaji Computech - Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {

    // 1. Wishlist AJAX Toggle
    const wishlistButtons = document.querySelectorAll('.btn-wishlist-toggle');
    wishlistButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const icon = this.querySelector('i');

            fetch(window.location.origin + '/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    'product_id': productId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'auth_required') {
                    showToast(data.message, 'warning');
                    setTimeout(() => {
                        window.location.href = window.location.origin + '/auth/login';
                    }, 1200);
                    return;
                }

                if (data.status === 'success') {
                    if (data.action === 'added') {
                        if (icon) {
                            icon.classList.remove('bi-heart');
                            icon.classList.add('bi-heart-fill');
                        }
                        this.classList.add('active');
                        showToast(data.message, 'success');
                    } else {
                        if (icon) {
                            icon.classList.remove('bi-heart-fill');
                            icon.classList.add('bi-heart');
                        }
                        this.classList.remove('active');
                        showToast(data.message, 'info');
                    }

                    // Update header wishlist badge if present
                    const countBadge = document.getElementById('wishlistCountBadge');
                    if (countBadge) {
                        countBadge.textContent = data.count;
                        countBadge.style.display = data.count > 0 ? 'inline-block' : 'none';
                    }
                } else {
                    showToast(data.message || 'Something went wrong', 'danger');
                }
            })
            .catch(err => {
                console.error('Wishlist error:', err);
                showToast('Unable to connect. Please try again.', 'danger');
            });
        });
    });

    // 2. Open Inquiry Modal Handler
    const inquiryModalEl = document.getElementById('inquiryModal');
    if (inquiryModalEl) {
        inquiryModalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;

            const productId = button.getAttribute('data-product-id') || '';
            const productName = button.getAttribute('data-product-name') || '';
            const serviceId = button.getAttribute('data-service-id') || '';
            const serviceName = button.getAttribute('data-service-name') || '';
            const inquiryType = button.getAttribute('data-inquiry-type') || (productId ? 'product' : (serviceId ? 'service' : 'general'));

            const modalProductId = inquiryModalEl.querySelector('#inquiryProductId');
            const modalServiceId = inquiryModalEl.querySelector('#inquiryServiceId');
            const modalInquiryType = inquiryModalEl.querySelector('#inquiryType');
            const modalSubject = inquiryModalEl.querySelector('#inquirySubject');
            const modalItemTitle = inquiryModalEl.querySelector('#inquiryItemTitle');

            if (modalProductId) modalProductId.value = productId;
            if (modalServiceId) modalServiceId.value = serviceId;
            if (modalInquiryType) modalInquiryType.value = inquiryType;

            let itemName = productName || serviceName || 'General Inquiry';
            if (modalItemTitle) modalItemTitle.textContent = itemName;
            if (modalSubject) modalSubject.value = 'Inquiry for: ' + itemName;
        });
    }

    // 3. Quick Copy Coupon Code
    const couponButtons = document.querySelectorAll('.btn-copy-code');
    couponButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const code = this.getAttribute('data-code');
            if (navigator.clipboard) {
                navigator.clipboard.writeText(code).then(() => {
                    showToast('Coupon code ' + code + ' copied to clipboard!', 'success');
                });
            } else {
                showToast('Coupon code: ' + code, 'info');
            }
        });
    });

});

// Global Toast Utility
function showToast(message, type = 'info') {
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }

    const toastId = 'toast_' + Date.now();
    const bgClass = type === 'success' ? 'bg-success text-white' :
                    type === 'danger'  ? 'bg-danger text-white' :
                    type === 'warning' ? 'bg-warning text-dark' : 'bg-primary text-white';

    const toastHtml = `
        <div id="${toastId}" class="toast align-items-center ${bgClass} border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-semibold">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', toastHtml);
    const toastEl = document.getElementById(toastId);
    const bsToast = new bootstrap.Toast(toastEl, { delay: 3500 });
    bsToast.show();

    toastEl.addEventListener('hidden.bs.toast', () => {
        toastEl.remove();
    });
}
