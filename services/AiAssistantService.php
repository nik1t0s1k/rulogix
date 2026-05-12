<?php

namespace app\services;

use app\models\AiMessage;
use OpenAI;
use OpenAI\Client;
use Yii;
use yii\base\Component;

class AiAssistantService extends Component
{

    private Client $client;
    private string $model = 'deepseek/deepseek-chat';
    public function init()
    {

        parent::init();

        $apiKey = Yii::$app->params['openaiKey'] ?? null;

        if (!$apiKey) {
            throw new \Exception('OpenRouter API key not found');
        }

        $this->client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withBaseUri('https://openrouter.ai/api/v1')
            ->make();
    }
    public function handle(int $userId, string $chatId, string $message): string
    {
        // Сохраняем сообщение пользователя
        $this->saveMessage($userId, $chatId, 'user', $message);

        // Получаем историю
        $history = $this->getHistory($userId, $chatId);

        // Формируем запрос
        $messages = $this->buildMessages($history, $message);

        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => $messages,
            ]);

            $reply = trim($response->choices[0]->message->content ?? '');

            if (empty($reply)) {
                $reply = 'Извини, я не смог сформулировать ответ.';
            }

            // Сохраняем ответ
            $this->saveMessage($userId, $chatId, 'assistant', $reply);

            return $reply;

        } catch (\Exception $e) {
            Yii::error('OpenAI Error: ' . $e->getMessage(), 'ai-assistant');
            return $e->getMessage();
        }
    }

    private function saveMessage(int $userId, string $chatId, string $role, string $content): void
    {
        $model = new AiMessage();
        $model->user_id = $userId;
        $model->chat_id = $chatId;
        $model->role = $role;
        $model->message = $content;
        $model->save(false);
    }

    private function getHistory(int $userId, string $chatId, int $limit = 15): array
    {
        return AiMessage::find()
            ->where(['user_id' => $userId, 'chat_id' => $chatId])
            ->orderBy(['id' => SORT_ASC])
            ->limit($limit)
            ->all();
    }

    private function buildMessages(array $history, string $newMessage): array
    {
        $messages = [
            [
                'role' => 'system',
                'content' => $this->getSystemPrompt()
            ]
        ];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg->role,
                'content' => $msg->message
            ];
        }

        // Добавляем текущее сообщение
        $messages[] = [
            'role' => 'user',
            'content' => $newMessage
        ];

        return $messages;
    }

    private function getSystemPrompt(): string
    {
        return "Ты — умный AI-диспетчер логистической платформы Rulogix.\n" .
            "Отвечай на русском языке, профессионально, но дружелюбно.\n" .
            "Помогай с перевозками, складами, маршрутами, планированием и анализом.\n" .
            "Если не хватает данных — уточняй. Будь кратким и по делу.";
    }
    public function stream(string $message): \Generator
    {
        $response = $this->client->chat()->createStreamed([
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ],
        ]);

        foreach ($response as $event) {
            $text = $event->choices[0]->delta->content ?? '';

            if ($text) {
                yield $text;
            }
        }
    }
}