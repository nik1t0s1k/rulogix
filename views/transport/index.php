<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Перевозки';
?>

<div class="transport-page">

    <!-- HEADER -->
    <div class="transport-header">

        <div>
            <h1>🚚 Перевозки</h1>
            <p>Управление всеми логистическими операциями</p>
        </div>

        <a href="<?= Url::to(['transport/create']) ?>" class="action-card">
            + Создать перевозку
        </a>

    </div>

    <!-- GRID -->
    <div class="transport-grid">

        <?php foreach ($items as $item): ?>

            <div class="transport-card">

                <div class="transport-title">
                    <?= Html::encode($item->title) ?>
                </div>

                <div class="transport-route">
                    <?= $item->from_address ?> → <?= $item->to_address ?>
                </div>

                <?php
                $map = [
                        'pending' => 'badge pending',
                        'assigned' => 'badge info',
                        'in_transit' => 'badge primary',
                        'delivered' => 'badge success',
                        'cancelled' => 'badge danger',
                ];
                ?>

                <div style="margin-top:12px;">
                    <span class="<?= $map[$item->status] ?? 'badge' ?>">
                        <?= \app\models\Transport::statusList()[$item->status] ?? $item->status ?>
                    </span>
                </div>

                <div class="transport-footer">
                    <div class="weight">
                        <?= $item->cargo_weight ?> kg
                    </div>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<style>

    /* ===== PAGE ===== */
    .transport-page {
        padding: 20px;
    }

    /* ===== HEADER ===== */
    .transport-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:30px;
    }

    .transport-header h1 {
        font-size: 26px;
        margin: 0;
    }

    .transport-header p {
        color: #64748b;
    }

    /* ===== GRID ===== */
    .transport-grid {
        display:grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    /* ===== CARD ===== */
    .transport-card {
        background:#fff;
        border-radius:16px;
        padding:16px;
        box-shadow:0 10px 30px rgba(0,0,0,0.05);
        transition:.2s;
    }

    .transport-card:hover {
        transform: translateY(-3px);
    }

    /* ===== TEXT ===== */
    .transport-title {
        font-weight:700;
        font-size:16px;
        margin-bottom:6px;
    }

    .transport-route {
        font-size:13px;
        color:#64748b;
    }

    /* ===== FOOTER ===== */
    .transport-footer {
        margin-top:12px;
        display:flex;
        justify-content:space-between;
        align-items:center;
    }

    .weight {
        font-size:13px;
        color:#475569;
    }

    /* ===== BUTTON (reuse dashboard style) ===== */
    .action-card {
        padding: 12px 16px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color:#fff;
        border-radius:14px;
        text-decoration:none;
        font-weight:600;
        transition:.2s;
    }

    .action-card:hover {
        transform: translateY(-3px);
    }

    /* ===== BADGES ===== */
    .badge {
        font-size:12px;
        padding:4px 10px;
        border-radius:999px;
        display:inline-block;
    }

    .badge.pending { background:#fef3c7; color:#92400e; }
    .badge.info { background:#dbeafe; color:#1e40af; }
    .badge.primary { background:#e0e7ff; color:#3730a3; }
    .badge.success { background:#dcfce7; color:#166534; }
    .badge.danger { background:#fee2e2; color:#991b1b; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .transport-grid {
            grid-template-columns: 1fr;
        }

        .transport-header {
            flex-direction:column;
            align-items:flex-start;
            gap:10px;
        }
    }

</style>