<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$dbname = "user";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$id = $_POST['id'] ?? '';

if (empty($id)) {
    die("Silinecek ilan ID'si eksik.");
}

$sql = "DELETE FROM listings WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$message = '';
if ($stmt->affected_rows > 0) {
    $message = "İlan silindi.";
} else {
    $message = "İlan bulunamadı veya silinemedi.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Silme Durumu</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .message-box {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .message-box h3 {
            color: #10b981;
            font-size: 24px;
            margin: 0;
        }

        .message-box.error h3 {
            color: #ef4444;
        }
    </style>
</head>
<body>
    <div class="message-box <?= ($message === 'İlan silindi.') ? '' : 'error' ?>">
        <h3><?= htmlspecialchars($message) ?></h3>
    </div>
</body>
</html>

