<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <a href="<?= base_url('admin/contact-messages') ?>" class="text-decoration-none small text-muted mb-1 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Back to Messages
            </a>
            <h4 class="fw-bold text-dark mb-0">Message from <?= esc($message['name']) ?></h4>
        </div>
        <div>
            <span class="text-muted small"><?= date('d M Y, h:i A', strtotime($message['created_at'])) ?></span>
        </div>
    </div>

    <div class="p-3 bg-light rounded-3 mb-4 border">
        <div class="row g-2 small">
            <div class="col-md-4">
                <span class="text-muted d-block">Sender Name:</span>
                <strong><?= esc($message['name']) ?></strong>
            </div>
            <div class="col-md-4">
                <span class="text-muted d-block">Mobile:</span>
                <a href="tel:<?= esc($message['mobile']) ?>" class="fw-bold text-dark text-decoration-none">
                    <i class="bi bi-telephone text-success me-1"></i> <?= esc($message['mobile']) ?>
                </a>
            </div>
            <div class="col-md-4">
                <span class="text-muted d-block">Email:</span>
                <a href="mailto:<?= esc($message['email']) ?>" class="fw-bold text-dark text-decoration-none">
                    <i class="bi bi-envelope text-info me-1"></i> <?= esc($message['email']) ?>
                </a>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <h6 class="fw-bold text-dark mb-2">Subject: <span class="text-primary"><?= esc($message['subject']) ?></span></h6>
        <div class="p-4 bg-white border rounded-3 text-dark small" style="white-space: pre-wrap; line-height: 1.7;">
            <?= esc($message['message']) ?>
        </div>
    </div>

    <?php 
        $custPhone = preg_replace('/[^0-9]/', '', $message['mobile']);
        if (strlen($custPhone) === 10) $custPhone = '91' . $custPhone;
        $custWaUrl = "https://wa.me/{$custPhone}?text=" . urlencode("Hello {$message['name']},\n\nThis is Gourav Joshi from Balaji Computech regarding your message on: {$message['subject']}.");
    ?>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= $custWaUrl ?>" target="_blank" class="btn btn-success fw-bold">
            <i class="bi bi-whatsapp me-1"></i> WhatsApp Sender
        </a>
        <a href="mailto:<?= esc($message['email']) ?>?subject=Re: <?= urlencode($message['subject']) ?>" class="btn btn-outline-primary fw-bold">
            <i class="bi bi-envelope me-1"></i> Send Email
        </a>
        <a href="tel:<?= esc($message['mobile']) ?>" class="btn btn-outline-dark fw-bold">
            <i class="bi bi-telephone me-1"></i> Call Phone
        </a>
    </div>
</div>

<?= $this->endSection() ?>
