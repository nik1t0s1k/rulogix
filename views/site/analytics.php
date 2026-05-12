<?php

use app\models\Transport;

$this->title = 'Аналитика';
?>

<div class="analytics-page">

    <!-- HEADER -->
    <div class="analytics-header">
        <div>
            <h1>📊 Аналитика логистики</h1>
            <p>Обзор перевозок и текущих процессов</p>
        </div>
    </div>

    <!-- KPI -->
    <div class="kpi-grid">

        <div class="kpi-card">
            <div class="kpi-label">Всего перевозок</div>
            <div class="kpi-value"><?= $total ?></div>
        </div>

        <div class="kpi-card pending">
            <div class="kpi-label"><?= Transport::getStatusLabel('pending') ?></div>
            <div class="kpi-value"><?= $pending ?></div>
        </div>

        <div class="kpi-card transit">
            <div class="kpi-label"><?= Transport::getStatusLabel('in_transit') ?></div>
            <div class="kpi-value"><?= $inTransit ?></div>
        </div>

        <div class="kpi-card delivered">
            <div class="kpi-label"><?= Transport::getStatusLabel('delivered') ?></div>
            <div class="kpi-value"><?= $delivered ?></div>
        </div>

    </div>

    <!-- CHART -->
    <div class="chart-card">

        <div class="chart-top">
            <h3>Статистика перевозок</h3>
            <span>Текущие статусы</span>
        </div>

        <canvas id="transportChart"></canvas>

    </div>

    <!-- TABLE -->
    <table class="analytics-table">

        <thead>
        <tr>
            <th>Статус</th>
            <th>Количество</th>
            <th>Доля</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td><?= Transport::getStatusLabel('pending') ?></td>
            <td><?= $pending ?></td>
            <td><?= $total ? round($pending / $total * 100, 1) : 0 ?>%</td>
        </tr>

        <tr>
            <td><?= Transport::getStatusLabel('in_transit') ?></td>
            <td><?= $inTransit ?></td>
            <td><?= $total ? round($inTransit / $total * 100, 1) : 0 ?>%</td>
        </tr>

        <tr>
            <td><?= Transport::getStatusLabel('delivered') ?></td>
            <td><?= $delivered ?></td>
            <td><?= $total ? round($delivered / $total * 100, 1) : 0 ?>%</td>
        </tr>
        </tbody>

    </table>

</div>

<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('transportChart');

    new Chart(ctx, {
        type: 'bar',

        data: {
            labels: [
                '<?= Transport::getStatusLabel("pending") ?>',
                '<?= Transport::getStatusLabel("in_transit") ?>',
                '<?= Transport::getStatusLabel("delivered") ?>'
            ],

            datasets: [{
                label: 'Количество',
                data: [
                    <?= $pending ?>,
                    <?= $inTransit ?>,
                    <?= $delivered ?>
                ],
                backgroundColor: [
                    '#f59e0b',
                    '#3b82f6',
                    '#22c55e'
                ],
                borderRadius: 14,
                borderSkipped: false,
            }]
        },

        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });
</script>

<!-- LIVE UPDATE -->
<script>
    setInterval(async () => {
        const res = await fetch('/site/dispatch-events');
        const events = await res.json();

        if (events.length > 0) {
            location.reload();
        }
    }, 5000);
</script>

<!-- STYLES -->
<style>

    .analytics-page {
        padding: 20px;
    }

    /* HEADER */
    .analytics-header h1 {
        margin: 0;
        font-size: 24px;
    }

    .analytics-header p {
        color: #64748b;
        margin-top: 6px;
    }

    /* KPI */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin: 20px 0;
    }

    .kpi-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        border: 1px solid rgba(15,23,42,0.06);
        transition: .2s;
    }

    .kpi-card:hover {
        transform: translateY(-3px);
    }

    .kpi-label {
        font-size: 13px;
        color: #64748b;
    }

    .kpi-value {
        font-size: 26px;
        font-weight: 700;
        margin-top: 6px;
    }

    .kpi-card.pending { border-left: 4px solid #f59e0b; }
    .kpi-card.transit { border-left: 4px solid #3b82f6; }
    .kpi-card.delivered { border-left: 4px solid #22c55e; }

    /* CHART */
    .chart-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        border: 1px solid rgba(15,23,42,0.06);
    }

    .chart-top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .chart-top h3 {
        margin: 0;
    }

    .chart-top span {
        font-size: 12px;
        color: #94a3b8;
    }

    /* TABLE */
    .analytics-table {
        width: 100%;
        margin-top: 25px;
        border-collapse: collapse;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }

    .analytics-table th {
        text-align: left;
        padding: 14px;
        background: #f8fafc;
        font-size: 12px;
        color: #64748b;
    }

    .analytics-table td {
        padding: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .analytics-table tr:hover {
        background: #f8fafc;
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .kpi-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 500px) {
        .kpi-grid {
            grid-template-columns: 1fr;
        }
    }

</style>