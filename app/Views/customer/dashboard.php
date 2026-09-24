<?= $this->extend('layouts/customer') ?>

<?= $this->section('customer_content') ?>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <span class="text-muted small d-block">Total Inquiries</span>
                <h3 class="fw-bold mb-0 text-dark"><?= $totalInquiries ?></h3>
            </div>
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-chat-left-text"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <span class="text-muted small d-block">Pending Quotes</span>
                <h3 class="fw-bold mb-0 text-warning"><?= $pendingInquiries ?></h3>
            </div>
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <span class="text-muted small d-block">Replied by Shop</span>
                <h3 class="fw-bold mb-0 text-success"><?= $repliedInquiries ?></h3>
            </div>
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="bi bi-reply-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <span class="text-muted small d-block">Saved Wishlist</span>
                <h3 class="fw-bold mb-0 text-danger"><?= $totalWishlist ?></h3>
            </div>
            <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                <i class="bi bi-heart-fill"></i>
            </div>
        </div>
    </div>
<!-- Push Notification Alert Setting Card -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
        <h5 class="fw-bold text-dark mb-0">
            <i class="bi bi-bell-fill text-warning me-2"></i> Push Notification Alerts
        </h5>
        <div>
            <span id="notificationStatusBadge" class="badge bg-secondary">Checking Status...</span>
        </div>
    </div>
    <p class="text-muted small mb-3" id="notificationDescText">
        Enable push notifications to receive instant audio & pop-up alerts on your mobile phone or browser when Gourav Joshi & Balaji Computech reply to your product/service inquiries.
    </p>

    <!-- Blocked Alert Warning -->
    <div id="notificationBlockedAlert" class="alert alert-warning py-2 px-3 small d-none mb-3">
        <i class="bi bi-exclamation-triangle-fill me-1"></i>
        <strong>Notifications are blocked in your browser.</strong> Please click the lock or settings icon in your browser address bar and change Notification permission to <em>Allow</em>.
    </div>

    <div class="d-flex align-items-center flex-wrap gap-2">
        <button type="button" id="btnEnableNotifications" class="btn btn-primary btn-sm fw-bold px-3 py-2">
            <i class="bi bi-bell-fill me-1"></i> Enable Push Notifications
        </button>
        <button type="button" id="btnSendTestNotification" class="btn btn-outline-secondary btn-sm fw-bold px-3 py-2 d-none">
            <i class="bi bi-send-check me-1"></i> Send Test Alert
        </button>
    </div>
</div>

<!-- Recent Inquiries Table -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history text-primary me-2"></i> Recent Inquiries</h5>
        <a href="<?= base_url('dashboard/inquiries') ?>" class="btn btn-sm btn-outline-primary fw-semibold">View All</a>
    </div>

    <?php if (empty($recentInquiries)): ?>
        <div class="p-4 text-center text-muted">
            <i class="bi bi-chat-square-dots fs-2 mb-2 d-block"></i>
            <p class="mb-0">You haven't submitted any inquiries yet.</p>
            <a href="<?= base_url('products') ?>" class="btn btn-primary btn-sm mt-3 fw-bold">Explore Products</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="small text-muted text-uppercase">
                        <th>Inquiry No</th>
                        <th>Subject / Item</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <?php foreach ($recentInquiries as $inq): ?>
                        <tr>
                            <td><strong class="text-primary"><?= esc($inq['inquiry_no']) ?></strong></td>
                            <td>
                                <div class="fw-semibold text-dark"><?= esc($inq['subject']) ?></div>
                                <?php if ($inq['product_name']): ?>
                                    <span class="text-muted small"><i class="bi bi-box-seam me-1"></i> <?= esc($inq['product_name']) ?></span>
                                <?php elseif ($inq['service_name']): ?>
                                    <span class="text-muted small"><i class="bi bi-tools me-1"></i> <?= esc($inq['service_name']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= ucfirst(esc($inq['inquiry_type'])) ?></span></td>
                            <td>
                                <?php if ($inq['status'] === 'replied'): ?>
                                    <span class="badge bg-success">Shop Replied</span>
                                <?php elseif ($inq['status'] === 'in_progress'): ?>
                                    <span class="badge bg-info text-dark">Processing</span>
                                <?php elseif ($inq['status'] === 'closed'): ?>
                                    <span class="badge bg-secondary">Closed</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y, h:i A', strtotime($inq['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('dashboard/inquiries/' . $inq['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Wishlist Preview -->
<?php if (!empty($wishlistItems)): ?>
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-heart-fill text-danger me-2"></i> Saved Wishlist Preview</h5>
            <a href="<?= base_url('dashboard/wishlist') ?>" class="btn btn-sm btn-outline-danger fw-semibold">View Full Wishlist</a>
        </div>

        <div class="row g-3">
            <?php foreach ($wishlistItems as $item): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="border rounded-3 p-3 text-center h-100 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-light text-muted small mb-1"><?= esc($item['category_name'] ?? 'Hardware') ?></span>
                            <h6 class="fw-bold text-dark text-truncate mb-2"><?= esc($item['name']) ?></h6>
                            <div class="text-primary fw-bold mb-3">₹<?= number_format($item['discount_price'] ?? $item['price'], 2) ?></div>
                        </div>
                        <a href="<?= base_url('products/' . esc($item['slug'])) ?>" class="btn btn-sm btn-outline-primary w-100 fw-bold">
                            View Product
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
