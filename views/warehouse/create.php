<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Создание склада';
?>

<div class="create-page">

    <div class="header">
        <h1>🏭 Новый склад</h1>
        <p>Добавьте склад в систему логистики</p>
    </div>

    <div class="form-card">

        <?php $form = ActiveForm::begin(); ?>

        <div class="grid">

            <div class="field full">
                <?= $form->field($model, 'name')
                    ->textInput(['placeholder' => 'Название склада'])
                    ->label('Название') ?>
            </div>

            <div class="field full">
                <?= $form->field($model, 'address')
                    ->textInput(['placeholder' => 'Адрес склада'])
                    ->label('Адрес') ?>
            </div>

            <div class="field">
                <?= $form->field($model, 'capacity')
                    ->textInput(['placeholder' => 'Общий объём'])
                    ->label('Ёмкость (m³)') ?>
            </div>

            <div class="field">
                <?= $form->field($model, 'used_capacity')
                    ->textInput(['placeholder' => 'Занято'])
                    ->label('Занято (m³)') ?>
            </div>

        </div>

        <div class="actions">
            <?= Html::submitButton('Создать склад', ['class' => 'btn-primary']) ?>
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

    /* HEADER */
    .header h1 {
        margin:0;
        font-size:26px;
    }

    .header p {
        color:#64748b;
        margin-top:5px;
    }

    /* FORM */
    .form-card {
        background:#fff;
        border-radius:18px;
        padding:24px;
        box-shadow:0 10px 30px rgba(0,0,0,0.05);
    }

    /* GRID */
    .grid {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:16px;
    }

    .field.full {
        grid-column:span 2;
    }

    /* INPUTS */
    input {
        width:100%;
        padding:12px;
        border-radius:12px;
        border:1px solid #e2e8f0;
        outline:none;
    }

    input:focus {
        border-color:#6366f1;
        box-shadow:0 0 0 3px rgba(99,102,241,0.15);
    }

    /* LABEL */
    label {
        font-size:13px;
        color:#475569;
        margin-bottom:6px;
    }

    /* BUTTON */
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

    .btn-primary:hover {
        transform:translateY(-2px);
    }

    /* RESPONSIVE */
    @media(max-width:768px){
        .grid {
            grid-template-columns:1fr;
        }

        .field.full {
            grid-column:span 1;
        }
    }

</style>