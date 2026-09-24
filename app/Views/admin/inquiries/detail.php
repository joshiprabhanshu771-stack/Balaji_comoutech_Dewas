<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row g-4">
    <!-- Left Column: Inquiry Metadata, Linked Product/Service & Thread -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom flex-wrap gap-2">
                <div>
                    <a href="<?= base_url('admin/inquiries') ?>" class="text-decoration-none small text-muted mb-1 d-inline-block">
                        <i class="bi bi-arrow-left me-1"></i> Back to Inquiries
                    </a>
                    <h4 class="fw-bold text-dark mb-0">Inquiry #<?= esc($inquiry['inquiry_no']) ?></h4>
                </div>
                <div>
                    <span class="badge bg-primary fs-6 px-3 py-1"><?= ucfirst(esc($inquiry['inquiry_type'])) ?> Inquiry</span>
                </div>
            </div>

            <!-- Customer Card -->
            <div class="p-3 bg-light rounded-3 mb-4 border">
                <div class="row g-2 small">
                    <div class="col-md-4">
                        <span class="text-muted d-block">Customer Name:</span>
                        <strong class="text-dark fs-6"><?= esc($inquiry['name']) ?></strong>
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted d-block">Phone:</span>
                        <a href="tel:<?= esc($inquiry['mobile']) ?>" class="text-decoration-none fw-bold text-dark">
                            <i class="bi bi-telephone text-success me-1"></i> <?= esc($inquiry['mobile']) ?>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted d-block">Email:</span>
                        <a href="mailto:<?= esc($inquiry['email']) ?>" class="text-decoration-none fw-bold text-dark">
                            <i class="bi bi-envelope text-info me-1"></i> <?= esc($inquiry['email']) ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Linked Product or Service -->
            <?php if ($inquiry['product_name']): ?>
                <div class="card border border-primary border-opacity-25 rounded-3 p-3 bg-primary bg-opacity-10 mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <span class="badge bg-primary mb-1">Inquiry for Product</span>
                            <h6 class="fw-bold text-dark mb-0"><?= esc($inquiry['product_name']) ?></h6>
                            <?php if ($inquiry['product_price']): ?>
                                <span class="text-muted small">Catalog Price: <strong>₹<?= number_format($inquiry['product_price'], 2) ?></strong></span>
                            <?php endif; ?>
                        </div>
                        <a href="<?= base_url('products/' . esc($inquiry['product_slug'])) ?>" class="btn btn-sm btn-primary" target="_blank">
                            <i class="bi bi-box-arrow-up-right me-1"></i> View Product
                        </a>
                    </div>
                </div>
            <?php elseif ($inquiry['service_name']): ?>
                <div class="card border border-info border-opacity-25 rounded-3 p-3 bg-info bg-opacity-10 mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <span class="badge bg-info text-dark mb-1">Inquiry for Service</span>
                            <h6 class="fw-bold text-dark mb-0"><?= esc($inquiry['service_name']) ?></h6>
                        </div>
                        <a href="<?= base_url('services/' . esc($inquiry['service_slug'])) ?>" class="btn btn-sm btn-info text-dark" target="_blank">
                            <i class="bi bi-box-arrow-up-right me-1"></i> View Service
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Original Customer Message -->
            <div class="mb-4">
                <h6 class="fw-bold text-dark mb-2">Subject: <span class="text-primary"><?= esc($inquiry['subject']) ?></span></h6>
                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                        <span><strong>Customer Message</strong></span>
                        <span><?= date('d M Y, h:i A', strtotime($inquiry['created_at'])) ?></span>
                    </div>
                    <p class="mb-0 text-dark small" style="white-space: pre-wrap;"><?= esc($inquiry['message']) ?></p>
                </div>
            </div>

            <!-- Existing Thread / Replies -->
            <div class="mb-4 pt-3 border-top">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-chat-dots-fill text-primary me-2"></i> Response History (<?= count($replies) ?>)</h6>

                <?php if (empty($replies)): ?>
                    <p class="text-muted small mb-0">No replies sent yet. Use the reply box on the right to respond.</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($replies as $reply): ?>
                            <div class="card border-0 bg-light rounded-3 p-3 border-start border-4 border-primary">
                                <div class="d-flex justify-content-between align-items-center mb-2 small">
                                    <span class="fw-bold text-primary"><i class="bi bi-person-check-fill me-1"></i> <?= esc($reply['sender_name'] ?? 'Admin') ?> (Shopkeeper)</span>
                                    <span class="text-muted"><?= date('d M Y, h:i A', strtotime($reply['created_at'])) ?></span>
                                </div>
                                <p class="mb-0 text-dark small" style="white-space: pre-wrap;"><?= esc($reply['message']) ?></p>
                                <?php if ($reply['sent_email']): ?>
                                    <div class="mt-2 text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-envelope-check-fill text-success me-1"></i> Notification sent to customer email
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Column: Reply Form, Status Updater & Direct WhatsApp -->
    <div class="col-lg-4">
        <!-- Reply Box -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-reply-fill text-primary me-1"></i> Send Reply to Customer</h5>

            <form action="<?= base_url('admin/inquiries/reply/' . $inquiry['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Reply Message <span class="text-danger">*</span></label>
                    <textarea name="message" class="form-control" rows="5" required placeholder="Write your response, pricing quote, or stock availability..."></textarea>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="send_email" value="1" id="checkEmail" checked>
                    <label class="form-check-label small fw-semibold" for="checkEmail">Send copy to customer email (<?= esc($inquiry['email']) ?>)</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">
                    <i class="bi bi-send-fill me-1"></i> Post Reply
                </button>
            </form>
        </div>

        <!-- Status & Internal Notes -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-gear-fill text-secondary me-1"></i> Status & Internal Notes</h5>

            <form action="<?= base_url('admin/inquiries/update-status/' . $inquiry['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Inquiry Status</label>
                    <select name="status" class="form-select">
                        <option value="pending" <?= $inquiry['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="in_progress" <?= $inquiry['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="replied" <?= $inquiry['status'] === 'replied' ? 'selected' : '' ?>>Replied</option>
                        <option value="closed" <?= $inquiry['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Internal Shopkeeper Notes</label>
                    <textarea name="admin_notes" class="form-control" rows="3" placeholder="Private notes (visible only to admin)..."><?= esc($inquiry['admin_notes']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-dark w-100 fw-bold py-2">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Direct WhatsApp Quick Chat with Customer -->
        <?php 
            $custPhone = preg_replace('/[^0-9]/', '', $inquiry['mobile']);
            if (strlen($custPhone) === 10) $custPhone = '91' . $custPhone;
            $custWaUrl = "https://wa.me/{$custPhone}?text=" . urlencode("Hello {$inquiry['name']},\n\nThis is Gourav Joshi from Balaji Computech regarding your inquiry #{$inquiry['inquiry_no']} on {$inquiry['subject']}.");
        ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-success bg-opacity-10 border border-success border-opacity-25 text-center">
            <i class="bi bi-whatsapp text-success fs-2 mb-2"></i>
            <h6 class="fw-bold text-dark mb-1">Direct WhatsApp Chat</h6>
            <p class="small text-muted mb-3">Open a direct WhatsApp chat on customer's phone number.</p>
            <a href="<?= $custWaUrl ?>" target="_blank" class="btn btn-success fw-bold w-100">
                <i class="bi bi-whatsapp me-1"></i> WhatsApp Customer
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
