<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Дашборд';
?>

<div class="site-index">

    <!-- HERO -->
    <div class="mb-5">
        <h1 style="font-size: 32px; font-weight: 700;">Логистическая панель</h1>
        <p style="color: var(--muted);">Управляйте перевозками, складом и маршрутами в одном месте</p>
    </div>

    <!-- STATS -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card">
                <h6 style="color: var(--muted);">Активные перевозки</h6>
                <h2>128</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <h6 style="color: var(--muted);">Складские позиции</h6>
                <h2>542</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <h6 style="color: var(--muted);">Маршруты</h6>
                <h2>36</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <h6 style="color: var(--muted);">Задержки</h6>
                <h2 style="color:#ef4444;">4</h2>
            </div>
        </div>

    </div>

    <!-- MAIN GRID -->
    <div class="row g-4">

        <!-- LEFT -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <h5>Последние перевозки</h5>
                <table class="table mt-3">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Маршрут</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>#1024</td>
                        <td>Москва → Казань</td>
                        <td><span class="badge bg-success">В пути</span></td>
                    </tr>
                    <tr>
                        <td>#1023</td>
                        <td>СПб → Москва</td>
                        <td><span class="badge bg-warning text-dark">Задержка</span></td>
                    </tr>
                    <tr>
                        <td>#1022</td>
                        <td>Новосибирск → Омск</td>
                        <td><span class="badge bg-secondary">Ожидание</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h5>Активность</h5>
                <p style="color: var(--muted);">Здесь можно подключить график (Chart.js / ApexCharts)</p>
                <div style="height:200px; display:flex; align-items:center; justify-content:center; color:#94a3b8;">
                    График
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-lg-4">

            <div class="card mb-4">
                <h5>Быстрые действия</h5>
                <div class="d-grid gap-2 mt-3">
                    <?= Html::a('Создать перевозку', ['/transport/create'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Добавить маршрут', ['/routes/create'], ['class' => 'btn btn-outline-primary']) ?>
                    <?= Html::a('Открыть склад', ['/warehouse/index'], ['class' => 'btn btn-outline-secondary']) ?>
                </div>
            </div>

            <div class="card">
                <h5>Уведомления</h5>
                <ul class="mt-3" style="padding-left:16px; color: var(--muted);">
                    <li>Задержка по маршруту #1023</li>
                    <li>Новый заказ добавлен</li>
                    <li>Обновление склада</li>
                </ul>
            </div>

        </div>

    </div>

</div>
