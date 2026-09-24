<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-question-circle-fill text-primary me-2"></i> FAQ Management</h4>
        <a href="<?= base_url('admin/faqs/create') ?>" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Add New FAQ
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr class="text-muted text-uppercase">
                    <th>#</th>
                    <th>Category</th>
                    <th>Question</th>
                    <th>Answer Preview</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td><?= $faq['id'] ?></td>
                        <td><span class="badge bg-light text-dark border"><?= esc($faq['category']) ?></span></td>
                        <td><strong class="text-dark"><?= esc($faq['question']) ?></strong></td>
                        <td><div class="text-muted small text-truncate" style="max-width: 300px;"><?= esc($faq['answer']) ?></div></td>
                        <td><?= $faq['sort_order'] ?></td>
                        <td>
                            <span class="badge <?= $faq['is_active'] ? 'bg-success' : 'bg-secondary' ?>"><?= $faq['is_active'] ? 'Active' : 'Inactive' ?></span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('admin/faqs/edit/' . $faq['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/faqs/delete/' . $faq['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this FAQ?')">
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
