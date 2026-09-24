<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-folder-fill text-primary me-2"></i> Category Management</h4>
        <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Add New Category
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr class="text-muted text-uppercase">
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Icon</th>
                    <th>Sort Order</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['id'] ?></td>
                        <td>
                            <div class="fw-bold text-dark"><?= esc($cat['name']) ?></div>
                            <div class="text-muted small text-truncate" style="max-width: 250px;"><?= esc($cat['description']) ?></div>
                        </td>
                        <td><code><?= esc($cat['slug']) ?></code></td>
                        <td><i class="<?= esc($cat['icon'] ?: 'bi bi-folder') ?> fs-5 text-primary"></i></td>
                        <td><?= $cat['sort_order'] ?></td>
                        <td>
                            <?= $cat['is_featured'] ? '<span class="badge bg-warning text-dark">Yes</span>' : '<span class="badge bg-light text-muted border">No</span>' ?>
                        </td>
                        <td>
                            <span class="badge <?= $cat['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"><?= ucfirst(esc($cat['status'])) ?></span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/categories/edit/' . $cat['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/categories/delete/' . $cat['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this category?')">
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
