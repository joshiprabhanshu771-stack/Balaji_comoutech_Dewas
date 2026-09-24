<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 850px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-geo-alt-fill text-primary me-2"></i> Edit Showroom Location</h4>
        <a href="<?= base_url('admin/presence') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?= base_url('admin/presence/update/' . $location['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="row g-3 mb-3">
            <div class="col-md-12">
                <label class="form-label fw-semibold">Showroom Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required value="<?= old('title', $location['title']) ?>">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Address Line 1 <span class="text-danger">*</span></label>
                <input type="text" name="address_line1" class="form-control" required value="<?= old('address_line1', $location['address_line1']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Address Line 2</label>
                <input type="text" name="address_line2" class="form-control" value="<?= old('address_line2', $location['address_line2']) ?>">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">City</label>
                <input type="text" name="city" class="form-control" required value="<?= old('city', $location['city']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">State</label>
                <input type="text" name="state" class="form-control" required value="<?= old('state', $location['state']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Pincode</label>
                <input type="text" name="pincode" class="form-control" required value="<?= old('pincode', $location['pincode']) ?>">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" name="phone" class="form-control" required value="<?= old('phone', $location['phone']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Alternate Phone</label>
                <input type="tel" name="alternate_phone" class="form-control" value="<?= old('alternate_phone', $location['alternate_phone']) ?>">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" required value="<?= old('email', $location['email']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Landmark</label>
                <input type="text" name="landmark" class="form-control" value="<?= old('landmark', $location['landmark']) ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Operating Hours</label>
            <input type="text" name="opening_hours" class="form-control" value="<?= old('opening_hours', $location['opening_hours']) ?>">
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Google Maps Embed iframe code</label>
            <textarea name="google_maps_embed" class="form-control font-monospace" rows="4"><?= old('google_maps_embed', $location['google_maps_embed']) ?></textarea>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="checkPrimary" <?= old('is_primary', $location['is_primary']) ? 'checked' : '' ?>>
            <label class="form-check-label fw-semibold" for="checkPrimary">Set as Primary Showroom Location</label>
        </div>

        <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
            <i class="bi bi-check-lg me-1"></i> Update Location
        </button>
    </form>
</div>

<?= $this->endSection() ?>
