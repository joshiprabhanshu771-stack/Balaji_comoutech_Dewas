<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 750px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-question-circle-fill text-primary me-2"></i> Add FAQ</h4>
        <a href="<?= base_url('admin/faqs') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?= base_url('admin/faqs/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">FAQ Group / Category</label>
                <input type="text" name="category" class="form-control" placeholder="e.g. Products & Stock / Repair Services" value="<?= old('category', 'General') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', 0) ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
            <input type="text" name="question" class="form-control" required placeholder="e.g. Do you sell original laptops with manufacturer warranty?" value="<?= old('question') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Answer <span class="text-danger">*</span></label>
            <textarea name="answer" class="form-control" rows="5" required placeholder="Write a clear, helpful answer..."><?= old('answer') ?></textarea>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="checkActive" checked>
            <label class="form-check-label fw-semibold" for="checkActive">Active & Displayed on FAQ page</label>
        </div>

        <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
            <i class="bi bi-check-lg me-1"></i> Save FAQ
        </button>
    </form>
</div>

<?= $this->endSection() ?>
