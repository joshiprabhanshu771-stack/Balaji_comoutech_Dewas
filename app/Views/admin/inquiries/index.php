<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-chat-left-text-fill text-primary me-2"></i> Customer Inquiry Management</h4>
    </div>

    <!-- Filters -->
    <form action="<?= base_url('admin/inquiries') ?>" method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Search by name, email, phone, inquiry #..." value="<?= esc($search ?? '') ?>">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Statuses</option>
                <option value="pending" <?= ($status === 'pending') ? 'selected' : '' ?>>Pending</option>
                <option value="in_progress" <?= ($status === 'in_progress') ? 'selected' : '' ?>>In Progress</option>
                <option value="replied" <?= ($status === 'replied') ? 'selected' : '' ?>>Replied</option>
                <option value="closed" <?= ($status === 'closed') ? 'selected' : '' ?>>Closed</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="type" class="form-select form-select-sm">
                <option value="">All Types</option>
                <option value="general" <?= ($type === 'general') ? 'selected' : '' ?>>General</option>
                <option value="product" <?= ($type === 'product') ? 'selected' : '' ?>>Product Inquiry</option>
                <option value="service" <?= ($type === 'service') ? 'selected' : '' ?>>Service Booking</option>
                <option value="bulk" <?= ($type === 'bulk') ? 'selected' : '' ?>>Bulk Inquiry</option>
                <option value="repair" <?= ($type === 'repair') ? 'selected' : '' ?>>Repair Diagnostics</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-dark w-100 fw-semibold">Filter</button>
            <a href="<?= base_url('admin/inquiries') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>

    <?php if (empty($inquiries)): ?>
        <div class="p-5 text-center text-muted">
            <i class="bi bi-chat-square-dots fs-1 mb-2 d-block"></i>
            <p>No inquiries found matching criteria.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr class="text-muted text-uppercase">
                        <th>Inquiry No</th>
                        <th>Customer Details</th>
                        <th>Subject & Linked Item</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Received Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inquiries as $inq): ?>
                        <tr>
                            <td><strong class="text-primary"><?= esc($inq['inquiry_no']) ?></strong></td>
                            <td>
                                <div class="fw-bold text-dark"><?= esc($inq['name']) ?></div>
                                <div class="text-muted small"><i class="bi bi-telephone me-1"></i> <?= esc($inq['mobile']) ?></div>
                                <div class="text-muted small"><i class="bi bi-envelope me-1"></i> <?= esc($inq['email']) ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;"><?= esc($inq['subject']) ?></div>
                                <?php if ($inq['product_name']): ?>
                                    <span class="badge bg-light text-primary border" style="font-size: 0.7rem;"><i class="bi bi-box-seam me-1"></i> <?= esc($inq['product_name']) ?></span>
                                <?php elseif ($inq['service_name']): ?>
                                    <span class="badge bg-light text-info border" style="font-size: 0.7rem;"><i class="bi bi-tools me-1"></i> <?= esc($inq['service_name']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= ucfirst(esc($inq['inquiry_type'])) ?></span></td>
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
                            <td><?= date('d M Y, h:i A', strtotime($inq['created_at'])) ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('admin/inquiries/' . $inq['id']) ?>" class="btn btn-sm btn-primary" title="View & Reply">
                                        <i class="bi bi-reply-fill"></i> Reply
                                    </a>
                                    <a href="<?= base_url('admin/inquiries/delete/' . $inq['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this inquiry record?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
