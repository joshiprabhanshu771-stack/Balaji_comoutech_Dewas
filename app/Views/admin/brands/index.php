<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-tags-fill text-primary me-2"></i> Brand Management</h4>
        <a href="<?= base_url('admin/brands/create') ?>" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Add New Brand
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr class="text-muted text-uppercase">
                    <th>#</th>
                    <th>Brand Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($brands as $b): ?>
                    <tr>
                        <td><?= $b['id'] ?></td>
                        <td><strong class="text-dark"><?= esc($b['name']) ?></strong></td>
                        <td><code><?= esc($b['slug']) ?></code></td>
                        <td><div class="text-muted small text-truncate" style="max-width: 300px;"><?= esc($b['description']) ?></div></td>
                        <td>
                            <?= $b['is_featured'] ? '<span class="badge bg-warning text-dark">Yes</span>' : '<span class="badge bg-light text-muted border">No</span>' ?>
                        </td>
                        <td>
                            <span class="badge <?= $b['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"><?= ucfirst(esc($b['status'])) ?></span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/brands/edit/' . $b['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/brands/delete/' . $b['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this brand?')">
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
