<?php

use app\models\Transport;
use yii\helpers\Url;

$this->title = 'Kanban перевозок';
?>

<div class="kanban">

    <h1>🚚 Kanban-доска перевозок</h1>

    <div class="board">

        <?php foreach ($grouped as $status => $items): ?>

            <div class="column">

                <div class="column-title">
                    <?= Transport::getStatusLabel($status) ?>
                </div>

                <div class="column-body" data-status="<?= $status ?>">

                    <?php foreach ($items as $item): ?>
                        <div class="card">

                            <div class="column-title">
                                <?= Transport::getStatusLabel($status) ?>
                            </div>
                            <div class="route">
                                <?= $item->from_address ?> → <?= $item->to_address ?>
                            </div>

                            <div class="actions">
                                <?php if ($status === 'pending'): ?>
                                    <a class="status-btn assign"
                                       href="<?= Url::to(['change-status', 'id' => $item->id, 'status' => 'assigned']) ?>">
                                        Назначить
                                    </a>
                                <?php endif; ?>

                                <?php if ($status === 'assigned'): ?>
                                    <a class="status-btn transit"
                                       href="<?= Url::to(['change-status', 'id' => $item->id, 'status' => 'in_transit']) ?>">
                                        Отправить
                                    </a>
                                <?php endif; ?>

                                <?php if ($status === 'in_transit'): ?>
                                    <a class="status-btn done"
                                       href="<?= Url::to(['change-status', 'id' => $item->id, 'status' => 'delivered']) ?>">
                                        Завершить
                                    </a>
                                <?php endif; ?>

                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>
<script>
    async function loadKanban() {
        const res = await fetch('/transport/kanban-data');
        const data = await res.json();

        document.querySelectorAll('.column-body').forEach(el => {
            el.innerHTML = '';
        });

        for (const status in data) {
            const column = document.querySelector(`[data-status="${status}"]`);
            if (!column) continue;

            data[status].forEach(item => {
                const card = document.createElement('div');
                card.className = 'card';

                card.innerHTML = `
                <div class="title">${item.title}</div>
                <div class="route">${item.from} → ${item.to}</div>
            `;

                column.appendChild(card);
            });
        }
    }

    setInterval(loadKanban, 3000);
    loadKanban();
</script>
<script>
    async function refreshKanban() {
        const res = await fetch('/site/dispatch-events');
        const events = await res.json();

        const hasUpdate = events.some(e =>
            e.type.includes('transport')
        );

        if (hasUpdate) {
            location.reload(); // v1 realtime (простая версия)
        }
    }

    setInterval(refreshKanban, 4000);
</script>