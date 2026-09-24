<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square text-primary me-2"></i> Edit Service: <?= esc($service['name']) ?></h4>
        <a href="<?= base_url('admin/services') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Services
        </a>
    </div>

    <form action="<?= base_url('admin/services/update/' . $service['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="<?= old('name', $service['name']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Short Summary</label>
                    <textarea name="short_description" class="form-control" rows="3"><?= old('short_description', $service['short_description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Features & Highlights (One per line)</label>
                    <textarea name="features" class="form-control font-monospace" rows="5"><?= old('features', $service['features']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Description / Detailed Procedure</label>
                    <textarea name="full_description" class="form-control" rows="6"><?= old('full_description', $service['full_description']) ?></textarea>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border rounded-3 p-3 bg-light mb-3">
                    <h6 class="fw-bold mb-3">Service Details</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Bootstrap Icon Class</label>
                        <input type="text" name="icon" class="form-control" value="<?= old('icon', $service['icon']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Turnaround Time</label>
                        <input type="text" name="turnaround_time" class="form-control" value="<?= old('turnaround_time', $service['turnaround_time']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Starting Estimate (₹)</label>
                        <input type="number" step="0.01" name="starting_price" class="form-control" value="<?= old('starting_price', $service['starting_price']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= old('status', $service['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= old('status', $service['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Update Image (Optional)</label>
                        <input type="file" name="image" class="form-control">
                        <?php if ($service['image']): ?>
                            <div class="small text-muted mt-1">Current: <?= esc($service['image']) ?></div>
                        <?php endif; ?>
                    </div>

                    <hr>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="checkFeatured" <?= old('is_featured', $service['is_featured']) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold small" for="checkFeatured">Featured on Homepage</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Update Service
                </button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
