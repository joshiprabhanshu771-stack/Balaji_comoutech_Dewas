<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Stat Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <span class="text-muted small d-block text-uppercase fw-bold">Total Inquiries</span>
                <h3 class="fw-bold mb-0 text-dark"><?= $stats['total_inquiries'] ?></h3>
                <span class="badge bg-warning text-dark mt-2"><?= $stats['pending_inquiries'] ?> Pending</span>
            </div>
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-chat-left-text-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <span class="text-muted small d-block text-uppercase fw-bold">Products Catalog</span>
                <h3 class="fw-bold mb-0 text-dark"><?= $stats['total_products'] ?></h3>
                <span class="text-muted small d-block mt-2"><?= $stats['total_categories'] ?> Categories</span>
            </div>
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="bi bi-box-seam-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <span class="text-muted small d-block text-uppercase fw-bold">Repair Services</span>
                <h3 class="fw-bold mb-0 text-dark"><?= $stats['total_services'] ?></h3>
                <span class="badge bg-info text-dark mt-2"><?= $stats['active_offers'] ?> Active Deals</span>
            </div>
            <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i class="bi bi-tools"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <span class="text-muted small d-block text-uppercase fw-bold">Registered Users</span>
                <h3 class="fw-bold mb-0 text-dark"><?= $stats['total_customers'] ?></h3>
                <span class="badge bg-danger mt-2"><?= $stats['unread_messages'] ?> New Messages</span>
            </div>
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>
<!-- Push Notification Alert Setting Card -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
        <div class="d-flex align-items-center gap-2">
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-bell-fill text-primary me-2"></i> Shopkeeper Push Notification Alerts
            </h5>
            <span id="notificationStatusBadge" class="badge bg-secondary">Checking Status...</span>
        </div>
        <div class="small">
            <span id="notificationDeviceCountBadge" class="badge bg-light text-dark border">Checking Devices...</span>
        </div>
    </div>
    <p class="text-muted small mb-3" id="notificationDescText">
        Enable notifications on your smartphone or browser to receive instant audio & vibration alerts whenever a customer submits a new inquiry.
    </p>

    <!-- Blocked Alert Warning -->
    <div id="notificationBlockedAlert" class="alert alert-warning py-2 px-3 small d-none mb-3">
        <i class="bi bi-exclamation-triangle-fill me-1"></i>
        <strong>Notifications are blocked in this browser.</strong> Please click the site icon in your browser address bar and switch Notifications to <em>Allow</em>.
    </div>

    <div class="d-flex align-items-center flex-wrap gap-2">
        <button type="button" id="btnEnableNotifications" class="btn btn-primary btn-sm fw-bold px-3 py-2">
            <i class="bi bi-bell-fill me-1"></i> Enable Push Notifications on This Device
        </button>
        <button type="button" id="btnSendTestNotification" class="btn btn-outline-secondary btn-sm fw-bold px-3 py-2 d-none">
            <i class="bi bi-send-check me-1"></i> Send Test Notification
        </button>
    </div>
</div>

<!-- Quick Actions & Recent Inquiries -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-chat-left-dots-fill text-primary me-2"></i> Recent Customer Inquiries</h5>
                <a href="<?= base_url('admin/inquiries') ?>" class="btn btn-sm btn-outline-primary fw-semibold">View All</a>
            </div>

            <?php if (empty($recentInquiries)): ?>
                <p class="text-muted small mb-0 p-3 text-center">No inquiries received yet.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr class="text-muted text-uppercase">
                                <th>Inquiry No</th>
                                <th>Customer</th>
                                <th>Item / Subject</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentInquiries as $inq): ?>
                                <tr>
                                    <td><strong class="text-primary"><?= esc($inq['inquiry_no']) ?></strong></td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= esc($inq['name']) ?></div>
                                        <div class="text-muted" style="font-size: 0.75rem;"><?= esc($inq['mobile']) ?></div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 180px;"><?= esc($inq['subject']) ?></div>
                                        <?php if ($inq['product_name']): ?>
                                            <span class="badge bg-light text-primary border" style="font-size: 0.7rem;">Product</span>
                                        <?php elseif ($inq['service_name']): ?>
                                            <span class="badge bg-light text-info border" style="font-size: 0.7rem;">Service</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($inq['status'] === 'replied'): ?>
                                            <span class="badge bg-success">Replied</span>
                                        <?php elseif ($inq['status'] === 'in_progress'): ?>
                                            <span class="badge bg-info text-dark">In Progress</span>
                                        <?php elseif ($inq['status'] === 'closed'): ?>
                                            <span class="badge bg-secondary">Closed</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M, h:i A', strtotime($inq['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/inquiries/' . $inq['id']) ?>" class="btn btn-sm btn-primary py-1 px-2">
                                            <i class="bi bi-reply-fill"></i> Reply
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Shortcuts & Messages -->
    <div class="col-lg-4">
        <!-- Quick Shortcuts -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-lightning-charge-fill text-warning me-2"></i> Quick Actions</h5>
            <div class="d-grid gap-2">
                <a href="<?= base_url('admin/products/create') ?>" class="btn btn-outline-primary text-start fw-semibold py-2">
                    <i class="bi bi-plus-circle-fill me-2"></i> Add New Product
                </a>
                <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-outline-secondary text-start fw-semibold py-2">
                    <i class="bi bi-folder-plus me-2"></i> Add New Category
                </a>
                <a href="<?= base_url('admin/services/create') ?>" class="btn btn-outline-info text-dark text-start fw-semibold py-2">
                    <i class="bi bi-tools me-2"></i> Add New Service
                </a>
                <a href="<?= base_url('admin/offers/create') ?>" class="btn btn-outline-warning text-dark text-start fw-semibold py-2">
                    <i class="bi bi-tag me-2"></i> Create Offer / Deal
                </a>
            </div>
        </div>

        <!-- Recent Contact Messages -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-envelope-fill text-danger me-2"></i> Contact Messages</h6>
                <a href="<?= base_url('admin/contact-messages') ?>" class="small text-decoration-none">View All</a>
            </div>

            <?php if (empty($recentMessages)): ?>
                <p class="text-muted small mb-0">No new contact messages.</p>
            <?php else: ?>
                <ul class="list-group list-group-flush small">
                    <?php foreach ($recentMessages as $msg): ?>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong><?= esc($msg['name']) ?></strong>
                                <span class="text-muted" style="font-size: 0.75rem;"><?= date('d M', strtotime($msg['created_at'])) ?></span>
                            </div>
                            <div class="text-truncate text-muted"><?= esc($msg['subject']) ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
