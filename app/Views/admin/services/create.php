<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-tools text-primary me-2"></i> Add New Service</h4>
        <a href="<?= base_url('admin/services') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Services
        </a>
    </div>

    <form action="<?= base_url('admin/services/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. CCTV Camera Installation & Network Setup" value="<?= old('name') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Short Summary</label>
                    <textarea name="short_description" class="form-control" rows="3" placeholder="Brief service summary for cards..."><?= old('short_description') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Features & Highlights (One per line)</label>
                    <textarea name="features" class="form-control font-monospace" rows="5" placeholder="Free Onsite Site Survey&#10;High Definition 1080P/4K Cameras&#10;Mobile Remote Live View&#10;1 Year Warranty"><?= old('features') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Description / Detailed Procedure</label>
                    <textarea name="full_description" class="form-control" rows="6" placeholder="Detailed service description, procedure, terms..."><?= old('full_description') ?></textarea>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border rounded-3 p-3 bg-light mb-3">
                    <h6 class="fw-bold mb-3">Service Details</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Bootstrap Icon Class</label>
                        <input type="text" name="icon" class="form-control" placeholder="bi bi-camera-video" value="<?= old('icon', 'bi bi-tools') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Turnaround Time</label>
                        <input type="text" name="turnaround_time" class="form-control" placeholder="e.g. Same Day / 24 Hours" value="<?= old('turnaround_time') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Starting Estimate (₹)</label>
                        <input type="number" step="0.01" name="starting_price" class="form-control" placeholder="499.00" value="<?= old('starting_price') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Service Image (Optional)</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <hr>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="checkFeatured" <?= old('is_featured') ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold small" for="checkFeatured">Featured on Homepage</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Save Service
                </button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
