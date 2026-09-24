<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-people-fill text-primary me-2"></i> User & Customer Accounts</h4>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr class="text-muted text-uppercase">
                    <th>#</th>
                    <th>User Name</th>
                    <th>Email Address</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Registered Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><strong class="text-dark"><?= esc($u['name']) ?></strong></td>
                        <td><?= esc($u['email']) ?></td>
                        <td><?= esc($u['mobile']) ?></td>
                        <td>
                            <?php if ($u['role_id'] == 1): ?>
                                <span class="badge bg-danger">Administrator</span>
                            <?php else: ?>
                                <span class="badge bg-primary">Customer</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($u['status'] === 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php elseif ($u['status'] === 'blocked'): ?>
                                <span class="badge bg-danger">Blocked</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('admin/users/edit/' . $u['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
