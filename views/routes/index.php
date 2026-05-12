<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Маршруты';
?>

<div class="page">

    <!-- HEADER -->
    <div class="page-header">
        <div>
            <h1>🗺 Маршруты</h1>
            <p>Планирование логистических маршрутов</p>
        </div>

        <a href="<?= Url::to(['routes/create']) ?>" class="btn-primary">
            + Новый маршрут
        </a>
    </div>

    <!-- GRID -->
    <div class="grid">

        <?php foreach ($items as $item): ?>

            <div class="card">
                <?= \yii\helpers\Html::a(
                        $item->title,
                        ['routes/view', 'id' => $item->id],
                        ['class' => 'route-link']
                ) ?>


                <div class="route">
                    <span class="dot from"></span>
                    <?= Html::encode($item->from_address) ?>
                </div>

                <div class="route">
                    <span class="dot to"></span>
                    <?= Html::encode($item->to_address) ?>
                </div>

                <div class="meta">
                    <div>
                        <div class="label">Дистанция</div>
                        <div class="value"><?= $item->distance ?? '—' ?> km</div>
                    </div>

                    <div>
                        <div class="label">Статус</div>
                        <div class="status"><?= $item->status ?></div>
                    </div>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<style>

    .page { padding:20px; }

    .page-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:25px;
    }

    .page-header h1 {
        margin:0;
        font-size:26px;
    }

    .page-header p {
        margin:4px 0 0;
        color:#64748b;
    }

    .btn-primary {
        background:#6366f1;
        color:#fff;
        padding:10px 14px;
        border-radius:12px;
        text-decoration:none;
        font-weight:600;
    }

    /* GRID */
    .grid {
        display:grid;
        grid-template-columns:repeat(3, 1fr);
        gap:15px;
    }

    /* CARD */
    .card {
        background:#fff;
        border-radius:16px;
        padding:16px;
        box-shadow:0 10px 30px rgba(0,0,0,0.05);
    }

    .title {
        font-weight:700;
        margin-bottom:10px;
    }

    .route {
        font-size:13px;
        color:#334155;
        margin:6px 0;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .dot {
        width:8px;
        height:8px;
        border-radius:50%;
    }

    .dot.from { background:#6366f1; }
    .dot.to { background:#22c55e; }

    .meta {
        display:flex;
        justify-content:space-between;
        margin-top:12px;
    }

    .label {
        font-size:12px;
        color:#64748b;
    }

    .value {
        font-weight:600;
    }

    .status {
        font-size:12px;
        padding:4px 8px;
        background:#eef2ff;
        border-radius:8px;
    }

    @media (max-width:900px){
        .grid { grid-template-columns:1fr; }
    }

</style>