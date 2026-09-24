<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-file-earmark-plus-fill text-primary me-2"></i> Create Content Page</h4>
        <a href="<?= base_url('admin/pages') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?= base_url('admin/pages/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. Warranty & Support Guidelines" value="<?= old('title') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Content (HTML supported) <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="12" required placeholder="Write your page content using headings, paragraphs, bullet points..."><?= old('content') ?></textarea>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border rounded-3 p-3 bg-light mb-3">
                    <h6 class="fw-bold mb-3">SEO & Visibility</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" placeholder="SEO Title" value="<?= old('meta_title') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="4" placeholder="Brief SEO description..."><?= old('meta_description') ?></textarea>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="checkActive" checked>
                        <label class="form-check-label fw-semibold small" for="checkActive">Publish Immediately</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Save Page
                </button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
