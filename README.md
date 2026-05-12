Rulogix (Yii2 AI Logistics Platform)
🧠 О проекте

Rulogix — это логистическая платформа на Yii2 (PHP 8.2) с интегрированным AI-ассистентом, 
системой команд, чатом в реальном времени и модулями управления логистикой (маршруты, склады, пользователи).

Проект развивается как гибрид:

классическая CRUD ERP логика
AI-слой для автоматизации действий
чат-интерфейс управления системой
⚙️ Технологии
PHP 8.2
Yii2 Framework 
Bootstrap 5 
MySQL
AJAX + JSON API
AI Service Layer 
Streaming responses 
🧩 Основные модули
🤖 AI Assistant
Обработка сообщений пользователя
Контекстный чат по chat_id
Поддержка командной логики (CommandExecutor)
Fallback на AI-ответ при отсутствии команды

Endpoint:

POST /ai/send
⚡ Command System

Позволяет выполнять команды через чат.

Пример:

/create route
/update chat
/delete task

admin login: rulogAdmin
admin password: rulogAdmin
