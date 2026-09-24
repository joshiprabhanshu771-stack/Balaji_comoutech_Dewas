<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-primary bg-opacity-10 py-5 mb-5 border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold text-dark mb-2"><?= esc($page['title']) ?></h1>
        <p class="text-muted mb-0">Balaji Computech - Dewas, Madhya Pradesh</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white cms-page-content">
                <?= $page['content'] ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
