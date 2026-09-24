<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-primary bg-opacity-10 py-5 mb-5 border-bottom">
    <div class="container text-center">
        <span class="badge bg-primary px-3 py-2 mb-2">Showroom & Service Lab</span>
        <h1 class="fw-bold text-dark mb-2">Our Store Presence & Location</h1>
        <p class="text-muted mx-auto" style="max-width: 650px;">
            Visit Balaji Computech in Dewas to test laptops, consult on custom PC builds, or drop off hardware for chip-level repair.
        </p>
    </div>
</div>

<div class="container pb-5">
    <?php foreach ($locations as $loc): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <div class="badge bg-primary px-3 py-2 mb-3">Main Showroom & Service Center</div>
                    <h2 class="fw-bold text-dark mb-3"><?= esc($loc['title']) ?></h2>

                    <div class="d-flex flex-column gap-3 text-muted mb-4">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
                            <div>
                                <strong><?= esc($loc['address_line1']) ?></strong><br>
                                <?= esc($loc['address_line2']) ?><br>
                                <?= esc($loc['city']) ?>, <?= esc($loc['state']) ?> - <?= esc($loc['pincode']) ?>
                                <?php if ($loc['landmark']): ?>
                                    <div class="small text-primary mt-1">Landmark: <?= esc($loc['landmark']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-telephone-fill text-success fs-5"></i>
                            <div>
                                <strong><?= esc($loc['phone']) ?></strong>
                                <?php if ($loc['alternate_phone']): ?>
                                    <span class="d-block small">Alt: <?= esc($loc['alternate_phone']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-envelope-fill text-info fs-5"></i>
                            <div>
                                <span><?= esc($loc['email']) ?></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-clock-fill text-warning fs-5"></i>
                            <div>
                                <strong>Store Hours:</strong>
                                <span><?= esc($loc['opening_hours']) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I am planning to visit the Balaji Computech store.') ?>" target="_blank" class="btn btn-success fw-bold">
                            <i class="bi bi-whatsapp me-1"></i> WhatsApp
                        </a>
                        <a href="tel:<?= esc($loc['phone']) ?>" class="btn btn-outline-primary fw-bold">
                            <i class="bi bi-telephone me-1"></i> Call Store
                        </a>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="rounded-4 overflow-hidden shadow-sm border border-2 border-light" style="min-height: 380px;">
                        <?= $loc['google_maps_embed'] ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
