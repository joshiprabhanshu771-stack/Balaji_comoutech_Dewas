<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-percent text-warning me-2"></i> Promotional Offers & Discounts</h4>
        <a href="<?= base_url('admin/offers/create') ?>" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Add New Offer
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr class="text-muted text-uppercase">
                    <th>#</th>
                    <th>Offer Title</th>
                    <th>Discount Badge</th>
                    <th>Coupon Code</th>
                    <th>Valid Dates</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($offers as $off): ?>
                    <tr>
                        <td><?= $off['id'] ?></td>
                        <td>
                            <div class="fw-bold text-dark"><?= esc($off['title']) ?></div>
                            <div class="text-muted small text-truncate" style="max-width: 280px;"><?= esc($off['description']) ?></div>
                        </td>
                        <td><span class="badge bg-warning text-dark"><?= esc($off['discount_text']) ?></span></td>
                        <td><code><?= esc($off['coupon_code'] ?: 'N/A') ?></code></td>
                        <td>
                            <?php if ($off['valid_until']): ?>
                                <span class="text-muted small">Until: <?= date('d M Y', strtotime($off['valid_until'])) ?></span>
                            <?php else: ?>
                                <span class="text-muted small">No Expiry</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?= $off['is_active'] ? 'bg-success' : 'bg-secondary' ?>"><?= $off['is_active'] ? 'Active' : 'Inactive' ?></span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/offers/edit/' . $off['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/offers/delete/' . $off['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this offer?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
