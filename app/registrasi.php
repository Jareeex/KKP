<?php
session_start();
include 'koneksi/inc_koneksi.php';

$register_message = ""; // Pesan registrasi berhasil

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi data
    if ($password !== $confirm_password) {
        $register_message = "Passwords do not match";
    } else {
        // Cek apakah username sudah ada
        $check_stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $register_message = "Username already exists. Please try another username.";
        } else {
            // Hash password sebelum menyimpan ke database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data
            $insert_stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $username, $hashed_password);

            if ($insert_stmt->execute()) {
                // Registrasi berhasil
                $register_message = "Registration successful!";
            } else {
                $register_message = "There was an error. Please try again.";
            }

            $insert_stmt->close();
        }

        $check_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/styles_login.css">
    <style>
        body {
            background-image: url('img/SMP.jpg');
            background-color: white;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            color: #000;
            overflow: hidden;
        }

        .content {
            background: rgba(255, 255, 255, 0.8);
            /* Background putih transparan untuk konten */
            padding: 20px;
            border-radius: 8px;
            margin: 20px auto;
            max-width: 800px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Register</h2>
        <?php if (!empty($register_message)) : ?>
            <p style="color: green; text-align: center;"><?php echo $register_message; ?></p>
        <?php endif; ?>
        <form action="registrasi.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="register">Register</button>
            </div>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>