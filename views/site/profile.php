<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Личный кабинет';
?>

<div class="profile">

    <div class="profile-card">

        <h2>Личный кабинет</h2>
        <p class="sub">Управление аккаунтом</p>

        <div class="avatar-block">
            <?php if ($user->avatar): ?>
                <img src="..<?= $user->avatar ?>" class="avatar">
            <?php else: ?>
                <div class="avatar placeholder">👤</div>
            <?php endif; ?>
        </div>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Логин'])->label(false) ?>

        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

        <?= $form->field($model, 'full_name')->textInput(['placeholder' => 'ФИО'])->label(false) ?>

        <?= $form->field($model, 'avatar')->fileInput()->label('Аватар') ?>

        <div class="actions">
            <?= Html::submitButton('Сохранить', ['class' => 'profile-btn']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<style>
    .profile {
        min-height: 70vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile-card {
        width: 100%;
        max-width: 420px;
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.08);
    }

    .profile-card h2 {
        text-align: center;
        margin-bottom: 6px;
    }

    .sub {
        text-align: center;
        color: #64748b;
        margin-bottom: 20px;
    }

    .avatar-block {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        display: block;
    }

    .placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e2e8f0;
        font-size: 30px;
    }

    input {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
    }

    input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }

    .profile-btn {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        background: #6366f1;
        color: white;
        border: none;
        font-weight: 600;
        transition: 0.2s;
        cursor: pointer;
    }

    .profile-btn:hover {
        background: #4f46e5;
    }
</style>