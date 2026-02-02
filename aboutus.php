<?php
require_once 'init.php';
$pageTitle = 'Rreth Nesh - Online CoffeeShop';

$aboutData = $content->getAllByPage('about');
$title = $aboutData['title'] ?? 'Rreth Nesh';
$aboutContent = $aboutData['content'] ?? 'Online CoffeeShop u themelua me dashurinë për kafën autentike.';
$mission = $aboutData['mission'] ?? 'Të ofrojmë kafë të cilësisë më të lartë.';
$sliderItems = $slider->getActive();
if (!empty($sliderItems)) {
    $aboutSlider = array_slice($sliderItems, 0, 2);
}

$extraHead = '<link rel="stylesheet" href="assets/css/slider.css">';
require_once 'includes/header.php';
?>
<div class="container">
    <section class="mb-5">
        <h1 class="section-title mb-4"><?= htmlspecialchars($title) ?></h1>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="lead"><?= nl2br(htmlspecialchars($aboutContent)) ?></p>
                <div class="card border-0 bg-light p-4 mt-3">
                    <h5 class="text-coffee"><i class="bi bi-bullseye me-2"></i>Misioni ynë</h5>
                    <p class="mb-0"><?= nl2br(htmlspecialchars($mission)) ?></p>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if (!empty($aboutSlider)): ?>
                <div id="aboutSlider" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-3 overflow-hidden shadow">
                        <?php foreach ($aboutSlider as $i => $item): ?>
                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                            <div class="slider-bg" style="height: 350px; background: linear-gradient(135deg, rgba(74,55,40,0.7), transparent), url('<?= htmlspecialchars($item['image_path'] ?: 'assets/images/coffee-bg.jpg') ?>') center/cover;"></div>
                            <div class="carousel-caption">
                                <h5><?= htmlspecialchars($item['title']) ?></h5>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#aboutSlider" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#aboutSlider" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <?php else: ?>
                <div class="bg-secondary rounded-3 d-flex align-items-center justify-content-center" style="height: 350px;">
                    <i class="bi bi-cup-hot display-1 text-white"></i>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<?php require_once 'includes/footer.php'; ?>