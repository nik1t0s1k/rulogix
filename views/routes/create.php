<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Создание маршрута';
?>

<div class="create-page">

    <div class="header">
        <h1>🗺 Новый маршрут</h1>
        <p>Добавьте маршрут перевозки</p>
    </div>

    <div class="form-card">

        <?php $form = ActiveForm::begin(); ?>

        <div class="grid">

            <div class="field full">
                <?= $form->field($model, 'title')
                    ->textInput(['placeholder' => 'Название маршрута'])
                    ->label('Название') ?>
            </div>

            <div class="field full">
                <?= $form->field($model, 'from_address')
                    ->textInput(['placeholder' => 'Откуда'])
                    ->label('Точка отправления') ?>
            </div>

            <div class="field full">
                <?= $form->field($model, 'to_address')
                    ->textInput(['placeholder' => 'Куда'])
                    ->label('Точка назначения') ?>
            </div>

            <div class="field">
                <?= $form->field($model, 'distance')
                    ->textInput(['placeholder' => 'км'])
                    ->label('Дистанция') ?>
            </div>

            <div class="field">
                <?= $form->field($model, 'status')
                    ->dropDownList([
                        'active' => 'Активный',
                        'paused' => 'Приостановлен'
                    ])
                    ->label('Статус') ?>
            </div>

        </div>

        <div class="actions">
            <?= Html::submitButton('Создать маршрут', ['class' => 'btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<style>

    .create-page {
        max-width:900px;
        margin:0 auto;
        padding:20px;
    }

    .header h1 {
        margin:0;
        font-size:26px;
    }

    .header p {
        color:#64748b;
        margin-top:5px;
    }

    .form-card {
        background:#fff;
        border-radius:18px;
        padding:24px;
        box-shadow:0 10px 30px rgba(0,0,0,0.05);
    }

    .grid {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:16px;
    }

    .field.full {
        grid-column:span 2;
    }

    input, select {
        width:100%;
        padding:12px;
        border-radius:12px;
        border:1px solid #e2e8f0;
        outline:none;
    }

    input:focus, select:focus {
        border-color:#6366f1;
        box-shadow:0 0 0 3px rgba(99,102,241,0.15);
    }

    label {
        font-size:13px;
        color:#475569;
        margin-bottom:6px;
    }

    .actions {
        margin-top:18px;
    }

    .btn-primary {
        width:100%;
        padding:12px;
        border:none;
        border-radius:12px;
        background:linear-gradient(135deg,#6366f1,#4f46e5);
        color:#fff;
        font-weight:600;
        cursor:pointer;
    }

    @media(max-width:768px){
        .grid {
            grid-template-columns:1fr;
        }
        .field.full {
            grid-column:span 1;
        }
    }

</style>