<?= $this->extend('layouts/customer') ?>

<?= $this->section('customer_content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-chat-left-dots-fill text-primary me-2"></i> My Inquiries & Quotes</h4>
        
        <!-- Status Filter -->
        <div class="d-flex gap-2">
            <a href="<?= base_url('dashboard/inquiries') ?>" class="btn btn-sm <?= empty($currentStatus) ? 'btn-primary' : 'btn-light border' ?>">All</a>
            <a href="<?= base_url('dashboard/inquiries?status=pending') ?>" class="btn btn-sm <?= $currentStatus === 'pending' ? 'btn-warning' : 'btn-light border' ?>">Pending</a>
            <a href="<?= base_url('dashboard/inquiries?status=replied') ?>" class="btn btn-sm <?= $currentStatus === 'replied' ? 'btn-success text-white' : 'btn-light border' ?>">Replied</a>
        </div>
    </div>

    <?php if (empty($inquiries)): ?>
        <div class="p-5 text-center text-muted">
            <i class="bi bi-inbox fs-1 mb-3 d-block text-secondary"></i>
            <h5 class="fw-bold text-dark">No inquiries found</h5>
            <p class="small mb-3">Browse our hardware catalog or repair services and send an inquiry to Gourav Joshi.</p>
            <a href="<?= base_url('products') ?>" class="btn btn-primary btn-sm fw-bold">Browse Catalog</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="small text-muted text-uppercase">
                        <th>Inquiry No</th>
                        <th>Subject & Linked Item</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date Submitted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <?php foreach ($inquiries as $inq): ?>
                        <tr>
                            <td><strong class="text-primary"><?= esc($inq['inquiry_no']) ?></strong></td>
                            <td>
                                <div class="fw-bold text-dark"><?= esc($inq['subject']) ?></div>
                                <?php if ($inq['product_name']): ?>
                                    <div class="text-muted small"><i class="bi bi-box-seam me-1 text-primary"></i> Product: <a href="<?= base_url('products/' . esc($inq['product_slug'])) ?>" class="text-decoration-none text-dark fw-semibold" target="_blank"><?= esc($inq['product_name']) ?></a></div>
                                <?php elseif ($inq['service_name']): ?>
                                    <div class="text-muted small"><i class="bi bi-tools me-1 text-info"></i> Service: <a href="<?= base_url('services/' . esc($inq['service_slug'])) ?>" class="text-decoration-none text-dark fw-semibold" target="_blank"><?= esc($inq['service_name']) ?></a></div>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= ucfirst(esc($inq['inquiry_type'])) ?></span></td>
                            <td>
                                <?php if ($inq['status'] === 'replied'): ?>
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Shop Replied</span>
                                <?php elseif ($inq['status'] === 'in_progress'): ?>
                                    <span class="badge bg-info text-dark"><i class="bi bi-hourglass-split me-1"></i> In Review</span>
                                <?php elseif ($inq['status'] === 'closed'): ?>
                                    <span class="badge bg-secondary">Closed</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Pending</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y, h:i A', strtotime($inq['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('dashboard/inquiries/' . $inq['id']) ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View Thread
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
