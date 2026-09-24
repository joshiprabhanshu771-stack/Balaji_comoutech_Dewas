<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-primary bg-opacity-10 py-5 mb-5 border-bottom">
    <div class="container text-center">
        <span class="badge bg-primary px-3 py-2 mb-2">Help Center</span>
        <h1 class="fw-bold text-dark mb-2">Frequently Asked Questions</h1>
        <p class="text-muted mx-auto" style="max-width: 650px;">
            Find quick answers about how our product showcase inquiry platform works, hardware warranty policies, repair turnaround times, and shop visiting hours.
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <?php if (empty($faqGroups)): ?>
                <div class="text-center py-5">
                    <p class="text-muted">No FAQs found.</p>
                </div>
            <?php else: ?>
                <?php foreach ($faqGroups as $category => $faqs): ?>
                    <div class="mb-5">
                        <h4 class="fw-bold text-primary mb-3"><i class="bi bi-patch-question-fill me-2"></i> <?= esc($category) ?></h4>
                        <div class="accordion shadow-sm rounded-4 overflow-hidden" id="faqGroup_<?= md5($category) ?>">
                            <?php foreach ($faqs as $idx => $faq): ?>
                                <div class="accordion-item border-bottom">
                                    <h2 class="accordion-header" id="heading_<?= $faq['id'] ?>">
                                        <button class="accordion-button <?= $idx !== 0 ? 'collapsed' : '' ?> fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?= $faq['id'] ?>" aria-expanded="<?= $idx === 0 ? 'true' : 'false' ?>" aria-controls="collapse_<?= $faq['id'] ?>">
                                            <?= esc($faq['question']) ?>
                                        </button>
                                    </h2>
                                    <div id="collapse_<?= $faq['id'] ?>" class="accordion-collapse collapse <?= $idx === 0 ? 'show' : '' ?>" aria-labelledby="heading_<?= $faq['id'] ?>" data-bs-parent="#faqGroup_<?= md5($category) ?>">
                                        <div class="accordion-body text-muted small">
                                            <?= nl2br(esc($faq['answer'])) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Still have questions banner -->
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-light border mt-4">
                <h5 class="fw-bold text-dark mb-2">Have a question not answered here?</h5>
                <p class="text-muted small mb-3">Our shopkeeper Gourav Joshi is happy to answer any questions about computer setups, compatibility, and repair estimates.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= base_url('contact') ?>" class="btn btn-primary fw-bold">
                        <i class="bi bi-envelope-fill me-1"></i> Contact Us
                    </a>
                    <a href="<?= get_whatsapp_url('Hello Gourav Joshi, I have a question about Balaji Computech services.') ?>" target="_blank" class="btn btn-success fw-bold">
                        <i class="bi bi-whatsapp me-1"></i> Ask on WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
