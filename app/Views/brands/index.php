<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-primary bg-opacity-10 py-5 mb-5 border-bottom">
    <div class="container text-center">
        <span class="badge bg-primary px-3 py-2 mb-2">Original Partners</span>
        <h1 class="fw-bold text-dark mb-2">Authorized Brands & Hardware Manufacturers</h1>
        <p class="text-muted mx-auto" style="max-width: 650px;">
            We partner directly with leading computer brands to bring authentic laptops, processors, surveillance systems, and accessories to Dewas.
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <?php foreach ($brands as $br): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="<?= base_url('brands/' . esc($br['slug'])) ?>" class="text-decoration-none">
                    <div class="custom-card p-4 text-center h-100">
                        <div class="bg-light p-3 rounded-3 mb-3 d-inline-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <i class="bi bi-award-fill text-primary fs-1"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-1"><?= esc($br['name']) ?></h4>
                        <p class="text-muted small mb-0"><?= esc($br['description']) ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>
