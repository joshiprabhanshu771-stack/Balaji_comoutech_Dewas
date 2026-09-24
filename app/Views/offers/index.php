<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-primary bg-opacity-10 py-5 mb-5 border-bottom">
    <div class="container text-center">
        <span class="badge bg-warning text-dark px-3 py-2 mb-2"><i class="bi bi-tag-fill me-1"></i> Special Offers</span>
        <h1 class="fw-bold text-dark mb-2">Upgrade Deals & Promotional Discounts</h1>
        <p class="text-muted mx-auto" style="max-width: 650px;">
            Save big on PC performance upgrades, student laptop bundles, and home CCTV security packages in Dewas.
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <?php if (empty($offers)): ?>
            <div class="col-12 text-center py-5">
                <div class="text-muted fs-1 mb-3"><i class="bi bi-tag"></i></div>
                <h4 class="fw-bold text-dark">No Active Offers Right Now</h4>
                <p class="text-muted">Check back soon or contact Gourav Joshi directly for festival discounts!</p>
            </div>
        <?php else: ?>
            <?php foreach ($offers as $off): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white border-top border-4 border-warning">
                        <div class="badge bg-warning text-dark align-self-start mb-3 fw-bold px-3 py-2 fs-6">
                            <i class="bi bi-tag-fill me-1"></i> <?= esc($off['discount_text']) ?>
                        </div>
                        <h4 class="fw-bold text-dark mb-2"><?= esc($off['title']) ?></h4>
                        <p class="text-muted small mb-4"><?= esc($off['description']) ?></p>

                        <?php if ($off['valid_until']): ?>
                            <div class="small text-muted mb-3">
                                <i class="bi bi-calendar-event me-1 text-primary"></i> Valid until: <strong><?= date('M d, Y', strtotime($off['valid_until'])) ?></strong>
                            </div>
                        <?php endif; ?>

                        <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                            <?php if ($off['coupon_code']): ?>
                                <button type="button" class="btn btn-sm btn-outline-dark btn-copy-code fw-semibold" data-code="<?= esc($off['coupon_code']) ?>">
                                    <i class="bi bi-clipboard me-1"></i> <?= esc($off['coupon_code']) ?>
                                </button>
                            <?php endif; ?>
                            <a href="<?= base_url('contact') ?>" class="btn btn-sm btn-primary fw-bold">
                                Claim Deal
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
