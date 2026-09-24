<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-person-plus-fill fs-2"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Create Customer Account</h3>
                    <p class="text-muted small">Join Balaji Computech to track your inquiries, request custom quotes, and save products.</p>
                </div>

                <form action="<?= base_url('auth/register') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" class="form-control border-start-0 ps-0" required placeholder="e.g. Ramesh Patel" value="<?= old('name') ?>">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0" required placeholder="name@example.com" value="<?= old('email') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-phone"></i></span>
                                <input type="tel" name="mobile" class="form-control border-start-0 ps-0" required placeholder="98260 00000" value="<?= old('mobile') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" required placeholder="Min 6 characters">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-shield-check"></i></span>
                                <input type="password" name="confirm_password" class="form-control border-start-0 ps-0" required placeholder="Re-enter password">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mt-2 shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Register Account
                    </button>
                </form>

                <div class="mt-4 pt-3 border-top text-center">
                    <p class="text-muted small mb-0">Already have an account? <a href="<?= base_url('auth/login') ?>" class="text-primary fw-bold text-decoration-none">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
