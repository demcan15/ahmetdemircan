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
    die("Connection error:" . $conn->connect_error);
}

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$username = $_SESSION['username'];
$imagePath = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filename = basename($_FILES['image']['name']);
    $targetPath = $uploadDir . uniqid() . "_" . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        $imagePath = $targetPath;
    }
}

$sql = "INSERT INTO listings (user, title, description, image_path) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $title, $description, $imagePath);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: dashboard.php");
} else {
    echo "An error occurred while adding the ad.";
}

$conn->close();
?>
