<?php
session_start();
include 'koneksi/inc_koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $db_username, $hashed_password);
    $stmt->fetch();

    if ($hashed_password && password_verify($password, $hashed_password)) {
        // Login berhasil, atur sesi
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $db_username;

        // Redirect ke halaman dashboard
        header("Location: dashboard.php?page=dashboard_spk");
        exit;
    } else {
        $login_error = "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background: rgba(255, 255, 255, 0.8); /* Background putih transparan untuk konten */
            padding: 20px;
            border-radius: 8px;
            margin: 20px auto;
            max-width: 800px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($login_error)) : ?>
            <p style="color: red; text-align: center;"><?php echo $login_error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="login">Login</button>
            </div>
        </form>
        <p>Don't have an account? <a href="registrasi.php">Register here</a></p>
    </div>
</body>

</html>
