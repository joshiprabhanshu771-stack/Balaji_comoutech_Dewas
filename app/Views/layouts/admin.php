<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($page_title ?? 'Admin Dashboard | Balaji Computech') ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- PWA & Mobile Meta -->
    <link rel="manifest" href="<?= base_url('manifest.webmanifest') ?>">
    <meta name="theme-color" content="#0d6efd">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

<div class="admin-wrapper">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header d-flex align-items-center justify-content-between">
            <a href="<?= base_url('admin/dashboard') ?>" class="text-white text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-cpu-fill text-primary fs-4"></i>
                <span class="fs-6 fw-bold">BALAJI ADMIN</span>
            </a>
        </div>

        <ul class="admin-sidebar-nav">
            <li class="nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= uri_string() === 'admin' || uri_string() === 'admin/dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/inquiries') ?>" class="nav-link <?= strpos(uri_string(), 'admin/inquiries') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-chat-left-text-fill"></i> Inquiries
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/products') ?>" class="nav-link <?= strpos(uri_string(), 'admin/products') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-box-seam-fill"></i> Products
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/categories') ?>" class="nav-link <?= strpos(uri_string(), 'admin/categories') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-folder-fill"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/brands') ?>" class="nav-link <?= strpos(uri_string(), 'admin/brands') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-tags-fill"></i> Brands
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/services') ?>" class="nav-link <?= strpos(uri_string(), 'admin/services') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-tools"></i> Services & Repairs
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/offers') ?>" class="nav-link <?= strpos(uri_string(), 'admin/offers') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-percent"></i> Offers & Deals
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/faqs') ?>" class="nav-link <?= strpos(uri_string(), 'admin/faqs') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-question-circle-fill"></i> FAQs
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/pages') ?>" class="nav-link <?= strpos(uri_string(), 'admin/pages') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-file-text-fill"></i> Content Pages
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/presence') ?>" class="nav-link <?= strpos(uri_string(), 'admin/presence') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-geo-alt-fill"></i> Store Presence
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/contact-messages') ?>" class="nav-link <?= strpos(uri_string(), 'admin/contact-messages') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-envelope-fill"></i> Contact Messages
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/users') ?>" class="nav-link <?= strpos(uri_string(), 'admin/users') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-people-fill"></i> Users & Customers
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/settings') ?>" class="nav-link <?= strpos(uri_string(), 'admin/settings') === 0 ? 'active' : '' ?>">
                    <i class="bi bi-sliders"></i> Site Settings
                </a>
            </li>
            
            <li class="nav-item mt-3 pt-3 border-top border-secondary border-opacity-25">
                <a href="<?= base_url('/') ?>" target="_blank" class="nav-link text-info">
                    <i class="bi bi-box-arrow-up-right"></i> View Website
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> Sign Out
                </a>
            </li>
        </ul>
    </aside>

    <!-- Admin Main Content Area -->
    <div class="admin-main-content">
        <!-- Admin Topbar -->
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <h5 class="mb-0 fw-bold text-dark"><?= esc($page_title ?? 'Admin Dashboard') ?></h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small">Logged in as: <strong class="text-dark"><?= esc(session()->get('user_name') ?? 'Admin (Gourav Joshi)') ?></strong></span>
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </header>

        <!-- Admin Body -->
        <div class="admin-content-body">
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-octagon-fill me-2"></i> Please fix the following errors:</div>
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Main JS -->
<script src="<?= base_url('assets/js/main.js') ?>"></script>
<!-- Push Notifications JS -->
<script src="<?= base_url('assets/js/notifications.js') ?>"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
