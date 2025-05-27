<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .warning {
            color: orange;
            font-weight: bold;
        }

        .info {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <?php
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $email = $_POST['email'] ?? '';
        $phoneCode = intval($_POST['phoneCode'] ?? 0);
        $phone = intval($_POST['phone'] ?? 0);

        if (!empty($username) && !empty($password) && !empty($gender) && !empty($email) && !empty($phoneCode) && !empty($phone)) {

            $host = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "user";

            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

            if ($conn->connect_error) {
                echo "<p class='error'>❌ Connection error: " . $conn->connect_error . "</p>";
                exit;
            }

            $SELECT = "SELECT email FROM users WHERE email = ? LIMIT 1";
            $stmt = $conn->prepare($SELECT);

            if ($stmt === false) {
                echo "<p class='error'>❌ Failed to prepare query (SELECT): " . $conn->error . "</p>";
                exit;
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                $stmt->close();

                $plain_password = $password;

                $INSERT = "INSERT INTO users (username, password, gender, email, phoneCode, phone) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($INSERT);

                if ($stmt === false) {
                    echo "<p class='error'>❌ Failed to prepare query (INSERT): " . $conn->error . "</p>";
                    exit;
                }

                $stmt->bind_param("ssssii", $username, $plain_password, $gender, $email, $phoneCode, $phone);

                if ($stmt->execute()) {
                    echo "<p class='success'>✅ New user added successfully.</p>";
                } else {
                    echo "<p class='error'>❌ An error occurred during registration: " . $stmt->error . "</p>";
                }

                $stmt->close();
            } else {
                echo "<p class='warning'>⚠️ This email address has already been registered.</p>";
                $stmt->close();
            }

            $conn->close();

        } else {
            echo "<p class='info'>❗ Please fill in all fields.</p>";
        }
        ?>
    </div>
</body>
</html>






