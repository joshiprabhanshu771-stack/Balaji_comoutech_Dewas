<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 750px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square text-primary me-2"></i> Edit FAQ</h4>
        <a href="<?= base_url('admin/faqs') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?= base_url('admin/faqs/update/' . $faq['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">FAQ Group / Category</label>
                <input type="text" name="category" class="form-control" value="<?= old('category', $faq['category']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $faq['sort_order']) ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
            <input type="text" name="question" class="form-control" required value="<?= old('question', $faq['question']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Answer <span class="text-danger">*</span></label>
            <textarea name="answer" class="form-control" rows="5" required><?= old('answer', $faq['answer']) ?></textarea>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="checkActive" <?= old('is_active', $faq['is_active']) ? 'checked' : '' ?>>
            <label class="form-check-label fw-semibold" for="checkActive">Active & Displayed on FAQ page</label>
        </div>

        <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
            <i class="bi bi-check-lg me-1"></i> Update FAQ
        </button>
    </form>
</div>

<?= $this->endSection() ?>
