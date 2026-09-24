<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- 1. HERO SECTION -->
<section class="hero-section">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="bi bi-patch-check-fill text-info"></i> Official IT Hardware & Repair Hub in Dewas
                </div>
                <h1 class="hero-title">
                    High Performance Computers & <span class="text-warning">Expert Repair</span> Services
                </h1>
                <p class="hero-subtitle">
                    <?= esc(get_setting('hero_subtitle', 'Welcome to Balaji Computech, Dewas. Discover top brand laptops, high-performance desktop components, security CCTV systems, and expert chip-level repairing.')) ?>
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="<?= base_url('products') ?>" class="btn btn-warning btn-lg fw-bold px-4 py-3 shadow">
                        <i class="bi bi-grid-3x3-gap-fill me-2"></i> Browse Products
                    </a>
                    <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I would like to inquire about laptops, computer parts, or repair services.') ?>" target="_blank" class="btn btn-outline-light btn-lg fw-bold px-4 py-3">
                        <i class="bi bi-whatsapp me-2 text-success"></i> WhatsApp Inquiry
                    </a>
                </div>

                <!-- Trust Stats -->
                <div class="row g-3 pt-3 border-top border-light border-opacity-25">
                    <div class="col-6 col-sm-3">
                        <div class="fw-bold fs-4 text-warning">100%</div>
                        <div class="text-light opacity-75 small">Genuine Hardware</div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="fw-bold fs-4 text-info">10+ Years</div>
                        <div class="text-light opacity-75 small">Local Tech Trust</div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="fw-bold fs-4 text-warning">5,000+</div>
                        <div class="text-light opacity-75 small">Happy Customers</div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="fw-bold fs-4 text-info">24 - 48h</div>
                        <div class="text-light opacity-75 small">Fast Lab Repair</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 text-center">
                <div class="bg-white bg-opacity-10 p-4 rounded-4 backdrop-blur border border-white border-opacity-20 shadow-lg text-start">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-warning text-dark p-3 rounded-circle fs-3 fw-bold">
                            <i class="bi bi-shop"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-white mb-0">Balaji Computech</h4>
                            <span class="badge bg-info text-dark">Proprietor: Gourav Joshi</span>
                        </div>
                    </div>
                    <p class="text-light small mb-3">
                        Located at Mainashree Complex, Near Netram, AB Road, Dewas. Visit our showroom or send an inquiry online for direct shopkeeper pricing!
                    </p>
                    <ul class="list-unstyled text-light small mb-4 d-flex flex-column gap-2">
                        <li><i class="bi bi-check-circle-fill text-warning me-2"></i> Laptops, Desktops & Custom Gaming PCs</li>
                        <li><i class="bi bi-check-circle-fill text-warning me-2"></i> Motherboard Chip-Level Repairing</li>
                        <li><i class="bi bi-check-circle-fill text-warning me-2"></i> Full HD CCTV Camera Sales & Setup</li>
                        <li><i class="bi bi-check-circle-fill text-warning me-2"></i> Free Technical Consultation & Quotes</li>
                    </ul>
                    <a href="<?= base_url('contact') ?>" class="btn btn-light w-100 fw-bold py-2">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> Visit Shop / Get Directions
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. PRODUCT CATEGORIES -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">Explore By Category</span>
            <h2 class="section-title">Popular Product Categories</h2>
            <p class="section-subtitle">Find high quality computer hardware, peripherals, and security devices tailored to your needs.</p>
        </div>

        <div class="row g-4">
            <?php foreach ($allCategories as $cat): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="<?= base_url('products?category=' . esc($cat['slug'])) ?>" class="text-decoration-none">
                        <div class="custom-card p-4 text-center">
                            <div class="bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center rounded-circle mx-auto mb-3" style="width: 70px; height: 70px;">
                                <i class="<?= esc($cat['icon'] ?: 'bi bi-laptop') ?> fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1"><?= esc($cat['name']) ?></h5>
                            <p class="text-muted small mb-0"><?= esc($cat['description']) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 3. HOT DEALS & FEATURED PRODUCTS -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
            <div>
                <span class="section-tag">Handpicked For You</span>
                <h2 class="section-title mb-0">Featured Hardware & Deals</h2>
            </div>
            <a href="<?= base_url('products') ?>" class="btn btn-outline-primary fw-bold">
                View All Products <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredProducts as $product): ?>
                <?php 
                    $isInWishlist = in_array($product['id'], $userWishlistIds ?? []);
                    $waProductMsg = "Hello Gourav Joshi,\n\nI am interested in:\nProduct: {$product['name']}\nPrice: ₹" . number_format($product['discount_price'] ?? $product['price'], 2) . "\nLink: " . base_url('products/' . $product['slug']) . "\n\nPlease let me know best price and availability.";
                ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card product-card">
                        <!-- Stock Badge -->
                        <?php if ($product['stock_status'] === 'in_stock'): ?>
                            <span class="badge bg-success badge-stock"><i class="bi bi-check-circle me-1"></i> In Stock</span>
                        <?php elseif ($product['stock_status'] === 'on_demand'): ?>
                            <span class="badge bg-warning text-dark badge-stock"><i class="bi bi-clock me-1"></i> On Demand</span>
                        <?php else: ?>
                            <span class="badge bg-danger badge-stock"><i class="bi bi-x-circle me-1"></i> Out of Stock</span>
                        <?php endif; ?>

                        <!-- Wishlist Toggle -->
                        <button type="button" class="btn-wishlist btn-wishlist-toggle <?= $isInWishlist ? 'active' : '' ?>" data-product-id="<?= $product['id'] ?>" title="Save to Wishlist">
                            <i class="bi <?= $isInWishlist ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                        </button>

                        <!-- Product Image Placeholder or Upload -->
                        <a href="<?= base_url('products/' . esc($product['slug'])) ?>" class="product-img-wrapper text-decoration-none">
                            <div class="text-center p-3 text-primary">
                                <i class="bi bi-pc-display fs-1"></i>
                            </div>
                        </a>

                        <div class="product-info">
                            <span class="product-cat"><?= esc($product['category_name'] ?? 'Computers') ?></span>
                            <a href="<?= base_url('products/' . esc($product['slug'])) ?>" class="product-title">
                                <?= esc($product['name']) ?>
                            </a>

                            <div class="product-price-box d-flex align-items-baseline mb-3">
                                <?php if ($product['discount_price']): ?>
                                    <span class="product-price">₹<?= number_format($product['discount_price'], 2) ?></span>
                                    <span class="product-old-price">₹<?= number_format($product['price'], 2) ?></span>
                                <?php elseif ($product['price']): ?>
                                    <span class="product-price">₹<?= number_format($product['price'], 2) ?></span>
                                <?php else: ?>
                                    <span class="product-price text-muted fs-6">Contact for Price</span>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-product-id="<?= $product['id'] ?>" data-product-name="<?= esc($product['name']) ?>">
                                    <i class="bi bi-chat-dots me-1"></i> Inquire Price
                                </button>
                                <a href="<?= get_whatsapp_url($waProductMsg) ?>" target="_blank" class="btn btn-outline-success btn-sm fw-bold">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 4. SERVICES SECTION -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">Professional Lab & Onsite Support</span>
            <h2 class="section-title">Computer Repair & Technical Services</h2>
            <p class="section-subtitle">From microscopic chip-level motherboard repairing to complete enterprise CCTV installations in Dewas.</p>
        </div>

        <div class="row g-4">
            <?php foreach ($services as $srv): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100 d-flex flex-direction-column justify-content-between">
                        <div>
                            <div class="service-icon-box">
                                <i class="<?= esc($srv['icon'] ?: 'bi bi-tools') ?>"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-2"><?= esc($srv['name']) ?></h4>
                            <p class="text-muted small mb-3"><?= esc($srv['short_description']) ?></p>

                            <div class="d-flex align-items-center justify-content-between bg-light p-2 rounded-3 mb-3 small">
                                <span><i class="bi bi-clock-history text-primary me-1"></i> <strong><?= esc($srv['turnaround_time'] ?: 'Same Day') ?></strong></span>
                                <span class="text-success fw-bold">From ₹<?= number_format($srv['starting_price'], 2) ?></span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="<?= base_url('services/' . esc($srv['slug'])) ?>" class="btn btn-outline-primary btn-sm fw-bold w-100">
                                View Details
                            </a>
                            <button type="button" class="btn btn-primary btn-sm fw-bold w-100" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-service-id="<?= $srv['id'] ?>" data-service-name="<?= esc($srv['name']) ?>">
                                Book Service
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 5. PROMOTIONAL OFFERS & COUPONS -->
<?php if (!empty($offers)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">Special Savings</span>
            <h2 class="section-title">Upgrade Deals & Active Offers</h2>
            <p class="section-subtitle">Take advantage of limited-time discounts on hardware upgrades and surveillance packages.</p>
        </div>

        <div class="row g-4">
            <?php foreach ($offers as $off): ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white border-top border-4 border-warning">
                        <div class="badge bg-warning text-dark align-self-start mb-3 fw-bold px-3 py-2 fs-6">
                            <i class="bi bi-tag-fill me-1"></i> <?= esc($off['discount_text']) ?>
                        </div>
                        <h4 class="fw-bold text-dark mb-2"><?= esc($off['title']) ?></h4>
                        <p class="text-muted small mb-4"><?= esc($off['description']) ?></p>

                        <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                            <?php if ($off['coupon_code']): ?>
                                <button type="button" class="btn btn-sm btn-outline-dark btn-copy-code fw-semibold" data-code="<?= esc($off['coupon_code']) ?>">
                                    <i class="bi bi-clipboard me-1"></i> Code: <?= esc($off['coupon_code']) ?>
                                </button>
                            <?php endif; ?>
                            <a href="<?= base_url('contact') ?>" class="btn btn-sm btn-primary fw-bold">
                                Claim Deal
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 6. AUTHORIZED BRANDS -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">Trusted Technology Partners</span>
            <h2 class="section-title">Top Brands Available</h2>
            <p class="section-subtitle">We supply 100% genuine products directly from leading global manufacturers.</p>
        </div>

        <div class="row g-3 justify-content-center">
            <?php foreach ($featuredBrands as $br): ?>
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="<?= base_url('brands/' . esc($br['slug'])) ?>" class="brand-item">
                        <i class="bi bi-award-fill text-primary fs-3 mb-1"></i>
                        <span><?= esc($br['name']) ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 7. WHY CHOOSE US -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-warning text-dark px-3 py-2 mb-2">Why Balaji Computech</span>
            <h2 class="fw-bold text-white">Your Trusted IT Hardware Partner in Dewas</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3 text-center">
                <div class="p-3">
                    <div class="bg-white bg-opacity-20 text-warning d-inline-flex p-3 rounded-circle fs-2 mb-3">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5 class="fw-bold">100% Authentic Parts</h5>
                    <p class="text-light opacity-75 small">All hardware and components carry official brand manufacturer warranties.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 text-center">
                <div class="p-3">
                    <div class="bg-white bg-opacity-20 text-warning d-inline-flex p-3 rounded-circle fs-2 mb-3">
                        <i class="bi bi-cpu"></i>
                    </div>
                    <h5 class="fw-bold">Certified Lab Repair</h5>
                    <p class="text-light opacity-75 small">Advanced BGA rework stations and microscopic diagnostics for motherboard repairs.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 text-center">
                <div class="p-3">
                    <div class="bg-white bg-opacity-20 text-warning d-inline-flex p-3 rounded-circle fs-2 mb-3">
                        <i class="bi bi-currency-rupee"></i>
                    </div>
                    <h5 class="fw-bold">Transparent Best Pricing</h5>
                    <p class="text-light opacity-75 small">Honest quotation with no hidden charges and direct distributor rate benefits.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 text-center">
                <div class="p-3">
                    <div class="bg-white bg-opacity-20 text-warning d-inline-flex p-3 rounded-circle fs-2 mb-3">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <h5 class="fw-bold">Personalized Support</h5>
                    <p class="text-light opacity-75 small">Directly consult with Gourav Joshi and our certified technicians anytime.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. FREQUENTLY ASKED QUESTIONS -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">Got Questions?</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion shadow-sm" id="homeFaqAccordion">
                    <?php foreach ($faqs as $idx => $faq): ?>
                        <div class="accordion-item border mb-2 rounded-3 overflow-hidden">
                            <h2 class="accordion-header" id="headingFaq<?= $idx ?>">
                                <button class="accordion-button <?= $idx !== 0 ? 'collapsed' : '' ?> fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq<?= $idx ?>" aria-expanded="<?= $idx === 0 ? 'true' : 'false' ?>" aria-controls="collapseFaq<?= $idx ?>">
                                    <?= esc($faq['question']) ?>
                                </button>
                            </h2>
                            <div id="collapseFaq<?= $idx ?>" class="accordion-collapse collapse <?= $idx === 0 ? 'show' : '' ?>" aria-labelledby="headingFaq<?= $idx ?>" data-bs-parent="#homeFaqAccordion">
                                <div class="accordion-body text-muted small">
                                    <?= esc($faq['answer']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-4">
                    <a href="<?= base_url('faq') ?>" class="btn btn-outline-secondary btn-sm fw-bold">
                        View All FAQs <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 9. PHYSICAL STORE PRESENCE & MAP -->
<section class="py-5 bg-light border-top">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <span class="section-tag">Visit Our Showroom</span>
                <h2 class="section-title mb-3">Our Store Presence in Dewas</h2>
                <p class="text-muted small mb-4">
                    Experience hardware hands-on, get free diagnostics, or pick up your orders at our store located on main AB Road, Dewas.
                </p>

                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white mb-3">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <i class="bi bi-geo-alt-fill text-danger fs-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Balaji Computech - Store & Lab</h6>
                            <p class="text-muted small mb-0"><?= esc(get_setting('shop_address')) ?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <i class="bi bi-telephone-fill text-success fs-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Call for Direct Inquiry</h6>
                            <p class="text-muted small mb-0"><?= esc(get_setting('contact_phone')) ?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-clock-fill text-primary fs-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Operating Hours</h6>
                            <p class="text-muted small mb-0"><?= esc(get_setting('opening_hours')) ?></p>
                        </div>
                    </div>
                </div>

                <a href="<?= base_url('contact') ?>" class="btn btn-primary fw-bold w-100 py-2">
                    <i class="bi bi-chat-square-dots-fill me-1"></i> Send Direct Message
                </a>
            </div>

            <div class="col-lg-7">
                <div class="rounded-4 overflow-hidden shadow-sm border border-2 border-white" style="min-height: 380px;">
                    <?= get_setting('google_maps_embed') ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
