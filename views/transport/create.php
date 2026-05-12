<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Создание перевозки';
?>

<div class="create-page">

    <div class="header">
        <div>
            <h1>🚚 Новая перевозка</h1>
            <p>Создайте заявку на транспортировку груза</p>
        </div>
    </div>

    <div class="form-wrapper">

        <?php $form = ActiveForm::begin(); ?>

        <div class="grid">

            <div class="field">
                <?= $form->field($model, 'title')
                        ->textInput(['placeholder' => 'Название перевозки'])
                        ->label('Название') ?>
            </div>

            <div class="field">
                <?= $form->field($model, 'cargo_weight')
                        ->textInput(['placeholder' => 'Вес (кг)'])
                        ->label('Вес груза') ?>
            </div>

            <div class="field full">
                <?= $form->field($model, 'from_address')
                        ->textInput(['placeholder' => 'Откуда'])
                        ->label('Адрес отправления') ?>
            </div>

            <div class="field full">
                <?= $form->field($model, 'to_address')
                        ->textInput(['placeholder' => 'Куда'])
                        ->label('Адрес назначения') ?>
            </div>

            <div class="field full">
                <?= $form->field($model, 'description')
                        ->textarea(['rows' => 4, 'placeholder' => 'Описание груза'])
                        ->label('Описание') ?>
            </div>

        </div>

        <div class="actions">
            <?= Html::submitButton('Создать перевозку', ['class' => 'btn']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<style>

    .create-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    /* HEADER */
    .header {
        margin-bottom: 20px;
    }

    .header h1 {
        font-size: 26px;
        margin: 0;
    }

    .header p {
        color: #64748b;
        margin-top: 5px;
    }

    /* FORM CARD */
    .form-wrapper {
        background: #fff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* GRID */
    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .field.full {
        grid-column: span 2;
    }

    /* INPUTS */
    input, textarea {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        outline: none;
        transition: 0.2s;
        background: #fff;
    }

    input:focus, textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }

    /* LABELS */
    label {
        font-size: 13px;
        color: #475569;
        margin-bottom: 6px;
        display: block;
    }

    /* BUTTON */
    .actions {
        margin-top: 18px;
    }

    .btn {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(99,102,241,0.25);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .grid {
            grid-template-columns: 1fr;
        }

        .field.full {
            grid-column: span 1;
        }
    }

</style>