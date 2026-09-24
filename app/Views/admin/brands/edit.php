<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square text-primary me-2"></i> Edit Brand: <?= esc($brand['name']) ?></h4>
        <a href="<?= base_url('admin/brands') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?= base_url('admin/brands/update/' . $brand['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">Brand Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required value="<?= old('name', $brand['name']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="3"><?= old('description', $brand['description']) ?></textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="active" <?= old('status', $brand['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= old('status', $brand['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="checkFeatured" <?= old('is_featured', $brand['is_featured']) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="checkFeatured">Featured Brand</label>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Update Brand Logo</label>
            <input type="file" name="logo" class="form-control">
            <?php if ($brand['logo']): ?>
                <div class="small text-muted mt-1">Current: <?= esc($brand['logo']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
            <i class="bi bi-check-lg me-1"></i> Update Brand
        </button>
    </form>
</div>

<?= $this->endSection() ?>
