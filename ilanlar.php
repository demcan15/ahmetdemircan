<?php
$host = "localhost";
$dbname = "user";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM ilanlar WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL hazırlama hatası: " . $conn->error);
}

$like = '%' . $search . '%';
$stmt->bind_param("s", $like);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Araba İlanları</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            padding-top: 40px;
        }

        .container {
            background: #fff;
            width: 90%;
            max-width: 800px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            padding: 30px 40px;
        }

        h2 {
            text-align: center;
            color: #34495e;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        input[type="text"] {
            flex: 1;
            padding: 12px 18px;
            font-size: 1rem;
            border: 2px solid black;
            border-right: none;
            border-radius: 8px 0 0 8px;
            outline: none;
        }

        button {
            padding: 12px 25px;
            font-size: 1rem;
            background-color: yellow;
            color: black;
            border: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
            font-weight: 600;
        }

        button:hover {
            background-color: red;
        }

        .ilan {
            background-color: #ecf0f1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .ilan img {
            width: 120px;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }

        .ilan-details {
            display: flex;
            flex-direction: column;
        }

        .ilan-details span {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .ilan-details span strong {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Araba İlanları</h2>
        <form method="get" action="ilanlar.php">
            <input type="text" name="search" placeholder="İlan adı ara..." value="<?php echo htmlspecialchars($search); ?>" spellcheck="false" />
            <button type="submit">Ara</button>
        </form>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="ilan">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Resim yok" />
                    <div class="ilan-details">
                        <span><strong>Ad:</strong> <?php echo htmlspecialchars($row['name']); ?></span>
                        <span><strong>Model:</strong> <?php echo htmlspecialchars($row['model']); ?></span>
                        <span><strong>Renk:</strong> <?php echo htmlspecialchars($row['color']); ?></span>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aradığınız kriterlere uygun ilan bulunamadı.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>


