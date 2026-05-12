<?php

use yii\helpers\Html;

$this->title = 'Dashboard';
?>

<div class="dashboard">

    <!-- HEADER -->
    <div class="dash-header">
        <div>
            <h1>Добро пожаловать, <?= Html::encode($user->username) ?> 👋</h1>
            <p>Обзор логистической системы</p>
        </div>

        <div class="dash-avatar">
            <?php if (!empty($user->avatar)): ?>
                <img src="..<?= $user->avatar ?>">
            <?php else: ?>
                <div class="no-avatar">👤</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-title">Перевозки</div>
            <div class="stat-value"><?= $stats['transport'] ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Склады</div>
            <div class="stat-value"><?= $stats['warehouse'] ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Маршруты</div>
            <div class="stat-value"><?= $stats['routes'] ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Активные заказы</div>
            <div class="stat-value"><?= $stats['active_orders'] ?></div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="actions">
        <a href="../transport/create" class="action-card">➕ Создать перевозку</a>
        <a href="../warehouse/create" class="action-card">📦 Добавить склад</a>
        <a href="../routes/create" class="action-card">🗺 Построить маршрут</a>
    </div>

</div>

<style>

    .dashboard {
        padding: 20px;
    }

    /* HEADER */
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .dash-header h1 {
        font-size: 26px;
        margin: 0;
    }

    .dash-header p {
        color: #64748b;
    }

    .dash-avatar img,
    .no-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }

    .no-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e2e8f0;
    }

    /* STATS */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .stat-title {
        font-size: 13px;
        color: #64748b;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        margin-top: 5px;
    }

    /* ACTIONS */
    .actions {
        display: flex;
        gap: 15px;
    }

    .action-card {
        flex: 1;
        padding: 16px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border-radius: 14px;
        text-decoration: none;
        text-align: center;
        font-weight: 600;
        transition: 0.2s;
    }

    .action-card:hover {
        transform: translateY(-3px);
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .actions {
            flex-direction: column;
        }
    }

</style>