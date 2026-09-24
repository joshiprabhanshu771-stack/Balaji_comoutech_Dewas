<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('products') ?>" class="text-decoration-none text-muted">Products</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('products?category=' . esc($product['category_slug'])) ?>" class="text-decoration-none text-muted"><?= esc($product['category_name']) ?></a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page"><?= esc($product['name']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5 mb-5">
        <!-- Left: Product Image Gallery -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white position-relative">
                <!-- Wishlist button -->
                <button type="button" class="btn-wishlist btn-wishlist-toggle <?= $inWishlist ? 'active' : '' ?>" data-product-id="<?= $product['id'] ?>" title="Save to Wishlist">
                    <i class="bi <?= $inWishlist ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                </button>

                <div class="p-4 d-flex align-items-center justify-content-center" style="min-height: 320px;">
                    <i class="bi bi-pc-display text-primary" style="font-size: 7rem;"></i>
                </div>
            </div>

            <!-- Shop Info Card -->
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-light mt-3 border">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-shield-check text-success fs-2"></i>
                    <div>
                        <h6 class="fw-bold mb-0">100% Brand New & Genuine</h6>
                        <span class="small text-muted">Official manufacturer warranty support across India.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Product Information & Inquire Actions -->
        <div class="col-lg-7">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary px-3 py-1"><?= esc($product['category_name']) ?></span>
                <?php if (!empty($product['brand_name'])): ?>
                    <span class="badge bg-secondary px-3 py-1"><?= esc($product['brand_name']) ?></span>
                <?php endif; ?>
                <?php if ($product['stock_status'] === 'in_stock'): ?>
                    <span class="badge bg-success px-3 py-1"><i class="bi bi-check-circle me-1"></i> In Stock</span>
                <?php elseif ($product['stock_status'] === 'on_demand'): ?>
                    <span class="badge bg-warning text-dark px-3 py-1"><i class="bi bi-clock me-1"></i> On Demand (24h)</span>
                <?php else: ?>
                    <span class="badge bg-danger px-3 py-1">Out of Stock</span>
                <?php endif; ?>
            </div>

            <h1 class="fw-bold text-dark mb-3"><?= esc($product['name']) ?></h1>

            <?php if ($product['sku']): ?>
                <p class="text-muted small mb-3">Model / SKU: <span class="fw-semibold text-dark"><?= esc($product['sku']) ?></span></p>
            <?php endif; ?>

            <!-- Price Display -->
            <div class="d-flex align-items-baseline gap-3 mb-4 p-3 bg-light rounded-3 border">
                <?php if ($product['discount_price']): ?>
                    <span class="fs-2 fw-extrabold text-primary fw-bold">₹<?= number_format($product['discount_price'], 2) ?></span>
                    <span class="fs-5 text-decoration-line-through text-muted">₹<?= number_format($product['price'], 2) ?></span>
                    <span class="badge bg-danger text-white">Save ₹<?= number_format($product['price'] - $product['discount_price'], 2) ?></span>
                <?php elseif ($product['price']): ?>
                    <span class="fs-2 fw-extrabold text-primary fw-bold">₹<?= number_format($product['price'], 2) ?></span>
                <?php else: ?>
                    <span class="fs-4 text-muted fw-bold">Contact Shopkeeper for Best Price</span>
                <?php endif; ?>
            </div>

            <div class="alert alert-info py-2 px-3 small mb-4">
                <i class="bi bi-info-circle-fill me-1"></i> <strong>Product Showcase Note:</strong> We are a physical computer store in Dewas. No online payment is processed. You can send an inquiry or message Gourav Joshi directly for live stock confirmation and shop pickup.
            </div>

            <div class="mb-4">
                <h6 class="fw-bold text-dark">Quick Summary:</h6>
                <p class="text-muted"><?= nl2br(esc($product['short_description'])) ?></p>
            </div>

            <!-- Action Buttons -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-lg w-100 fw-bold py-3 shadow" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-product-id="<?= $product['id'] ?>" data-product-name="<?= esc($product['name']) ?>">
                        <i class="bi bi-send-fill me-2"></i> Send Inquiry / Quote
                    </button>
                </div>
                <div class="col-md-6">
                    <a href="<?= $whatsappUrl ?>" target="_blank" class="btn btn-success btn-lg w-100 fw-bold py-3 shadow">
                        <i class="bi bi-whatsapp me-2"></i> WhatsApp Gourav Joshi
                    </a>
                </div>
            </div>

            <!-- Store Location & Call Details -->
            <div class="p-3 bg-white border rounded-3 text-muted small">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-shop text-primary"></i> <strong>Available at Showroom:</strong> Shop No. 12, Mainashree Complex, Near Netram, AB Road, Dewas.
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-telephone text-success"></i> <strong>Helpline:</strong> <?= esc(get_setting('contact_phone', '+91 98260 12345')) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">
        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="pills-spec-tab" data-bs-toggle="pill" data-bs-target="#pills-spec" type="button" role="tab" aria-selected="true">
                    <i class="bi bi-list-check me-1"></i> Technical Specifications
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="pills-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-desc" type="button" role="tab" aria-selected="false">
                    <i class="bi bi-file-text me-1"></i> Full Description
                </button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <!-- Specifications Tab -->
            <div class="tab-pane fade show active" id="pills-spec" role="tabpanel" aria-labelledby="pills-spec-tab">
                <?php if (!empty($product['specifications'])): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <?php 
                                    $lines = explode("\n", $product['specifications']);
                                    foreach ($lines as $line):
                                        if (trim($line) === '') continue;
                                        $parts = explode(':', $line, 2);
                                ?>
                                    <tr>
                                        <th class="bg-light text-muted w-25 small fw-bold"><?= esc(trim($parts[0] ?? '')) ?></th>
                                        <td class="small"><?= esc(trim($parts[1] ?? '')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted small mb-0">Contact our shopkeeper for detailed specification sheet.</p>
                <?php endif; ?>
            </div>

            <!-- Full Description Tab -->
            <div class="tab-pane fade" id="pills-desc" role="tabpanel" aria-labelledby="pills-desc-tab">
                <div class="product-description-content">
                    <?= $product['full_description'] ? $product['full_description'] : '<p class="text-muted">No additional details provided.</p>' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="mt-5">
            <h3 class="fw-bold text-dark mb-4">Related Hardware in this Category</h3>
            <div class="row g-4">
                <?php foreach ($relatedProducts as $rel): ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="custom-card product-card">
                            <a href="<?= base_url('products/' . esc($rel['slug'])) ?>" class="product-img-wrapper text-decoration-none">
                                <i class="bi bi-pc-display text-primary fs-2"></i>
                            </a>
                            <div class="product-info">
                                <a href="<?= base_url('products/' . esc($rel['slug'])) ?>" class="product-title">
                                    <?= esc($rel['name']) ?>
                                </a>
                                <div class="product-price-box">
                                    <span class="product-price">₹<?= number_format($rel['discount_price'] ?? $rel['price'], 2) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
