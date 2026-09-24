<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square text-warning me-2"></i> Edit Offer: <?= esc($offer['title']) ?></h4>
        <a href="<?= base_url('admin/offers') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?= base_url('admin/offers/update/' . $offer['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">Offer Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" required value="<?= old('title', $offer['title']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Offer Details & Benefits</label>
            <textarea name="description" class="form-control" rows="3"><?= old('description', $offer['description']) ?></textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Discount Highlight Badge Text</label>
                <input type="text" name="discount_text" class="form-control" value="<?= old('discount_text', $offer['discount_text']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Coupon / Promo Code</label>
                <input type="text" name="coupon_code" class="form-control font-monospace" value="<?= old('coupon_code', $offer['coupon_code']) ?>">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Valid From</label>
                <input type="date" name="valid_from" class="form-control" value="<?= old('valid_from', $offer['valid_from']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Valid Until</label>
                <input type="date" name="valid_until" class="form-control" value="<?= old('valid_until', $offer['valid_until']) ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Update Banner Image</label>
            <input type="file" name="banner_image" class="form-control">
            <?php if ($offer['banner_image']): ?>
                <div class="small text-muted mt-1">Current: <?= esc($offer['banner_image']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="checkActive" <?= old('is_active', $offer['is_active']) ? 'checked' : '' ?>>
            <label class="form-check-label fw-semibold" for="checkActive">Active and Visible on Website</label>
        </div>

        <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
            <i class="bi bi-check-lg me-1"></i> Update Offer
        </button>
    </form>
</div>

<?= $this->endSection() ?>
