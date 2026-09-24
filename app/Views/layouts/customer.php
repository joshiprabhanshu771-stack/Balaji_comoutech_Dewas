<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-primary bg-opacity-10 py-4 mb-4 border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="fw-bold text-dark mb-1"><?= esc($page_title ?? 'Customer Dashboard') ?></h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page"><?= esc($page_title ?? 'My Account') ?></li>
                    </ol>
                </nav>
            </div>
            <div>
                <span class="badge bg-primary px-3 py-2 fs-6">Customer Account</span>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <!-- Customer Left Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="customer-sidebar-card shadow-sm">
                <div class="customer-user-header">
                    <i class="bi bi-person-circle fs-1 mb-2 d-inline-block"></i>
                    <h5 class="fw-bold mb-1 text-white"><?= esc(session()->get('user_name')) ?></h5>
                    <p class="small text-white-50 mb-0"><?= esc(session()->get('user_email')) ?></p>
                </div>
                <ul class="customer-nav-list">
                    <li>
                        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= uri_string() === 'dashboard' ? 'active' : '' ?>">
                            <i class="bi bi-grid-fill text-primary"></i> Dashboard Overview
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('dashboard/inquiries') ?>" class="nav-link <?= strpos(uri_string(), 'dashboard/inquiries') === 0 ? 'active' : '' ?>">
                            <i class="bi bi-chat-left-dots-fill text-info"></i> My Inquiries & Replies
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('dashboard/wishlist') ?>" class="nav-link <?= strpos(uri_string(), 'dashboard/wishlist') === 0 ? 'active' : '' ?>">
                            <i class="bi bi-heart-fill text-danger"></i> My Saved Wishlist
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('dashboard/profile') ?>" class="nav-link <?= strpos(uri_string(), 'dashboard/profile') === 0 ? 'active' : '' ?>">
                            <i class="bi bi-person-fill-gear text-secondary"></i> Profile & Password
                        </a>
                    </li>
                    <li class="border-top pt-2 mt-2">
                        <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right"></i> Sign Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Customer Inner Content -->
        <div class="col-lg-9">
            <?= $this->renderSection('customer_content') ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
