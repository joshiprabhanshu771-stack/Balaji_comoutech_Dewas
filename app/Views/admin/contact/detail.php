<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <a href="<?= base_url('admin/contact-messages') ?>" class="text-decoration-none small text-muted mb-1 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Back to Messages
            </a>
            <h4 class="fw-bold text-dark mb-0">Message from <?= esc($message['name'] ?? 'Visitor') ?></h4>
        </div>
        <div>
            <span class="text-muted small">
                <?= !empty($message['created_at']) ? date('d M Y, h:i A', strtotime($message['created_at'])) : '—' ?>
            </span>
        </div>
    </div>

    <div class="p-3 bg-light rounded-3 mb-4 border">
        <div class="row g-2 small">
            <div class="col-md-4">
                <span class="text-muted d-block">Sender Name:</span>
                <strong><?= esc($message['name'] ?? '—') ?></strong>
            </div>
            <div class="col-md-4">
                <span class="text-muted d-block">Mobile:</span>
                <a href="tel:<?= esc($message['mobile'] ?? '') ?>" class="fw-bold text-dark text-decoration-none">
                    <i class="bi bi-telephone text-success me-1"></i> <?= esc(format_indian_mobile($message['mobile'] ?? '', true)) ?>
                </a>
            </div>
            <div class="col-md-4">
                <span class="text-muted d-block">Email:</span>
                <a href="mailto:<?= esc($message['email'] ?? '') ?>" class="fw-bold text-dark text-decoration-none">
                    <i class="bi bi-envelope text-info me-1"></i> <?= esc($message['email'] ?? '—') ?>
                </a>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <h6 class="fw-bold text-dark mb-2">Subject: <span class="text-primary"><?= esc($message['subject'] ?? '—') ?></span></h6>
        <div class="p-4 bg-white border rounded-3 text-dark small" style="white-space: pre-wrap; line-height: 1.7;">
            <?= esc($message['message'] ?? '—') ?>
        </div>
    </div>

    <?php 
        $senderName = esc($message['name'] ?? 'Sir/Madam');
        $msgSubject = esc($message['subject'] ?? 'your inquiry');
        $waMessage = "Hello {$senderName},\n\nThis is Gourav Joshi from Balaji Computech regarding your message on: {$msgSubject}.";
        $custWaUrl = get_whatsapp_url($waMessage, $message['mobile'] ?? '');
    ?>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= $custWaUrl ?>" target="_blank" class="btn btn-success fw-bold">
            <i class="bi bi-whatsapp me-1"></i> WhatsApp Sender
        </a>
        <a href="mailto:<?= esc($message['email'] ?? '') ?>?subject=Re: <?= rawurlencode($message['subject'] ?? 'Your message to Balaji Computech') ?>" class="btn btn-outline-primary fw-bold">
            <i class="bi bi-envelope me-1"></i> Send Email
        </a>
        <a href="tel:<?= esc($message['mobile'] ?? '') ?>" class="btn btn-outline-dark fw-bold">
            <i class="bi bi-telephone me-1"></i> Call Phone
        </a>
        <a href="<?= base_url('admin/contact-messages/delete/' . ($message['id'] ?? 0)) ?>" class="btn btn-outline-danger ms-auto fw-semibold" onclick="return confirm('Are you sure you want to delete this message?')">
            <i class="bi bi-trash me-1"></i> Delete
        </a>
    </div>
</div>

<?= $this->endSection() ?>
