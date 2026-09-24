<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-tools text-primary me-2"></i> Service & Repair Management</h4>
        <a href="<?= base_url('admin/services/create') ?>" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Add New Service
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr class="text-muted text-uppercase">
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Slug</th>
                    <th>Turnaround Time</th>
                    <th>Starting Estimate</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $srv): ?>
                    <tr>
                        <td><?= $srv['id'] ?></td>
                        <td>
                            <div class="fw-bold text-dark"><i class="<?= esc($srv['icon'] ?: 'bi bi-tools') ?> text-primary me-1"></i> <?= esc($srv['name']) ?></div>
                            <div class="text-muted small text-truncate" style="max-width: 250px;"><?= esc($srv['short_description']) ?></div>
                        </td>
                        <td><code><?= esc($srv['slug']) ?></code></td>
                        <td><?= esc($srv['turnaround_time'] ?: 'N/A') ?></td>
                        <td><strong class="text-success">₹<?= number_format($srv['starting_price'], 2) ?></strong></td>
                        <td>
                            <?= $srv['is_featured'] ? '<span class="badge bg-warning text-dark">Yes</span>' : '<span class="badge bg-light text-muted border">No</span>' ?>
                        </td>
                        <td>
                            <span class="badge <?= $srv['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"><?= ucfirst(esc($srv['status'])) ?></span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('services/' . esc($srv['slug'])) ?>" class="btn btn-sm btn-outline-info" target="_blank" title="View Public Page">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= base_url('admin/services/edit/' . $srv['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/services/delete/' . $srv['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this service permanently?')">
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
