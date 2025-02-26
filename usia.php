<?php
include 'koneksi.php';

$usia = isset($_GET['usia']) ? $_GET['usia'] : '';

if (!empty($usia)) {
    $sql = "SELECT * FROM film WHERE usia = '$usia' ORDER BY id ASC";
} else {
    $sql = "SELECT * FROM film ORDER BY id ASC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo_incinema.png">
    <title>Usia - INCINEMADRY</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Container utama untuk header dan slider -->
    <div class="main-container">
        <!-- Header -->
        <?php include 'bagan/header.php' ?>

        <!-- Foto Poster Film di bawah Slider -->
        <br>
        <center>
            <h1>
                <?php
                // Change the text dynamically based on 'usia' parameter
                if (!empty($usia)) {
                    echo "Usia " . htmlspecialchars($usia); // Display 'Usia 13+', 'Usia 18+', etc.
                } else {
                    echo "Tidak ada Film"; // Default message when no 'usia' filter is applied
                }
                ?>
            </h1>
        </center>
        <div class="poster-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="poster">
                    <img src="<?php echo $row['poster']; ?>" alt="Poster Film 1">
                    <a href="lihat_film.php?id=<?php echo $row['id']; ?>" class="film-button">Lihat Film</a>
                </div>
            <?php endwhile ?>
        </div>

    </div>
    <!-- Footer Section -->
    <?php include 'bagan/footer.php' ?>

    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/button.js"></script>
</body>

</html>