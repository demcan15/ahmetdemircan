<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sayfa Seçimi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            width: 350px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            background-color: yellow;
            color: black;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color:red ;
        }

        .username {
            font-weight: bold;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span></h2>
        <form action="dashboard.php" method="get">
            <button type="submit">Add Advert</button>
        </form>
        <form action="ilanlar.php" method="get">
            <button type="submit">Show Car Adverts</button>
        </form>
    </div>
</body>
</html>

