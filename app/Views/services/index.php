<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-primary bg-opacity-10 py-5 mb-5 border-bottom">
    <div class="container text-center">
        <span class="badge bg-primary px-3 py-2 mb-2">Technical Services & Support</span>
        <h1 class="fw-bold text-dark mb-2">Computer Repair & IT Solutions in Dewas</h1>
        <p class="text-muted mx-auto" style="max-width: 650px;">
            Expert chip-level motherboard repairing, custom gaming PC assembly, CCTV surveillance installation, and laptop spare part replacements by Balaji Computech.
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <?php foreach ($services as $srv): ?>
            <div class="col-md-6 col-lg-4">
                <div class="service-card">
                    <div class="service-card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="service-icon-box">
                                <i class="<?= esc($srv['icon'] ?: 'bi bi-tools') ?>"></i>
                            </div>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill small">
                                <i class="bi bi-patch-check-fill me-1"></i> Lab Certified
                            </span>
                        </div>
                        <h4 class="service-title"><?= esc($srv['name']) ?></h4>
                        <p class="service-desc"><?= esc($srv['short_description']) ?></p>

                        <div class="service-meta-box d-flex align-items-center justify-content-between p-2 px-3 rounded-3 mb-3">
                            <span class="small text-secondary"><i class="bi bi-clock-history text-primary me-1"></i> <strong><?= esc($srv['turnaround_time'] ?: 'Same Day') ?></strong></span>
                            <span class="text-success fw-bold small">From ₹<?= number_format($srv['starting_price'], 2) ?></span>
                        </div>
                    </div>

                    <div class="service-card-actions">
                        <a href="<?= base_url('services/' . esc($srv['slug'])) ?>" class="btn btn-outline-primary btn-sm fw-semibold flex-fill py-2 text-center">
                            <i class="bi bi-info-circle me-1"></i> View Details
                        </a>
                        <button type="button" class="btn btn-primary btn-sm fw-semibold flex-fill py-2 text-center" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-service-id="<?= $srv['id'] ?>" data-service-name="<?= esc($srv['name']) ?>">
                            <i class="bi bi-calendar-check me-1"></i> Book Service
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Onsite Service Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-dark text-white mt-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h3 class="fw-bold text-white mb-2">Need Onsite CCTV Installation or Office PC Maintenance?</h3>
                <p class="text-light opacity-75 mb-0">
                    Gourav Joshi and our certified technicians offer onsite site surveys, camera setups, and AMC contracts across Dewas municipal and industrial zones.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I need an onsite technician or CCTV site survey in Dewas.') ?>" target="_blank" class="btn btn-success btn-lg fw-bold px-4 py-3">
                    <i class="bi bi-whatsapp me-2"></i> WhatsApp Technician
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
