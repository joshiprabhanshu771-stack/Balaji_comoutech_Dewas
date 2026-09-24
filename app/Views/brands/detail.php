<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary text-white p-3 rounded-circle fs-3">
                <i class="bi bi-award-fill"></i>
            </div>
            <div>
                <h2 class="fw-bold text-dark mb-1"><?= esc($brand['name']) ?> Products & Solutions</h2>
                <p class="text-muted small mb-0"><?= esc($brand['description']) ?></p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">Hardware by <?= esc($brand['name']) ?></h4>
        <span class="text-muted small"><?= count($products) ?> items found</span>
    </div>

    <?php if (empty($products)): ?>
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
            <h5 class="fw-bold text-dark mb-2">No Products Currently Listed for <?= esc($brand['name']) ?></h5>
            <p class="text-muted small mb-4">We can still source any <?= esc($brand['name']) ?> product on request with 24-48h dispatch.</p>
            <div>
                <a href="<?= get_whatsapp_url("Hello Gourav Joshi, I want to inquire about {$brand['name']} products in Dewas.") ?>" target="_blank" class="btn btn-success fw-bold">
                    <i class="bi bi-whatsapp me-1"></i> Inquire on WhatsApp
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <?php 
                    $isInWishlist = in_array($product['id'], $userWishlistIds ?? []);
                    $waProductMsg = "Hello Gourav Joshi,\n\nI am interested in:\nProduct: {$product['name']}\nPrice: ₹" . number_format($product['discount_price'] ?? $product['price'], 2) . "\nLink: " . base_url('products/' . $product['slug']) . "\n\nPlease let me know availability.";
                ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card product-card">
                        <!-- Wishlist Toggle -->
                        <button type="button" class="btn-wishlist btn-wishlist-toggle <?= $isInWishlist ? 'active' : '' ?>" data-product-id="<?= $product['id'] ?>" title="Save to Wishlist">
                            <i class="bi <?= $isInWishlist ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                        </button>

                        <a href="<?= base_url('products/' . esc($product['slug'])) ?>" class="product-img-wrapper text-decoration-none">
                            <i class="bi bi-pc-display text-primary fs-1"></i>
                        </a>

                        <div class="product-info">
                            <span class="product-cat"><?= esc($product['category_name'] ?? 'Hardware') ?></span>
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
                                    Inquire Price
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
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
