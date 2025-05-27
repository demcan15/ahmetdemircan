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
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

$sql = "SELECT * FROM listings ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>İlan Listesi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            padding: 20px;
        }

        .listing {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .listing img {
            max-width: 250px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
        }

        .description {
            margin-top: 10px;
            color: #555;
        }

        .id {
            font-size: 14px;
            color: #888;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>

<h2>All advertisment</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='listing'>";
        echo "<div class='id'>ID: " . htmlspecialchars($row['id']) . "</div>";
        echo "<div class='title'>" . htmlspecialchars($row['title']) . "</div>";
        echo "<div class='description'>" . nl2br(htmlspecialchars($row['description'])) . "</div>";
        if (!empty($row['image_path'])) {
            echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Resim'>";
        }
        echo "</div>";
    }
} else {
    echo "<p>there is no advertisment yet.</p>";
}

$conn->close();
?>

</body>
</html>

