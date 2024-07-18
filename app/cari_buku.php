<?php
session_start();
include 'koneksi/inc_koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Redirect ke halaman login jika belum login
    header("Location: login.php");
    exit;
}

$search_message = "";
$search_results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_book'])) {
    $search_term = $_POST['search_term'];

    // Query untuk mencari buku berdasarkan judul atau penulis
    $stmt = $conn->prepare("SELECT title, author, publisher, year FROM books WHERE title LIKE ? OR author LIKE ?");
    $like_search_term = '%' . $search_term . '%';
    $stmt->bind_param("ss", $like_search_term, $like_search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    } else {
        $search_message = "No books found.";
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
    <title>Cari Buku</title>
    <link rel="stylesheet" href="css/styles_tambah.css">
</head>

<body>
    <div class="header">
        <div class="user-info">
            <span>Welcome, <?php echo $_SESSION['username']; ?></span>
        </div>
        <h1>Cari Buku</h1>
    </div>
    <div class="container">
        <form action="cari_buku.php" method="POST">
            <div class="form-group">
                <label for="search_term">Cari Buku (judul atau penulis)</label>
                <input type="text" id="search_term" name="search_term" required>
            </div>
            <div class="form-group">
                <button type="submit" name="search_book">Cari Buku</button>
            </div>
        </form>
        <?php if (!empty($search_message)) : ?>
            <p style="color: red; text-align: center;"><?php echo $search_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($search_results)) : ?>
            <h2>Hasil Pencarian:</h2>
            <ul>
                <?php foreach ($search_results as $book) : ?>
                    <li>
                        <strong>Judul:</strong> <?php echo $book['title']; ?><br>
                        <strong>Penulis:</strong> <?php echo $book['author']; ?><br>
                        <strong>Penerbit:</strong> <?php echo $book['publisher']; ?><br>
                        <strong>Tahun:</strong> <?php echo $book['year']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <p><a href="dashboard.php">Kembali ke Halaman Utama</a></p>
    </div>
</body>

</html>
