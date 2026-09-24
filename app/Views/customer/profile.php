<?= $this->extend('layouts/customer') ?>

<?= $this->section('customer_content') ?>

<div class="row g-4">
    <!-- Edit Personal Information -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-person-fill text-primary me-2"></i> Account Details</h5>
            
            <form action="<?= base_url('dashboard/profile/update') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Full Name</label>
                    <input type="text" name="name" class="form-control" required value="<?= old('name', $user['name']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email Address</label>
                    <input type="email" name="email" class="form-control" required value="<?= old('email', $user['email']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Mobile Phone</label>
                    <input type="tel" name="mobile" class="form-control" required value="<?= old('mobile', $user['mobile']) ?>">
                </div>

                <button type="submit" class="btn btn-primary fw-bold px-4 py-2 mt-2">
                    <i class="bi bi-check2 me-1"></i> Save Changes
                </button>
            </form>
        </div>
    </div>

    <!-- Change Password -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-shield-lock-fill text-danger me-2"></i> Update Password</h5>

            <form action="<?= base_url('dashboard/profile/change-password') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required placeholder="••••••••">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">New Password</label>
                    <input type="password" name="new_password" class="form-control" required placeholder="Min 6 characters">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required placeholder="Re-enter new password">
                </div>

                <button type="submit" class="btn btn-outline-danger fw-bold px-4 py-2 mt-2">
                    <i class="bi bi-key me-1"></i> Change Password
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
