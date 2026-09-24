<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-folder-plus text-primary me-2"></i> Add New Category</h4>
        <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?= base_url('admin/categories/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Gaming Laptops" value="<?= old('name') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Brief category description..."><?= old('description') ?></textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Bootstrap Icon Class</label>
                <input type="text" name="icon" class="form-control" placeholder="bi bi-laptop" value="<?= old('icon', 'bi bi-folder') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', 0) ?>">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="checkFeatured" <?= old('is_featured') ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="checkFeatured">Featured on Homepage</label>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Category Image (Optional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
            <i class="bi bi-check-lg me-1"></i> Save Category
        </button>
    </form>
</div>

<?= $this->endSection() ?>
