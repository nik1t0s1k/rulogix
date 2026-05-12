<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class AiController extends Controller
{
    public function actionIndex()
    {
        while (ob_get_level()) ob_end_flush();
        return $this->render('index');
    }

    /* =========================
       SEND MESSAGE
    ========================= */
    public function actionSend()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        try {
            $message = Yii::$app->request->post('message');
            $chatId  = Yii::$app->request->post('chat_id');

            if (empty($message) || empty($chatId)) {
                return ['error' => 'empty message or chat_id'];
            }

            $userId = Yii::$app->user->id ?? 1;

            // =========================
            // 1. COMMAND LAYER (SAFE)
            // =========================
            $commandResult = null;

            try {
                $executor = new \app\services\ai\AiCommandExecutor();

                if (method_exists($executor, 'run')) {
                    $commandResult = $executor->run($message, $userId);
                } else {
                    Yii::warning('AiCommandExecutor::run() not found', 'ai');
                }

            } catch (\Throwable $e) {
                Yii::error([
                    'message' => 'Command executor failed',
                    'error' => $e->getMessage()
                ], 'ai-command');
            }

            // считаем командой только валидный НЕ пустой результат
            if (!empty($commandResult) && $commandResult !== false) {
                return ['reply' => $commandResult];
            }

            // =========================
            // 2. AI FALLBACK
            // =========================
            $ai = Yii::$app->aiAssistant;

            $reply = $ai->handle($userId, $chatId, $message);

            return ['reply' => $reply];

        } catch (\Throwable $e) {

            Yii::error([
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 'ai');

            return [
                'error' => 'server error'
            ];
        }
    }

    /* =========================
       MESSAGES HISTORY
    ========================= */
    public function actionMessages()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $chatId = Yii::$app->request->get('chat_id');

        if (!$chatId) {
            return [];
        }

        $messages = \app\models\AiMessage::find()
            ->where([
                'user_id' => Yii::$app->user->id ?? 1,
                'chat_id' => $chatId,
            ])
            ->orderBy(['id' => SORT_ASC])
            ->all();

        return array_map(function ($m) {
            return [
                'role' => $m->role,
                'message' => $m->message,
            ];
        }, $messages);
    }

    /* =========================
       CREATE CHAT
    ========================= */
    public function actionCreateChat()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $title = Yii::$app->request->post('title');

        if (!$title) {
            return ['success' => false, 'error' => 'no title'];
        }

        $chat = new \app\models\AiChat();
        $chat->user_id = Yii::$app->user->id ?? 1;
        $chat->title = $title;
        $chat->created_at = date('Y-m-d H:i:s');

        if ($chat->save()) {
            return [
                'success' => true,
                'id' => $chat->id,
                'title' => $chat->title,
            ];
        }

        return [
            'success' => false,
            'error' => $chat->errors,
        ];
    }
    public function actionChats()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $chats = \app\models\AiChat::find()
            ->where(['user_id' => Yii::$app->user->id ?? 1])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return array_map(function ($c) {
            return [
                'id' => $c->id,
                'title' => $c->title,
            ];
        }, $chats);
    }
    public function actionStream()
    {
        // Отключаем Yii response формат
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        // ВАЖНО: чистим буферы
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: text/plain; charset=utf-8');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no'); // важно для nginx
        header('Connection: keep-alive');

        $message = Yii::$app->request->get('message');
        $chatId = Yii::$app->request->get('chat_id', 'default');

        $ai = Yii::$app->aiAssistant;

        $reply = $ai->handle(
            Yii::$app->user->id ?? 1,
            $chatId,
            $message
        );

        // симуляция streaming
        $words = explode(' ', $reply);

        foreach ($words as $word) {

            echo $word . ' ';

            @ob_flush();
            @flush();

            usleep(50000); // эффект "печатает"
        }

        exit; // ВАЖНО
    }
}