<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-plus-circle-fill text-primary me-2"></i> Add New Product to Showcase</h4>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Products
        </a>
    </div>

    <form action="<?= base_url('admin/products/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-4">
            <!-- Left Details -->
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. ASUS TUF Gaming F15 Laptop (Core i5 12th Gen)" value="<?= old('name') ?>">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Brand / Manufacturer</label>
                        <select name="brand_id" class="form-select">
                            <option value="">-- None / Generic --</option>
                            <?php foreach ($brands as $br): ?>
                                <option value="<?= $br['id'] ?>" <?= old('brand_id') == $br['id'] ? 'selected' : '' ?>><?= esc($br['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Short Summary / Highlights</label>
                    <textarea name="short_description" class="form-control" rows="3" placeholder="Brief summary displayed on product cards..."><?= old('short_description') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Technical Specifications (One per line: Key: Value)</label>
                    <textarea name="specifications" class="form-control font-monospace" rows="6" placeholder="Processor: Intel Core i5-12500H&#10;RAM: 16GB DDR4&#10;Storage: 512GB NVMe SSD&#10;Graphics: RTX 3050 4GB"><?= old('specifications') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Description / HTML Overview</label>
                    <textarea name="full_description" class="form-control" rows="6" placeholder="Detailed product information, box contents, warranty terms..."><?= old('full_description') ?></textarea>
                </div>
            </div>

            <!-- Right Sidebar Meta -->
            <div class="col-lg-4">
                <div class="card border rounded-3 p-3 bg-light mb-3">
                    <h6 class="fw-bold mb-3">Pricing & Inventory</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Regular / MRP Price (₹)</label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="68990.00" value="<?= old('price') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Discounted / Offer Price (₹)</label>
                        <input type="number" step="0.01" name="discount_price" class="form-control" placeholder="58990.00" value="<?= old('discount_price') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Model / SKU Code</label>
                        <input type="text" name="sku" class="form-control" placeholder="LAP-ASUS-F15" value="<?= old('sku') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Stock Status</label>
                        <select name="stock_status" class="form-select">
                            <option value="in_stock" <?= old('stock_status') === 'in_stock' ? 'selected' : '' ?>>In Stock</option>
                            <option value="on_demand" <?= old('stock_status') === 'on_demand' ? 'selected' : '' ?>>On Demand</option>
                            <option value="out_of_stock" <?= old('stock_status') === 'out_of_stock' ? 'selected' : '' ?>>Out of Stock</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active (Visible)</option>
                            <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive (Hidden)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Product Image (PNG/JPG)</label>
                        <input type="file" name="main_image" class="form-control">
                    </div>

                    <hr>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="checkFeatured" <?= old('is_featured') ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold small" for="checkFeatured">Featured on Homepage</label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_hot_deal" value="1" id="checkHotDeal" <?= old('is_hot_deal') ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold small" for="checkHotDeal">Mark as Hot Deal</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Save Product
                </button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
