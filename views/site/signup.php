<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\Signup $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Регистрация';
?>

<div class="login">

    <div class="login-bg"></div>

    <div class="login-container">

        <!-- LEFT INFO -->
        <div class="login-info">
            <div class="brand">Rulogix</div>

            <h1>Создайте аккаунт<br>и начните работу</h1>

            <p>
                Подключитесь к системе управления логистикой,
                контролируйте перевозки, склады и маршруты.
            </p>

            <div class="features">
                <div>⚡ Быстрый старт без сложной настройки</div>
                <div>📦 Полный контроль логистики</div>
                <div>📊 Аналитика и отчёты в реальном времени</div>
            </div>
        </div>

        <!-- REGISTER CARD -->
        <div class="login-card">

            <h2>Регистрация</h2>
            <p class="sub">Создайте новый аккаунт</p>

            <?php $form = ActiveForm::begin([
                    'id' => 'signup-form',
                    'options' => ['class' => 'form']
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                    'placeholder' => 'Логин'
            ])->label(false) ?>

            <?= $form->field($model, 'email')->textInput([
                    'placeholder' => 'Email'
            ])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => 'Пароль'
            ])->label(false) ?>

            <div class="actions">
                <?= Html::submitButton('Создать аккаунт', [
                        'class' => 'btn'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <div class="auth-extra">
                Уже есть аккаунт?
                <a href="<?= Yii::$app->urlManager->createUrl(['site/login']) ?>" class="auth-link-btn">
                    Войти
                </a>
            </div>

        </div>

    </div>

</div>
<style>
    .auth-extra {
        margin-top: 14px;
        text-align: center;
    }

    .auth-link-btn {
        display: inline-block;
        font-size: 13px;
        color: #6366f1;
        font-weight: 600;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 10px;
        transition: 0.2s;
    }

    .auth-link-btn:hover {
        background: rgba(99,102,241,0.08);
        color: #4f46e5;
    }
    html, body {
        height: 100%;
        margin: 0;
        font-family: Inter, system-ui, sans-serif;
    }

    /* ===== BACKGROUND ===== */
    .login {
        min-height: 60vh;
        display: grid;
        place-items: center;
        background: #f8fafc;
        position: relative;
        overflow: hidden;
        padding: 20px;
        box-sizing: border-box;
        border-radius: 10px ;
    }

    .login-bg::before,
    .login-bg::after {
        content: "";
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        filter: blur(90px);
        opacity: 0.35;
        animation: float 12s infinite ease-in-out;
    }

    .login-bg::before {
        background: #6366f1;
        top: -150px;
        left: -150px;
    }

    .login-bg::after {
        background: #38bdf8;
        bottom: -150px;
        right: -150px;
        animation-delay: 4s;
    }

    /* ===== LAYOUT ===== */
    .login-container {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 1000px;
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 50px;
    }

    /* LEFT */
    .login-info {
        padding: 20px;
    }

    .brand {
        font-weight: 700;
        color: #6366f1;
        margin-bottom: 30px;
        font-size: 14px;
    }

    .login-info h1 {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 16px;
        line-height: 1.1;
    }

    .login-info p {
        color: #64748b;
        font-size: 16px;
        line-height: 1.6;
    }

    .features {
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        color: #334155;
        font-weight: 500;
    }

    /* CARD */
    .login-card {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(12px);
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 32px;
        box-shadow: 0 30px 80px rgba(0,0,0,0.08);
    }

    .login-card h2 {
        font-weight: 700;
        margin-bottom: 6px;
    }

    .sub {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* FORM */
    .form input {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
        outline: none;
        transition: 0.2s;
    }

    .form input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
    }

    .actions .btn {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        background: #6366f1;
        border: none;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .actions .btn:hover {
        background: #4f46e5;
    }

    .hint {
        margin-top: 12px;
        text-align: center;
        font-size: 12px;
        color: #94a3b8;
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .login-container {
            grid-template-columns: 1fr;
        }

        .login-info {
            display: none;
        }
    }

    /* ANIMATION */
    @keyframes float {
        0% { transform: translate(0,0); }
        50% { transform: translate(30px,20px); }
        100% { transform: translate(0,0); }
    }
    .auth-extra {
        margin-top: 14px;
        text-align: center;
        font-size: 13px;
        color: #64748b;
    }

    .auth-link-btn {
        display: inline-block;
        font-size: 13px;
        color: #6366f1;
        font-weight: 600;
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 10px;
        transition: 0.2s;
    }

    .auth-link-btn:hover {
        background: rgba(99,102,241,0.08);
        color: #4f46e5;
    }
</style>