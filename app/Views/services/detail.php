<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('services') ?>" class="text-decoration-none text-muted">Services</a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page"><?= esc($service['name']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5">
        <!-- Main Service Detail -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="service-icon-box mb-0">
                        <i class="<?= esc($service['icon'] ?: 'bi bi-tools') ?>"></i>
                    </div>
                    <div>
                        <span class="badge bg-primary px-3 py-1 mb-1">Service & Support</span>
                        <h2 class="fw-bold text-dark mb-0"><?= esc($service['name']) ?></h2>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 d-flex flex-wrap gap-4 align-items-center justify-content-between mb-4 border">
                    <div>
                        <span class="text-muted small d-block">Estimated Turnaround:</span>
                        <strong class="text-dark fs-6"><i class="bi bi-clock-history text-primary me-1"></i> <?= esc($service['turnaround_time'] ?: '24 - 48 Hours') ?></strong>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Starting Estimate:</span>
                        <strong class="text-success fs-5">₹<?= number_format($service['starting_price'], 2) ?></strong>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Service Location:</span>
                        <strong class="text-dark fs-6"><i class="bi bi-geo-alt-fill text-danger me-1"></i> In-Shop & Onsite Dewas</strong>
                    </div>
                </div>

                <div class="service-content mb-4">
                    <?= $service['full_description'] ? $service['full_description'] : '<p class="text-muted">' . nl2br(esc($service['short_description'])) . '</p>' ?>
                </div>

                <?php if (!empty($service['features'])): ?>
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">Service Highlights & Guarantees:</h5>
                        <ul class="list-group list-group-flush border rounded-3">
                            <?php foreach (explode("\n", $service['features']) as $feat): ?>
                                <?php if (trim($feat) !== ''): ?>
                                    <li class="list-group-item d-flex align-items-center gap-2 small">
                                        <i class="bi bi-check-circle-fill text-success"></i> <?= esc(trim($feat)) ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="row g-3 pt-3 border-top">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary btn-lg w-100 fw-bold py-3 shadow" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-service-id="<?= $service['id'] ?>" data-service-name="<?= esc($service['name']) ?>">
                            <i class="bi bi-calendar-check me-2"></i> Book / Inquire Service
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= $whatsappUrl ?>" target="_blank" class="btn btn-success btn-lg w-100 fw-bold py-3 shadow">
                            <i class="bi bi-whatsapp me-2"></i> WhatsApp Consultation
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Other Services & Contact -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark mb-3">All Services</h5>
                <ul class="list-group list-group-flush small">
                    <?php foreach ($allServices as $otherSrv): ?>
                        <li class="list-group-item px-0">
                            <a href="<?= base_url('services/' . esc($otherSrv['slug'])) ?>" class="text-decoration-none d-flex justify-content-between align-items-center text-dark fw-semibold">
                                <span><i class="bi bi-chevron-right text-primary me-2"></i> <?= esc($otherSrv['name']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light border text-center">
                <i class="bi bi-person-badge-fill text-primary fs-1 mb-2"></i>
                <h5 class="fw-bold text-dark mb-1">Direct Technician Support</h5>
                <p class="text-muted small mb-3">Speak directly with <strong>Gourav Joshi</strong> for repair diagnosis and parts quotation.</p>
                <a href="tel:<?= esc(get_setting('contact_phone', '+919826012345')) ?>" class="btn btn-dark btn-sm fw-bold py-2 w-100">
                    <i class="bi bi-telephone-fill me-2 text-warning"></i> <?= esc(get_setting('contact_phone', '+91 98260 12345')) ?>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
