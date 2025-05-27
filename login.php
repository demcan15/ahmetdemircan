<?php
session_start();

$host = "localhost";
$dbname = "user";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection error:" . $conn->connect_error);
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Failed to prepare query: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if ($password === $user['password']) {
        $_SESSION['username'] = $username;
        // Seçim ekranına yönlendir
        header("Location: choice.php");
        exit;
    } else {
        echo "<h2>Wrong password!</h2>";
    }
} else {
    echo "<h2>User not found</h2>";
}

$conn->close();
?>



