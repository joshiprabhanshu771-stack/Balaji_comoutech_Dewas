<?= $this->extend('layouts/customer') ?>

<?= $this->section('customer_content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <!-- Header with status and back button -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 pb-3 border-bottom">
        <div>
            <a href="<?= base_url('dashboard/inquiries') ?>" class="text-decoration-none small text-muted mb-2 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Back to Inquiries
            </a>
            <h3 class="fw-bold text-dark mb-0">Inquiry #<?= esc($inquiry['inquiry_no']) ?></h3>
        </div>
        <div>
            <?php if ($inquiry['status'] === 'replied'): ?>
                <span class="badge bg-success fs-6 px-3 py-2"><i class="bi bi-check-circle me-1"></i> Shop Replied</span>
            <?php elseif ($inquiry['status'] === 'in_progress'): ?>
                <span class="badge bg-info text-dark fs-6 px-3 py-2"><i class="bi bi-hourglass-split me-1"></i> In Progress</span>
            <?php elseif ($inquiry['status'] === 'closed'): ?>
                <span class="badge bg-secondary fs-6 px-3 py-2">Closed</span>
            <?php else: ?>
                <span class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="bi bi-clock me-1"></i> Pending Shop Response</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Linked Item Card (if product or service) -->
    <?php if ($inquiry['product_name']): ?>
        <div class="card border border-primary border-opacity-25 rounded-3 p-3 bg-primary bg-opacity-10 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white p-2 rounded-2 text-primary fs-3 shadow-sm">
                        <i class="bi bi-pc-display"></i>
                    </div>
                    <div>
                        <span class="badge bg-primary mb-1">Product Linked</span>
                        <h6 class="fw-bold text-dark mb-0"><?= esc($inquiry['product_name']) ?></h6>
                        <?php if ($inquiry['product_price']): ?>
                            <span class="text-muted small">Catalog Price: <strong>₹<?= number_format($inquiry['product_price'], 2) ?></strong></span>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="<?= base_url('products/' . esc($inquiry['product_slug'])) ?>" class="btn btn-sm btn-primary fw-bold" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Product Page
                </a>
            </div>
        </div>
    <?php elseif ($inquiry['service_name']): ?>
        <div class="card border border-info border-opacity-25 rounded-3 p-3 bg-info bg-opacity-10 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white p-2 rounded-2 text-info fs-3 shadow-sm">
                        <i class="bi bi-tools"></i>
                    </div>
                    <div>
                        <span class="badge bg-info text-dark mb-1">Service Linked</span>
                        <h6 class="fw-bold text-dark mb-0"><?= esc($inquiry['service_name']) ?></h6>
                    </div>
                </div>
                <a href="<?= base_url('services/' . esc($inquiry['service_slug'])) ?>" class="btn btn-sm btn-info text-dark fw-bold" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Service Details
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Original Customer Message -->
    <div class="mb-4">
        <h6 class="fw-bold text-dark mb-2">Subject: <span class="text-primary"><?= esc($inquiry['subject']) ?></span></h6>
        <div class="p-3 bg-light rounded-3 border">
            <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                <span><strong>Your Message</strong></span>
                <span><?= date('d M Y, h:i A', strtotime($inquiry['created_at'])) ?></span>
            </div>
            <p class="mb-0 text-dark small" style="white-space: pre-wrap;"><?= esc($inquiry['message']) ?></p>
        </div>
    </div>

    <!-- Shopkeeper Replies Timeline -->
    <div class="mt-4 pt-3 border-top">
        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-chat-quote-fill text-primary me-2"></i> Shopkeeper Responses</h5>

        <?php if (empty($replies)): ?>
            <div class="alert alert-warning small mb-0">
                <i class="bi bi-hourglass-split me-1"></i> Gourav Joshi is reviewing your inquiry. You will receive an update here and on your registered email/phone shortly.
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($replies as $reply): ?>
                    <div class="card border-0 bg-primary bg-opacity-10 rounded-3 p-3 border-start border-4 border-primary">
                        <div class="d-flex justify-content-between align-items-center mb-2 small">
                            <span class="fw-bold text-primary"><i class="bi bi-person-check-fill me-1"></i> <?= esc($reply['sender_name'] ?? 'Balaji Computech Team') ?> (Shopkeeper)</span>
                            <span class="text-muted"><?= date('d M Y, h:i A', strtotime($reply['created_at'])) ?></span>
                        </div>
                        <p class="mb-0 text-dark small" style="white-space: pre-wrap;"><?= esc($reply['message']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Direct Action for Customer -->
    <div class="mt-4 pt-3 border-top d-flex gap-2 flex-wrap">
        <a href="<?= get_whatsapp_url("Hello Gourav Joshi, following up on inquiry #{$inquiry['inquiry_no']}: {$inquiry['subject']}") ?>" target="_blank" class="btn btn-success fw-bold">
            <i class="bi bi-whatsapp me-1"></i> Follow-up on WhatsApp
        </a>
        <a href="tel:<?= esc(get_setting('contact_phone', '+91 98260 12345')) ?>" class="btn btn-outline-primary fw-bold">
            <i class="bi bi-telephone me-1"></i> Call Showroom
        </a>
    </div>
</div>

<?= $this->endSection() ?>
