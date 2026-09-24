<?= $this->extend('layouts/customer') ?>

<?= $this->section('customer_content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-heart-fill text-danger me-2"></i> My Saved Wishlist</h4>
        <span class="text-muted small"><?= count($items) ?> items saved</span>
    </div>

    <?php if (empty($items)): ?>
        <div class="p-5 text-center text-muted">
            <i class="bi bi-heart fs-1 mb-3 d-block text-secondary"></i>
            <h5 class="fw-bold text-dark">Your wishlist is empty</h5>
            <p class="small mb-4">Click the heart icon on any product to save it here for fast price inquiry and stock tracking.</p>
            <a href="<?= base_url('products') ?>" class="btn btn-primary btn-sm fw-bold px-4">Browse Catalog</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($items as $item): ?>
                <?php 
                    $waProductMsg = "Hello Gourav Joshi,\n\nI have saved this product in my wishlist and would like to inquire about current price and availability:\nProduct: {$item['name']}\nPrice: ₹" . number_format($item['discount_price'] ?? $item['price'], 2) . "\nLink: " . base_url('products/' . $item['slug']);
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="custom-card product-card">
                        <a href="<?= base_url('products/' . esc($item['slug'])) ?>" class="product-img-wrapper text-decoration-none">
                            <i class="bi bi-pc-display text-primary fs-2"></i>
                        </a>

                        <div class="product-info">
                            <span class="product-cat"><?= esc($item['category_name'] ?? 'Hardware') ?></span>
                            <a href="<?= base_url('products/' . esc($item['slug'])) ?>" class="product-title">
                                <?= esc($item['name']) ?>
                            </a>

                            <div class="product-price-box d-flex align-items-baseline mb-3">
                                <?php if ($item['discount_price']): ?>
                                    <span class="product-price">₹<?= number_format($item['discount_price'], 2) ?></span>
                                    <span class="product-old-price">₹<?= number_format($item['price'], 2) ?></span>
                                <?php elseif ($item['price']): ?>
                                    <span class="product-price">₹<?= number_format($item['price'], 2) ?></span>
                                <?php else: ?>
                                    <span class="product-price text-muted fs-6">Contact for Price</span>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid gap-2 mb-2">
                                <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-product-id="<?= $item['product_id'] ?>" data-product-name="<?= esc($item['name']) ?>">
                                    <i class="bi bi-chat-dots me-1"></i> Inquire Price
                                </button>
                                <a href="<?= get_whatsapp_url($waProductMsg) ?>" target="_blank" class="btn btn-outline-success btn-sm fw-bold">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                            </div>

                            <div class="text-center pt-2 border-top">
                                <a href="<?= base_url('wishlist/remove/' . $item['id']) ?>" class="text-danger small text-decoration-none fw-semibold" onclick="return confirm('Remove this product from wishlist?')">
                                    <i class="bi bi-trash me-1"></i> Remove
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
