<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-primary bg-opacity-10 py-5 mb-5 border-bottom">
    <div class="container text-center">
        <span class="badge bg-primary px-3 py-2 mb-2">Get in Touch</span>
        <h1 class="fw-bold text-dark mb-2">Contact Balaji Computech & Visit Our Store</h1>
        <p class="text-muted mx-auto" style="max-width: 650px;">
            Have questions about laptop models, component availability, CCTV installation quotes, or chip-level repair diagnostic? Contact Gourav Joshi today.
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5">
        <!-- Contact Information & Map -->
        <div class="col-lg-5">
            <h3 class="fw-bold text-dark mb-4">Shop & Lab Information</h3>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 fs-4">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Physical Store Address</h6>
                        <p class="text-muted small mb-0"><?= esc(get_setting('shop_address')) ?></p>
                        <span class="badge bg-light text-dark border mt-2">Landmark: <?= esc($primaryLocation['landmark'] ?? 'Near Netram, AB Road') ?></span>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 fs-4">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Phone & WhatsApp</h6>
                        <p class="text-muted small mb-1">Call: <strong><?= esc(get_setting('contact_phone')) ?></strong></p>
                        <p class="text-muted small mb-0">WhatsApp: <strong>+<?= esc(get_setting('whatsapp_number')) ?></strong></p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 fs-4">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Email Address</h6>
                        <p class="text-muted small mb-0"><?= esc(get_setting('contact_email')) ?></p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 fs-4">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Shop Timings</h6>
                        <p class="text-muted small mb-0"><?= esc(get_setting('opening_hours')) ?></p>
                    </div>
                </div>
            </div>

            <!-- Direct WhatsApp CTA -->
            <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I would like to visit Balaji Computech / inquire about services.') ?>" target="_blank" class="btn btn-success btn-lg w-100 fw-bold py-3 shadow mb-4">
                <i class="bi bi-whatsapp me-2 fs-5"></i> Chat Direct on WhatsApp
            </a>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <h3 class="fw-bold text-dark mb-2">Send Us a Direct Message</h3>
                <p class="text-muted small mb-4">Fill in your requirement below and we will get back to you with price quotes and technical guidance.</p>

                <form action="<?= base_url('contact/submit') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Your Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Anand Sharma" value="<?= old('name', session()->get('user_name') ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                            <input type="tel" name="mobile" class="form-control" required placeholder="+91 98260 00000" value="<?= old('mobile') ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="name@example.com" value="<?= old('email', session()->get('user_email') ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control" required placeholder="e.g. Motherboard repair / PC quote" value="<?= old('subject') ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Your Message / Requirement Details <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="5" required placeholder="Please describe your laptop issue, required computer parts, or service requirement..."><?= old('message') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow">
                        <i class="bi bi-send-fill me-2"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Google Map Embed -->
    <div class="mt-5">
        <h4 class="fw-bold text-dark mb-3"><i class="bi bi-map-fill text-primary me-2"></i> Find Us On Google Maps</h4>
        <div class="rounded-4 overflow-hidden shadow-sm border border-2 border-white" style="min-height: 400px;">
            <?= get_setting('google_maps_embed') ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
