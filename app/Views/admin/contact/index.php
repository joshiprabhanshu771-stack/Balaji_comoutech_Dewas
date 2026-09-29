<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-envelope-fill text-danger me-2"></i> Contact Form Messages</h4>
    </div>

    <?php if (empty($messages)): ?>
        <div class="p-5 text-center text-muted">
            <i class="bi bi-envelope-open fs-1 mb-2 d-block"></i>
            <p class="mb-0">No contact messages received yet.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr class="text-muted text-uppercase">
                        <th>#</th>
                        <th>Sender Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr class="<?= !empty($msg['is_read']) ? '' : 'table-warning' ?>">
                            <td><?= (int)($msg['id'] ?? 0) ?></td>
                            <td><strong class="text-dark"><?= esc($msg['name'] ?? '') ?></strong></td>
                            <td>
                                <a href="tel:<?= esc($msg['mobile'] ?? '') ?>" class="text-decoration-none text-dark fw-semibold">
                                    <?= esc(format_indian_mobile($msg['mobile'] ?? '', true)) ?>
                                </a>
                            </td>
                            <td>
                                <a href="mailto:<?= esc($msg['email'] ?? '') ?>" class="text-decoration-none text-muted">
                                    <?= esc($msg['email'] ?? '') ?>
                                </a>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 250px;">
                                    <?= esc($msg['subject'] ?? '') ?>
                                </div>
                            </td>
                            <td>
                                <?= !empty($msg['created_at']) ? date('d M Y, h:i A', strtotime($msg['created_at'])) : '—' ?>
                            </td>
                            <td>
                                <?= !empty($msg['is_read']) ? '<span class="badge bg-secondary">Read</span>' : '<span class="badge bg-danger">Unread</span>' ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('admin/contact-messages/' . ($msg['id'] ?? 0)) ?>" class="btn btn-sm btn-outline-primary" title="View Message">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/contact-messages/delete/' . ($msg['id'] ?? 0)) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this message?')">
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
