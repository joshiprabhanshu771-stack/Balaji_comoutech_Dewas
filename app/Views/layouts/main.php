<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($page_title ?? 'Balaji Computech - Computer Shop & Repair Center in Dewas') ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= esc(get_setting('meta_description', 'Balaji Computech is Dewas\'s premier computer store for laptops, custom gaming PCs, CCTV security, printer repairs, and IT hardware.')) ?>">
    <meta name="keywords" content="computer shop dewas, laptop repair dewas, cctv installation dewas, custom gaming pc, gourav joshi, balaji computech">

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
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-geo-alt-fill text-warning me-1"></i> <?= esc(get_setting('shop_address', 'Mainashree Complex, Near Netram, AB Road, Dewas, MP')) ?></span>
                <span class="d-none d-md-inline">|</span>
                <span class="d-none d-md-inline"><i class="bi bi-clock-fill text-info me-1"></i> Mon-Sat: 10AM - 8:30PM</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="tel:<?= esc(get_setting('contact_phone', '+919826012345')) ?>" class="fw-semibold">
                    <i class="bi bi-telephone-fill text-success me-1"></i> <?= esc(get_setting('contact_phone', '+91 98260 12345')) ?>
                </a>
                <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I would like to inquire about products and services at Balaji Computech.') ?>" target="_blank" class="fw-semibold text-success">
                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-main sticky-top">
        <div class="container">
            <a class="navbar-brand navbar-brand-logo" href="<?= base_url('/') ?>">
                <i class="bi bi-cpu-fill fs-3 text-primary"></i>
                <span>BALAJI <span class="logo-accent">COMPUTECH</span></span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainContent" aria-controls="navbarMainContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMainContent">
                <!-- Search Form -->
                <form class="d-flex my-2 my-lg-0 mx-auto header-search-form" action="<?= base_url('products') ?>" method="GET" style="max-width: 420px; width: 100%;">
                    <input class="form-control" type="search" name="q" placeholder="Search laptops, processors, CCTV, printers..." aria-label="Search" value="<?= esc($_GET['q'] ?? '') ?>">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <!-- Navigation Links -->
                <ul class="navbar-nav ms-auto align-items-lg-center mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() === '' ? 'active' : '' ?>" href="<?= base_url('/') ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'products') === 0 ? 'active' : '' ?>" href="<?= base_url('products') ?>">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'services') === 0 ? 'active' : '' ?>" href="<?= base_url('services') ?>">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'offers') === 0 ? 'active' : '' ?>" href="<?= base_url('offers') ?>">Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() === 'contact' ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Contact</a>
                    </li>

                    <!-- User Account / Auth Dropdown -->
                    <?php if (session()->get('isLoggedIn')): ?>
                        <?php if (is_admin()): ?>
                            <li class="nav-item ms-lg-2">
                                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-sm btn-dark d-flex align-items-center gap-1">
                                    <i class="bi bi-speedometer2"></i> Admin Panel
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item ms-lg-2">
                                <a href="<?= base_url('dashboard/wishlist') ?>" class="btn btn-sm btn-outline-danger position-relative me-2" title="Wishlist">
                                    <i class="bi bi-heart-fill"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown ms-lg-1">
                                <a class="nav-link dropdown-toggle btn btn-sm btn-light border px-3" href="#" id="userMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle text-primary me-1"></i> <?= esc(session()->get('user_name')) ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenuDropdown">
                                    <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>"><i class="bi bi-grid me-2 text-primary"></i> Dashboard</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('dashboard/inquiries') ?>"><i class="bi bi-chat-left-dots me-2 text-info"></i> My Inquiries</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('dashboard/wishlist') ?>"><i class="bi bi-heart me-2 text-danger"></i> My Wishlist</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('dashboard/profile') ?>"><i class="bi bi-gear me-2 text-secondary"></i> Profile Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item ms-lg-2">
                            <a href="<?= base_url('auth/login') ?>" class="btn btn-sm btn-outline-primary px-3 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Global Flash Messages -->
    <div class="container mt-3">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-octagon-fill me-2"></i> Please fix the following errors:</div>
                <ul class="mb-0 ps-3">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Main Content Body -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Floating WhatsApp Action Button -->
    <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I am on the Balaji Computech website and would like to inquire about products/services.') ?>" target="_blank" class="btn-whatsapp-floating" title="Chat with Gourav Joshi on WhatsApp" aria-label="Chat on WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <!-- Global Quick Inquiry Modal -->
    <div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="inquiryModalLabel"><i class="bi bi-chat-square-quote-fill me-2"></i> Submit Product / Service Inquiry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('inquiry/submit') ?>" method="POST" id="globalInquiryForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" id="inquiryProductId" value="">
                    <input type="hidden" name="service_id" id="inquiryServiceId" value="">
                    <input type="hidden" name="inquiry_type" id="inquiryType" value="general">

                    <div class="modal-body p-4">
                        <div class="alert alert-info py-2 px-3 small mb-3">
                            <i class="bi bi-info-circle-fill me-1"></i> Inquiring regarding: <strong id="inquiryItemTitle">General Inquiry</strong>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Your Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required value="<?= esc(session()->get('user_name') ?? '') ?>" placeholder="e.g. Ramesh Patel">
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required value="<?= esc(session()->get('user_email') ?? '') ?>" placeholder="name@example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" name="mobile" class="form-control" required placeholder="+91 98260 00000">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subject</label>
                            <input type="text" name="subject" id="inquirySubject" class="form-control" placeholder="Best price & availability inquiry">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message / Requirement Details <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="4" required placeholder="Please tell us your specific requirement, quantity, or questions..."></textarea>
                        </div>

                        <p class="text-muted small mb-0">
                            <i class="bi bi-shield-check text-success"></i> No payment needed. Our shopkeeper Gourav Joshi will review your request and get back with best quotes.
                        </p>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4"><i class="bi bi-send-fill me-1"></i> Send Inquiry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Website Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <!-- Col 1: Shop Info -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-cpu-fill fs-2 text-primary"></i>
                        <h4 class="text-white fw-bold mb-0">BALAJI COMPUTECH</h4>
                    </div>
                    <p class="text-muted small mb-3">
                        Dewas's most dependable IT destination founded by <strong>Gourav Joshi</strong>. Authorized dealer for top laptops, custom gaming PCs, CCTV security setups, and high-precision chip-level repair services.
                    </p>
                    <div class="d-flex flex-column gap-2 text-muted small">
                        <div><i class="bi bi-geo-alt-fill text-warning me-2"></i> <?= esc(get_setting('shop_address', 'Shop No. 12, Mainashree Complex, Near Netram, AB Road, Dewas, MP')) ?></div>
                        <div><i class="bi bi-telephone-fill text-success me-2"></i> <?= esc(get_setting('contact_phone', '+91 98260 12345')) ?></div>
                        <div><i class="bi bi-envelope-fill text-info me-2"></i> <?= esc(get_setting('contact_email', 'info@balajicomputech.com')) ?></div>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="<?= base_url('/') ?>"><i class="bi bi-chevron-right me-1 text-primary"></i> Home</a></li>
                        <li><a href="<?= base_url('products') ?>"><i class="bi bi-chevron-right me-1 text-primary"></i> Products Catalog</a></li>
                        <li><a href="<?= base_url('services') ?>"><i class="bi bi-chevron-right me-1 text-primary"></i> Repair Services</a></li>
                        <li><a href="<?= base_url('brands') ?>"><i class="bi bi-chevron-right me-1 text-primary"></i> Brands & Partners</a></li>
                        <li><a href="<?= base_url('offers') ?>"><i class="bi bi-chevron-right me-1 text-primary"></i> Deals & Offers</a></li>
                        <li><a href="<?= base_url('our-presence') ?>"><i class="bi bi-chevron-right me-1 text-primary"></i> Store Location</a></li>
                        <li><a href="<?= base_url('faq') ?>"><i class="bi bi-chevron-right me-1 text-primary"></i> FAQs</a></li>
                    </ul>
                </div>

                <!-- Col 3: Hardware & Services -->
                <div class="col-lg-3 col-md-6">
                    <h5>Categories & Solutions</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="<?= base_url('products?category=laptops') ?>"><i class="bi bi-laptop me-2"></i> Laptops & Notebooks</a></li>
                        <li><a href="<?= base_url('products?category=desktop-pcs') ?>"><i class="bi bi-pc-display me-2"></i> Desktop & Workstations</a></li>
                        <li><a href="<?= base_url('products?category=pc-components') ?>"><i class="bi bi-cpu me-2"></i> PC Components & CPUs</a></li>
                        <li><a href="<?= base_url('products?category=cctv-security') ?>"><i class="bi bi-camera-video me-2"></i> CCTV & Security Systems</a></li>
                        <li><a href="<?= base_url('services/chip-level-laptop-motherboard-repair') ?>"><i class="bi bi-tools me-2"></i> Chip-Level Motherboard Repair</a></li>
                        <li><a href="<?= base_url('services/custom-pc-build-gaming-assembly') ?>"><i class="bi bi-gear-wide-connected me-2"></i> Custom PC Assembling</a></li>
                    </ul>
                </div>

                <!-- Col 4: Shop Timing & Inquiry Direct -->
                <div class="col-lg-3 col-md-6">
                    <h5>Working Hours & Help</h5>
                    <div class="bg-dark p-3 rounded-3 mb-3 border border-secondary border-opacity-25 small text-light">
                        <div class="fw-bold text-info mb-1"><i class="bi bi-clock me-1"></i> Shop Timings:</div>
                        <div><?= esc(get_setting('opening_hours', 'Mon - Sat: 10:00 AM - 08:30 PM | Sun: 11:00 AM - 04:00 PM')) ?></div>
                    </div>
                    <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I need assistance regarding computer sales/repair.') ?>" target="_blank" class="btn btn-success w-100 fw-bold py-2 mb-2 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-whatsapp fs-5"></i> Chat on WhatsApp
                    </a>
                    <a href="<?= base_url('contact') ?>" class="btn btn-outline-light w-100 fw-semibold py-2">
                        <i class="bi bi-geo-alt me-1"></i> Visit Our Store in Dewas
                    </a>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    &copy; <?= date('Y') ?> <strong>Balaji Computech</strong>. Owned & Managed by <strong>Gourav Joshi</strong>. All rights reserved.
                </div>
                <div class="d-flex gap-3">
                    <a href="<?= base_url('page/about-us') ?>">About Us</a>
                    <a href="<?= base_url('page/terms-and-conditions') ?>">Terms</a>
                    <a href="<?= base_url('page/privacy-policy') ?>">Privacy Policy</a>
                    <a href="<?= base_url('page/return-and-inquiry-policy') ?>">Inquiry Policy</a>
                    <a href="<?= base_url('page/disclaimer') ?>">Disclaimer</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Main JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <!-- Push Notifications JS -->
    <script src="<?= base_url('assets/js/notifications.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
