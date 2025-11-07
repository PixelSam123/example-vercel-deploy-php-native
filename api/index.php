<?php
require 'koneksi.php';

loadEnvironmentVariables();

$pdo = getConnection();

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (!empty($_POST['item'])) {
                    $stmt = $pdo->prepare("INSERT INTO todos (item, is_checked) VALUES (?, false)");
                    $stmt->execute([$_POST['item']]);
                }
                break;

            case 'toggle':
                if (isset($_POST['id'])) {
                    $stmt = $pdo->prepare("UPDATE todos SET is_checked = NOT is_checked WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                }
                break;

            case 'delete':
                if (isset($_POST['id'])) {
                    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                }
                break;
        }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Handle GET
$todos = $pdo->query("SELECT * FROM todos ORDER BY id ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List - Contoh Deployment Proyek PHP Native ke Vercel</title>
    <meta name="description" content="Contoh Deployment Proyek PHP Native ke Vercel">
</head>

<body>
    <h1>Todo List</h1>
    <p>Contoh Deployment Proyek PHP Native ke Vercel</p>

    <h2>Tambah Item</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <input type="text" name="item" placeholder="Masukkan todo baru" required>
        <button type="submit">Tambah</button>
    </form>

    <h2>Daftar Todo</h2>
    <?php if (empty($todos)): ?>
        <p>Belum ada todo. Tambahkan di atas</p>
    <?php else: ?>
        <ul>
            <?php foreach ($todos as $todo): ?>
                <li>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="toggle">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($todo['id']) ?>">
                        <button type="submit">
                            <?= $todo['is_checked'] ? '✅' : '⬜️' ?>
                        </button>
                    </form>

                    <span <?= $todo['is_checked'] ? 'style="text-decoration: line-through;"' : '' ?>>
                        <?= htmlspecialchars($todo['item']) ?>
                    </span>

                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($todo['id']) ?>">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>