<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold text-dark mb-0"><i class="bi bi-geo-alt-fill text-primary me-2"></i> Store Presence & Showroom Location</h4>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr class="text-muted text-uppercase">
                    <th>#</th>
                    <th>Showroom Title</th>
                    <th>Address</th>
                    <th>Contact Phone</th>
                    <th>Operating Hours</th>
                    <th>Primary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locations as $loc): ?>
                    <tr>
                        <td><?= $loc['id'] ?></td>
                        <td><strong class="text-dark"><?= esc($loc['title']) ?></strong></td>
                        <td>
                            <div><?= esc($loc['address_line1']) ?>, <?= esc($loc['address_line2']) ?></div>
                            <span class="text-muted small"><?= esc($loc['city']) ?>, <?= esc($loc['state']) ?> - <?= esc($loc['pincode']) ?></span>
                        </td>
                        <td><?= esc($loc['phone']) ?></td>
                        <td><div class="text-muted small text-truncate" style="max-width: 200px;"><?= esc($loc['opening_hours']) ?></div></td>
                        <td>
                            <?= $loc['is_primary'] ? '<span class="badge bg-primary">Primary Location</span>' : '<span class="badge bg-light text-muted border">Branch</span>' ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/presence/edit/' . $loc['id']) ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil me-1"></i> Edit Details
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
