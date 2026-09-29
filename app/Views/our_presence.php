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
                            <i class="bi bi-geo-alt-fill text-danger fs-5 flex-shrink-0 mt-1"></i>
                            <div>
                                <?php if (!empty($loc['address'])): ?>
                                    <strong><?= esc($loc['address']) ?></strong>
                                <?php else: ?>
                                    <strong><?= esc($loc['address_line1'] ?? 'Shop No. 12, Mainashree Complex') ?></strong><br>
                                    <?php if (!empty($loc['address_line2'])): ?>
                                        <?= esc($loc['address_line2']) ?><br>
                                    <?php endif; ?>
                                    <?= esc($loc['city'] ?? 'Dewas') ?>, <?= esc($loc['state'] ?? 'Madhya Pradesh') ?> - <?= esc($loc['pincode'] ?? '455001') ?>
                                <?php endif; ?>
                                <?php if (!empty($loc['landmark'])): ?>
                                    <div class="small text-primary mt-1">Landmark: <?= esc($loc['landmark']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-telephone-fill text-success fs-5 flex-shrink-0 mt-1"></i>
                            <div>
                                <strong><?= esc($loc['phone'] ?? get_setting('contact_phone', '+91 98260 12345')) ?></strong>
                                <?php if (!empty($loc['alternate_phone'])): ?>
                                    <span class="d-block small">Alt: <?= esc($loc['alternate_phone']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-envelope-fill text-info fs-5 flex-shrink-0 mt-1"></i>
                            <div>
                                <span><?= esc($loc['email'] ?? get_setting('contact_email', 'info@balajicomputech.com')) ?></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-clock-fill text-warning fs-5 flex-shrink-0 mt-1"></i>
                            <div>
                                <strong>Store Hours:</strong>
                                <span><?= esc($loc['opening_hours'] ?? get_setting('opening_hours', 'Mon - Sat: 10:00 AM - 08:30 PM | Sun: 11:00 AM - 04:00 PM')) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I am planning to visit the Balaji Computech store.') ?>" target="_blank" class="btn btn-success fw-bold">
                            <i class="bi bi-whatsapp me-1"></i> WhatsApp
                        </a>
                        <a href="tel:<?= esc($loc['phone'] ?? get_setting('contact_phone', '+919826012345')) ?>" class="btn btn-outline-primary fw-bold">
                            <i class="bi bi-telephone me-1"></i> Call Store
                        </a>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="rounded-4 overflow-hidden shadow-sm border border-2 border-light" style="min-height: 380px;">
                        <?= !empty($loc['google_maps_embed']) ? $loc['google_maps_embed'] : '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117565.41926694665!2d76.00287612739345!3d22.959955745164283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39631742468bb03b%3A0x6b8b0e797e55fae2!2sDewas%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' ?>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
