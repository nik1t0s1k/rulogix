<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Сервис для логистических компаний']);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= Html::encode($this->title) ?> Rulogix </title>
        <?php $this->head() ?>

        <style>
            body {
                background: #f8fafc;
                font-family: Inter, system-ui, sans-serif;
                position: relative;
                overflow-x: hidden;
            }

            /* ===== MAIN GRADIENT BLOBS ===== */
            body::before,
            body::after {
                content: "";
                position: fixed;
                width: 600px;
                height: 600px;
                border-radius: 50%;
                filter: blur(120px);
                opacity: 0.4;
                z-index: -2;
                animation: float 16s ease-in-out infinite;
            }

            body::before {
                background: #6366f1;
                top: -200px;
                left: -200px;
            }

            body::after {
                background: #38bdf8;
                bottom: -250px;
                right: -250px;
                animation-delay: 5s;
            }

            /* ===== GRID OVERLAY ===== */
            body {
                background-image:
                        radial-gradient(rgba(99,102,241,0.06) 1px, transparent 1px);
                background-size: 42px 42px;
            }

            /* ===== ANIMATION ===== */
            @keyframes float {
                0% { transform: translate(0,0) scale(1); }
                50% { transform: translate(40px,30px) scale(1.1); }
                100% { transform: translate(0,0) scale(1); }
            }

            .navbar {
                height: 56px;
                padding-top: 6px;
                padding-bottom: 6px;
                transition: transform 0.25s ease, opacity 0.25s ease;
                will-change: transform;
            }
            .navbar.navbar-hidden {
                transform: translateY(-100%);
                opacity: 0;
            }
            .navbar-brand {
                display: flex;
                align-items: center;
            }

            .navbar-logo {
                height: 150px;
                width: auto;
                object-fit: contain;
            }

            .nav-link {
                color: var(--muted) !important;
                font-weight: 500;
                position: relative;
            }

            .nav-link::after {
                content: '';
                position: absolute;
                bottom: -4px;
                left: 0;
                width: 0;
                height: 2px;
                background: var(--primary);
                transition: 0.25s;
            }

            .nav-link:hover {
                color: var(--primary) !important;
            }

            .nav-link:hover::after {
                width: 100%;
            }

            /* LAYOUT */
            .main-container {
                padding-top: 80px;
            }

            /* CARD */
            .card {
                background: var(--card);
                padding: 18px; /* было 10 */
                border-radius: 16px;
                border: none;
                box-shadow:
                        0 10px 30px rgba(0,0,0,0.05),
                        0 2px 10px rgba(0,0,0,0.03);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .card:hover {
                transform: translateY(-4px);
                box-shadow:
                        0 20px 40px rgba(0,0,0,0.08),
                        0 5px 20px rgba(0,0,0,0.05);
            }

            /* BREADCRUMBS */
            .breadcrumb {
                background: transparent;
                font-size: 14px;
            }

            /* FOOTER */
            footer {
                background: transparent;
                color: var(--muted);
                font-size: 14px;
            }

            /* EXTRA POLISH */
            .main-container.container {
                max-width: 1500px;
            }

            .btn-link {
                text-decoration: none;
            }
            header {
                height: 10px !important;
            }

            .btn-link:hover {
                opacity: 0.7;
            }
            .navbar-nav .nav-link {
                font-size: 14px;
                padding: 6px 10px;
            }

        </style>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
                'brandLabel' => Html::img('@web/images/logo.png', [
                        'alt' => 'Logo',
                        'class' => 'navbar-logo'
                ]),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                        'class' => 'navbar navbar-expand-lg fixed-top px-4'
                ]
        ]);

        $menuItems = [];

        // Только для авторизованных
        if (!Yii::$app->user->isGuest) {

            $menuItems[] = ['label' => 'Дашборд', 'url' => ['/site/dashboard']];

            $menuItems[] = ['label' => 'Аналитика', 'url' => ['/site/analytics']];

            $menuItems[] = ['label' => 'Канбан', 'url' => ['/transport/kanban']];

            $menuItems[] = ['label' => 'Перевозки', 'url' => ['/transport/index']];

            $menuItems[] = ['label' => 'Склады', 'url' => ['/warehouse/index']];

            $menuItems[] = ['label' => 'Маршруты', 'url' => ['/routes/index']];

            $menuItems[] = ['label' => 'Профиль', 'url' => ['/site/profile']];
            $menuItems[] = [
                    'label' => 'AI Ассистент 🤖',
                    'url' => ['/ai/index'],
                    'linkOptions' => [
                            'class' => 'nav-link ai-btn'
                    ]
            ];
        }

        // Guest menu
        if (Yii::$app->user->isGuest) {

            $menuItems[] = [
                    'label' => 'Вход',
                    'url' => ['/site/login']
            ];

        } else {

            $menuItems[] = [
                    'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => [
                            'data-method' => 'post',
                            'class' => 'nav-link btn btn-link'
                    ]
            ];
        }

        echo Nav::widget([
                'options' => [
                        'class' => 'navbar-nav ms-auto align-items-center gap-3'
                ],
                'items' => $menuItems
        ]);

        NavBar::end();
        ?>

    </header>

    <main class="main-container container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>

        <?= Alert::widget() ?>

        <div class="card">
            <?= $content ?>
        </div>
    </main>

    <footer class="mt-5 py-4">
        <div class="container d-flex justify-content-between">
            <div>
                &copy; Logistics Platform <?= date('Y') ?>
            </div>
            <div>
                Modern logistics UI • Fast • Clean
            </div>
        </div>
    </footer>
<?php $this->registerJs("
    let lastScrollTop = 0;
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', function () {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop && scrollTop > 80) {
            // scroll down → hide
            navbar.classList.add('navbar-hidden');
        } else {
            // scroll up → show
            navbar.classList.remove('navbar-hidden');
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });
"); ?>
    <?php $this->endBody() ?>

    </body>

    </html>
<?php $this->endPage() ?>