<?php

function loadEnvironmentVariables()
{
    if (file_exists('.env')) {
        $envFile = parse_ini_file('.env');

        foreach ($envFile as $key => $value) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

function getConnection()
{
    $host = $_ENV['HOST'];
    $port = $_ENV['PORT'];
    $dbname = $_ENV['DBNAME'];
    $user = $_ENV['USER'];
    $password = $_ENV['PASSWORD'];

    if (!$host || !$port || !$dbname || !$user || !$password) {
        die('Konfigurasi database tidak lengkap di environment variable.');
    }

    $conStr = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

    try {
        // Create PDO connection
        return new PDO($conStr, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $e) {
        die('Koneksi database gagal: ' . $e->getMessage());
    }
}
