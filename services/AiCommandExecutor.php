<?php namespace app\services\ai;

use app\models\Transport;
use app\models\Warehouse;
use app\models\Routes;

class AiCommandExecutor
{
public function run(string $message, int $userId): ?string
{
$text = mb_strtolower($message);

// --- CREATE TRANSPORT ---
if (str_contains($text, 'создай перевозку')) {

$t = new Transport();
$t->title = 'Создано ИИ';
$t->status = 'pending';
$t->user_id = $userId;
$t->from_address = 'AI';
$t->to_address = 'AI';
$t->save();

return "✔ Перевозка создана";
}

// --- LIST WAREHOUSES ---
if (str_contains($text, 'склады')) {

$count = Warehouse::find()
->where(['user_id' => $userId])
->count();

return "📦 У вас складов: {$count}";
}

// --- LIST ROUTES ---
if (str_contains($text, 'маршруты')) {

$count = Routes::find()
->where(['user_id' => $userId])
->count();

return "🗺 Маршрутов: {$count}";
}

return null;
}
}