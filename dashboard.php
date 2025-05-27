<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listing Managment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            color: #1e293b;
        }

        form {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background-color: #f8fafc;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #94a3b8;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            background-color: yellow;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2563eb;
        }

        .form-section {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <div class="form-section">
            <h3>Add Advert</h3>
            <form action="add_listing.php" method="post" enctype="multipart/form-data">
                <label>Header:</label>
                <input type="text" name="title" required>

                <label>Explanation:</label>
                <textarea name="description" required></textarea>

                <label>İmage:</label>
                <input type="file" name="image" accept="image/*" required>

                <button type="submit">Add Advert</button>
            </form>
        </div>

        <div class="form-section">
            <h3>Adverts</h3>
            <form action="listings.php" method="get">
                <button type="submit">Show Advert</button>
            </form>
        </div>

        <div class="form-section">
            <h3>Update Advert</h3>
            <form action="update_listing.php" method="post">
                <label>Advert ID:</label>
                <input type="number" name="id" required>

                <label>New header:</label>
                <input type="text" name="new_title">

                <label>New Explanation:</label>
                <textarea name="new_description"></textarea>

                <button type="submit">Update</button>
            </form>
        </div>

        <div class="form-section">
            <h3>Delete Advert</h3>
            <form action="delete_listing.php" method="post">
    <input type="text" name="id" placeholder="ID required" required>
    <button type="submit">Delete Advert</button>
             </form>
        </div>
    </div>
</body>
</html>
