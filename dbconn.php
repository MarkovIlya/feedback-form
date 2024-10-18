<?php

$host = 'database';      // Хост базы данных
$db   = 'contact_form';    // Имя базы данных
$user = 'root';            // Пользователь MySQL
$pass = '';                // Пароль MySQL
$charset = 'utf8mb4';      // Кодировка

// Настройка DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Опции для подключения PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Отображение ошибок
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Режим получения данных
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Отключение эмуляции запросов
];

// Попытка подключения к базе данных
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Если подключение не удалось, выводим ошибку
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>
