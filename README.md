# feedback-form

## Описание проекта
Простая контактная форма с валидацией, сохранением данных в базу MySQL и отправкой результатов на e-mail.

## Требования
- PHP 7.4 или выше
- MySQL
- Веб-сервер Apache или Nginx

## Установка
1. Настройте базу данных MySQL, используя файл `db_create.sql`.
2. Настройте подключение к базе данных в файле `dbconn.php`.
3. Разместите проект на веб-сервере.
4. Форма готова к использованию.

## Файлы
- `index.php`: Форма обратной связи
- `script.js`: Валидация формы на стороне клиента
- `dbconn.php`: Подключение к базе данных
- `submit.php`: Обработка данных формы и отправка на e-mail
- `check_email.php`: Проверка наличия e-mail в базе
- `db_create.sql`: SQL для создания базы данных и таблицы
