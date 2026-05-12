<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Склады';
?>

<div class="page">

    <!-- HEADER -->
    <div class="page-header">
        <div>
            <h1>🏭 Склады</h1>
            <p>Управление складской инфраструктурой</p>
        </div>

        <a href="<?= Url::to(['warehouse/create']) ?>" class="btn-primary">
            + Новый склад
        </a>
    </div>

    <!-- GRID -->
    <div class="grid">

        <?php foreach ($items as $item): ?>

            <?php
            $percent = $item->capacity > 0
                ? round(($item->used_capacity / $item->capacity) * 100)
                : 0;
            ?>

            <div class="card">

                <div class="card-title">
                    <?= Html::encode($item->name) ?>
                </div>

                <div class="card-subtitle">
                    📍 <?= Html::encode($item->address) ?>
                </div>

                <div class="row">
                    <span>Ёмкость</span>
                    <b><?= $item->capacity ?> m³</b>
                </div>

                <div class="row">
                    <span>Используется</span>
                    <b><?= $item->used_capacity ?> m³</b>
                </div>

                <div class="progress">
                    <div class="bar" style="width: <?= $percent ?>%"></div>
                </div>

                <div class="percent"><?= $percent ?>% заполнено</div>

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

    .card-title {
        font-weight:700;
        font-size:16px;
    }

    .card-subtitle {
        color:#64748b;
        font-size:13px;
        margin-bottom:10px;
    }

    .row {
        display:flex;
        justify-content:space-between;
        margin:6px 0;
        font-size:13px;
        color:#334155;
    }

    /* PROGRESS */
    .progress {
        height:8px;
        background:#e2e8f0;
        border-radius:10px;
        margin-top:10px;
        overflow:hidden;
    }

    .bar {
        height:100%;
        background:linear-gradient(135deg,#6366f1,#4f46e5);
    }

    .percent {
        font-size:12px;
        color:#64748b;
        margin-top:6px;
    }

    @media (max-width:900px){
        .grid { grid-template-columns:1fr; }
    }

</style>