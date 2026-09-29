<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-sliders text-primary me-2"></i> Website & Shop Settings</h4>
    </div>

    <form action="<?= base_url('admin/settings/update') ?>" method="POST">
        <?= csrf_field() ?>

        <ul class="nav nav-pills mb-4" id="settingTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="general-tab" data-bs-toggle="pill" data-bs-target="#general-pane" type="button" role="tab">General & Shop</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="contact-tab" data-bs-toggle="pill" data-bs-target="#contact-pane" type="button" role="tab">Contact & Location</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="home-tab" data-bs-toggle="pill" data-bs-target="#home-pane" type="button" role="tab">Homepage Banner</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="seo-tab" data-bs-toggle="pill" data-bs-target="#seo-pane" type="button" role="tab">SEO Defaults</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="firebase-tab" data-bs-toggle="pill" data-bs-target="#firebase-pane" type="button" role="tab">Firebase Push</button>
            </li>
        </ul>

        <div class="tab-content" id="settingTabsContent">
            <!-- General & Shop -->
            <div class="tab-pane fade show active" id="general-pane" role="tabpanel">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Shop / Website Name</label>
                        <input type="text" name="settings[site_name]" class="form-control" value="<?= esc($settings['site_name'] ?? 'Balaji Computech') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Proprietor / Owner Name</label>
                        <input type="text" name="settings[owner_name]" class="form-control" value="<?= esc($settings['owner_name'] ?? 'Gourav Joshi') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Shop Tagline</label>
                    <input type="text" name="settings[site_tagline]" class="form-control" value="<?= esc($settings['site_tagline'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Operating Hours</label>
                    <input type="text" name="settings[opening_hours]" class="form-control" value="<?= esc($settings['opening_hours'] ?? '') ?>">
                </div>
            </div>

            <!-- Contact & Location -->
            <div class="tab-pane fade" id="contact-pane" role="tabpanel">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Helpline Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold text-muted">+91</span>
                            <input type="tel" name="settings[contact_phone]" class="form-control" value="<?= esc(ltrim($settings['contact_phone'] ?? '', '+91')) ?>" placeholder="9826012345" pattern="^(\+91[\-\s]?)?[6-9]\d{9}$" maxlength="13" inputmode="numeric">
                        </div>
                        <div class="form-text small">Accepts 10-digit number (e.g. 9826012345) or +919826012345.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">WhatsApp Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold text-muted">+91</span>
                            <input type="tel" name="settings[whatsapp_number]" class="form-control font-monospace" value="<?= esc(ltrim($settings['whatsapp_number'] ?? '', '+91')) ?>" placeholder="9826012345" pattern="^(\+91[\-\s]?)?[6-9]\d{9}$" maxlength="13" inputmode="numeric">
                        </div>
                        <div class="form-text small">Normalized and stored automatically as +91XXXXXXXXXX.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Contact Email Address</label>
                    <input type="email" name="settings[contact_email]" class="form-control" value="<?= esc($settings['contact_email'] ?? '') ?>" placeholder="info@balajicomputech.com" maxlength="150">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Shop Physical Address</label>
                    <textarea name="settings[shop_address]" class="form-control" rows="2"><?= esc($settings['shop_address'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Google Maps Embed iframe</label>
                    <textarea name="settings[google_maps_embed]" class="form-control font-monospace" rows="4"><?= esc($settings['google_maps_embed'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Homepage Banner -->
            <div class="tab-pane fade" id="home-pane" role="tabpanel">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Homepage Hero Main Title</label>
                    <input type="text" name="settings[hero_title]" class="form-control" value="<?= esc($settings['hero_title'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Homepage Hero Subtitle</label>
                    <textarea name="settings[hero_subtitle]" class="form-control" rows="3"><?= esc($settings['hero_subtitle'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- SEO Defaults -->
            <div class="tab-pane fade" id="seo-pane" role="tabpanel">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Default Meta Title</label>
                    <input type="text" name="settings[meta_title]" class="form-control" value="<?= esc($settings['meta_title'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Default Meta Description</label>
                    <textarea name="settings[meta_description]" class="form-control" rows="4"><?= esc($settings['meta_description'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Firebase Cloud Messaging (Web Push) -->
            <div class="tab-pane fade" id="firebase-pane" role="tabpanel">
                <div class="alert alert-info py-2 px-3 small mb-4">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    Configure Firebase Web Push credentials for free instant alerts on new inquiries and replies. You can also configure these in your <code>.env</code> file.
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Firebase Project ID</label>
                        <input type="text" name="settings[firebase_project_id]" class="form-control font-monospace" value="<?= esc($settings['firebase_project_id'] ?? '') ?>" placeholder="e.g. balaji-computech-12345">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Firebase Web API Key</label>
                        <input type="text" name="settings[firebase_web_api_key]" class="form-control font-monospace" value="<?= esc($settings['firebase_web_api_key'] ?? '') ?>" placeholder="AIzaSy...">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Firebase Auth Domain</label>
                        <input type="text" name="settings[firebase_web_auth_domain]" class="form-control font-monospace" value="<?= esc($settings['firebase_web_auth_domain'] ?? '') ?>" placeholder="e.g. balaji-computech-12345.firebaseapp.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Messaging Sender ID</label>
                        <input type="text" name="settings[firebase_web_messaging_sender_id]" class="form-control font-monospace" value="<?= esc($settings['firebase_web_messaging_sender_id'] ?? '') ?>" placeholder="e.g. 109283746501">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Firebase Web App ID</label>
                        <input type="text" name="settings[firebase_web_app_id]" class="form-control font-monospace" value="<?= esc($settings['firebase_web_app_id'] ?? '') ?>" placeholder="e.g. 1:109283746501:web:abcdef...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Firebase Web Push VAPID Key (Public Key)</label>
                        <input type="text" name="settings[firebase_web_vapid_key]" class="form-control font-monospace" value="<?= esc($settings['firebase_web_vapid_key'] ?? '') ?>" placeholder="e.g. BNabcdef...">
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <button type="submit" class="btn btn-primary fw-bold px-5 py-2 shadow-sm">
            <i class="bi bi-check2-circle me-1"></i> Save All Settings
        </button>
    </form>
</div>

<?= $this->endSection() ?>
