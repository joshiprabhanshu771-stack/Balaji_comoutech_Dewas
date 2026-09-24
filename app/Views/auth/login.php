<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-person-fill-lock fs-2"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Sign In to Your Account</h3>
                    <p class="text-muted small">Access your inquiries, saved wishlist, and shopkeeper replies.</p>
                </div>

                <form action="<?= base_url('auth/login') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control border-start-0 ps-0" required placeholder="name@example.com" value="<?= old('email') ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label fw-semibold">Password</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 ps-0" required placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mt-2 shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </button>
                </form>

                <div class="mt-4 pt-3 border-top text-center">
                    <p class="text-muted small mb-0">Don't have an account? <a href="<?= base_url('auth/register') ?>" class="text-primary fw-bold text-decoration-none">Create an Account</a></p>
                </div>

                <div class="mt-3 p-3 bg-light rounded-3 small text-muted text-center border">
                    <strong>Demo Credentials:</strong><br>
                    Admin: <code>admin@example.com</code> / <code>admin123</code><br>
                    Customer: <code>customer@example.com</code> / <code>customer123</code>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
