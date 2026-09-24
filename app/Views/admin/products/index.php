<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-box-seam-fill text-primary me-2"></i> Product Showcase Management</h4>
        <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Add New Product
        </a>
    </div>

    <!-- Search & Filter Form -->
    <form action="<?= base_url('admin/products') ?>" method="GET" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Search by product name or SKU..." value="<?= esc($search ?? '') ?>">
        </div>
        <div class="col-md-4">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($catId == $cat['id']) ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-dark w-100 fw-semibold"><i class="bi bi-search me-1"></i> Search</button>
            <a href="<?= base_url('admin/products') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>

    <?php if (empty($products)): ?>
        <div class="p-5 text-center text-muted">
            <i class="bi bi-inbox fs-1 mb-2 d-block"></i>
            <p>No products found in catalog.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr class="text-muted text-uppercase">
                        <th>#</th>
                        <th>Product Details</th>
                        <th>Category & Brand</th>
                        <th>Pricing</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= esc($p['name']) ?></div>
                                <span class="text-muted small">SKU: <?= esc($p['sku'] ?: 'N/A') ?></span>
                                <?php if ($p['is_featured']): ?>
                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem;">Featured</span>
                                <?php endif; ?>
                                <?php if ($p['is_hot_deal']): ?>
                                    <span class="badge bg-danger ms-1" style="font-size: 0.65rem;">Hot Deal</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div><span class="badge bg-light text-dark border"><?= esc($p['category_name'] ?? 'Uncategorized') ?></span></div>
                                <?php if ($p['brand_name']): ?>
                                    <span class="text-muted small"><?= esc($p['brand_name']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($p['discount_price']): ?>
                                    <strong class="text-primary">₹<?= number_format($p['discount_price'], 2) ?></strong><br>
                                    <span class="text-muted text-decoration-line-through small">₹<?= number_format($p['price'], 2) ?></span>
                                <?php elseif ($p['price']): ?>
                                    <strong class="text-primary">₹<?= number_format($p['price'], 2) ?></strong>
                                <?php else: ?>
                                    <span class="text-muted">Inquiry Only</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($p['stock_status'] === 'in_stock'): ?>
                                    <span class="badge bg-success">In Stock</span>
                                <?php elseif ($p['stock_status'] === 'on_demand'): ?>
                                    <span class="badge bg-warning text-dark">On Demand</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Out of Stock</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?= $p['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"><?= ucfirst(esc($p['status'])) ?></span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('products/' . esc($p['slug'])) ?>" class="btn btn-sm btn-outline-info" target="_blank" title="View Public Page">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/products/edit/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('admin/products/delete/' . $p['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this product permanently?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
