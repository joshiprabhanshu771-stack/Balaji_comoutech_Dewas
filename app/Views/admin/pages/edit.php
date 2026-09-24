<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square text-primary me-2"></i> Edit Page: <?= esc($page['title']) ?></h4>
        <a href="<?= base_url('admin/pages') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?= base_url('admin/pages/update/' . $page['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required value="<?= old('title', $page['title']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Content (HTML supported) <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="14" required><?= old('content', $page['content']) ?></textarea>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border rounded-3 p-3 bg-light mb-3">
                    <h6 class="fw-bold mb-3">SEO & Visibility</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="<?= old('meta_title', $page['meta_title']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="4"><?= old('meta_description', $page['meta_description']) ?></textarea>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="checkActive" <?= old('is_active', $page['is_active']) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold small" for="checkActive">Published</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Update Page
                </button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
