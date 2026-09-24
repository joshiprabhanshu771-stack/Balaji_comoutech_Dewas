<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Breadcrumbs & Header -->
<div class="bg-primary bg-opacity-10 py-4 mb-4 border-bottom">
    <div class="container">
        <h2 class="fw-bold text-dark mb-1"><?= esc($page_title ?? 'Products Catalog') ?></h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('products') ?>" class="text-decoration-none text-muted">Products</a></li>
                <?php if ($activeCategory): ?>
                    <li class="breadcrumb-item active text-primary" aria-current="page"><?= esc($activeCategory['name']) ?></li>
                <?php elseif ($activeBrand): ?>
                    <li class="breadcrumb-item active text-primary" aria-current="page"><?= esc($activeBrand['name']) ?></li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-funnel-fill text-primary me-1"></i> Filter Products</h5>
                    <a href="<?= base_url('products') ?>" class="text-decoration-none small text-danger fw-bold">Reset</a>
                </div>

                <form action="<?= base_url('products') ?>" method="GET" id="filterForm">
                    <!-- Search query preserve -->
                    <?php if (!empty($filters['search'])): ?>
                        <input type="hidden" name="q" value="<?= esc($filters['search']) ?>">
                    <?php endif; ?>

                    <!-- Categories -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase">Categories</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="" id="catAll" <?= empty($filters['category_slug']) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="form-check-label small" for="catAll">All Categories</label>
                            </div>
                            <?php foreach ($categories as $cat): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="<?= esc($cat['slug']) ?>" id="cat_<?= $cat['id'] ?>" <?= ($filters['category_slug'] ?? '') === $cat['slug'] ? 'checked' : '' ?> onchange="this.form.submit()">
                                    <label class="form-check-label small" for="cat_<?= $cat['id'] ?>"><?= esc($cat['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Brands -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase">Brands</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="brand" value="" id="brandAll" <?= empty($filters['brand_slug']) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="form-check-label small" for="brandAll">All Brands</label>
                            </div>
                            <?php foreach ($brands as $br): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="brand" value="<?= esc($br['slug']) ?>" id="brand_<?= $br['id'] ?>" <?= ($filters['brand_slug'] ?? '') === $br['slug'] ? 'checked' : '' ?> onchange="this.form.submit()">
                                    <label class="form-check-label small" for="brand_<?= $br['id'] ?>"><?= esc($br['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase">Availability</label>
                        <select name="stock" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Stock Status</option>
                            <option value="in_stock" <?= ($filters['stock_status'] ?? '') === 'in_stock' ? 'selected' : '' ?>>In Stock Only</option>
                            <option value="on_demand" <?= ($filters['stock_status'] ?? '') === 'on_demand' ? 'selected' : '' ?>>On Demand</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="form-label fw-bold text-dark small text-uppercase">Sort By</label>
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="latest" <?= ($filters['sort'] ?? '') === 'latest' ? 'selected' : '' ?>>Latest Arrivals</option>
                            <option value="price_low" <?= ($filters['sort'] ?? '') === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_high" <?= ($filters['sort'] ?? '') === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                            <option value="popular" <?= ($filters['sort'] ?? '') === 'popular' ? 'selected' : '' ?>>Most Popular</option>
                            <option value="name_asc" <?= ($filters['sort'] ?? '') === 'name_asc' ? 'selected' : '' ?>>Name: A to Z</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Shop Direct WhatsApp Banner -->
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                <i class="bi bi-whatsapp fs-1 mb-2"></i>
                <h6 class="fw-bold mb-1">Looking for a specific model?</h6>
                <p class="small text-muted mb-3">Send the configuration or photo directly to Gourav Joshi on WhatsApp.</p>
                <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I am looking for a specific laptop/computer part not found on your catalog.') ?>" target="_blank" class="btn btn-success btn-sm fw-bold">
                    Chat on WhatsApp
                </a>
            </div>
        </div>

        <!-- Product Grid & Pagination -->
        <div class="col-lg-9">
            <!-- Header bar with result count -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border flex-wrap gap-2">
                <div>
                    <span class="text-muted small">Showing <strong><?= count($products) ?></strong> of <strong><?= $totalItems ?></strong> products</span>
                    <?php if (!empty($filters['search'])): ?>
                        <span class="badge bg-light text-dark ms-2 border">Search: "<?= esc($filters['search']) ?>"</span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (empty($products)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                    <div class="text-muted mb-3 fs-1"><i class="bi bi-inbox"></i></div>
                    <h4 class="fw-bold text-dark">No Products Found</h4>
                    <p class="text-muted small mb-4">We couldn't find any products matching your selected filters or search terms.</p>
                    <div>
                        <a href="<?= base_url('products') ?>" class="btn btn-primary fw-bold px-4">View All Products</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($products as $product): ?>
                        <?php 
                            $isInWishlist = in_array($product['id'], $userWishlistIds ?? []);
                            $waProductMsg = "Hello Gourav Joshi,\n\nI am interested in:\nProduct: {$product['name']}\nPrice: ₹" . number_format($product['discount_price'] ?? $product['price'], 2) . "\nLink: " . base_url('products/' . $product['slug']) . "\n\nPlease let me know availability.";
                        ?>
                        <div class="col-md-6 col-xl-4">
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

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav class="mt-5 d-flex justify-content-center">
                        <ul class="pagination">
                            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                <?php 
                                    $queryParams = $_GET;
                                    $queryParams['page'] = $p;
                                    $pageUrl = base_url('products?' . http_build_query($queryParams));
                                ?>
                                <li class="page-item <?= $p === $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $pageUrl ?>"><?= $p ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
