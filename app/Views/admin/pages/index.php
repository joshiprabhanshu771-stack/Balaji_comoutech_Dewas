<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-file-text-fill text-primary me-2"></i> Content & Policy Pages</h4>
        <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Add New Page
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr class="text-muted text-uppercase">
                    <th>#</th>
                    <th>Page Title</th>
                    <th>URL Slug</th>
                    <th>Meta Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><strong class="text-dark"><?= esc($p['title']) ?></strong></td>
                        <td><code>page/<?= esc($p['slug']) ?></code></td>
                        <td><?= esc($p['meta_title'] ?: 'Default') ?></td>
                        <td>
                            <span class="badge <?= $p['is_active'] ? 'bg-success' : 'bg-secondary' ?>"><?= $p['is_active'] ? 'Published' : 'Draft' ?></span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('page/' . esc($p['slug'])) ?>" class="btn btn-sm btn-outline-info" target="_blank" title="View Public Page">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= base_url('admin/pages/edit/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/pages/delete/' . $p['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this page?')">
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
