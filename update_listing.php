<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Listing</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .message-box {
            background-color: white;
            padding: 30px 50px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <?php
        $host = "localhost";
        $dbname = "user";
        $user = "root";
        $pass = "";

        $conn = new mysqli($host, $user, $pass, $dbname);
        if ($conn->connect_error) {
            echo "<p class='error'>Connection failed: " . $conn->connect_error . "</p>";
            exit;
        }

        $id = $_POST['id'] ?? '';
        $new_title = $_POST['new_title'] ?? '';
        $new_description = $_POST['new_description'] ?? '';

        if (empty($id)) {
            echo "<p class='error'>Listing ID is required.</p>";
            exit;
        }

        $updates = [];
        $params = [];
        $types = '';

        if (!empty($new_title)) {
            $updates[] = "title = ?";
            $params[] = $new_title;
            $types .= 's';
        }

        if (!empty($new_description)) {
            $updates[] = "description = ?";
            $params[] = $new_description;
            $types .= 's';
        }

        if (count($updates) > 0) {
            $params[] = $id;
            $types .= 'i';
            $sql = "UPDATE listings SET " . implode(", ", $updates) . " WHERE id = ?";

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                echo "<p class='error'>Failed to prepare the query: " . $conn->error . "</p>";
                exit;
            }

            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                echo "<p class='success'>Update successful.</p>";
            } else {
                echo "<p class='error'>Update failed: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p class='error'>No information to update.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

