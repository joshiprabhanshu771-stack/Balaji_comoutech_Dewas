<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-person-gear text-primary me-2"></i> Edit User: <?= esc($user['name']) ?></h4>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?= base_url('admin/users/update/' . $user['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">User Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required value="<?= old('name', $user['name']) ?>">
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" required value="<?= old('email', $user['email']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                <input type="tel" name="mobile" class="form-control" required value="<?= old('mobile', $user['mobile']) ?>">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                <select name="role_id" class="form-select" required>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= old('role_id', $user['role_id']) == $r['id'] ? 'selected' : '' ?>><?= ucfirst(esc($r['name'])) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active" <?= old('status', $user['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= old('status', $user['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="blocked" <?= old('status', $user['status']) === 'blocked' ? 'selected' : '' ?>>Blocked</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Reset Password (Leave blank to keep unchanged)</label>
            <input type="password" name="new_password" class="form-control" placeholder="New password...">
        </div>

        <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
            <i class="bi bi-check-lg me-1"></i> Update User Account
        </button>
    </form>
</div>

<?= $this->endSection() ?>
