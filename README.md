# Google-Sheets-Sync-Service-Testing-task


Сервис на **Laravel 8+**, который синхронизирует данные из базы данных с Google Таблицей и обратно.  
Позволяет:
- Хранить записи в БД (модель `Record`) с полем `status` (`Allowed` / `Prohibited`).
- Автоматически выгружать только записи со статусом `Allowed` в Google Таблицу.
- Не затирать пользовательские комментарии (столбец G) при синхронизации.
- Синхронизировать изменения из таблицы обратно в БД.
- Выводить данные из Google Таблицы в консоль с прогресс-баром.
- Просматривать данные в браузере через `/fetch` и `/fetch/{count}`.
- Файл `storage/credentials.json` добавлен в проект, чтобы сервис можно было запустить сразу.


Установка и запуск:

1. Клонировать проект
```bash
git clone https://github.com/yourusername/laravel-google-sheet-sync.git
cd laravel-google-sheet-sync

2. Установка зависимостей
```bash
composer install
npm install && npm run dev

3.Настройка Google API
Для тестирования проект уже содержит сервисный аккаунт:
```bash
cp .env.example .env

4. Сгенерировать ключ приложения
```bash
php artisan key:generate

5. Запустить миграции и наполнить тестовыми данными
```bash
php artisan migrate
php artisan db:seed --class=RecordSeeder

 Использование(Основные команды)

Экспорт данных в Google Таблицу
```bash
php artisan sheet:export

Выгружает все записи со статусом Allowed.
Комментарии (колонка G) сохраняются.

 Синхронизация данных из Google Таблицы в БД
```bash
php artisan sync:google-sheet

Обновляет/создаёт записи в БД, удаляет невалидные.

 Вывод данных из Google Таблицы с прогресс-баром
```bash
php artisan sheet:fetch --count=10

Выводит ID, Title, Status и Comment для первых 10 строк.


