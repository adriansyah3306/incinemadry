<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo_incinema.png">
    <title>InCinemadry</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

</head>

<body>
    <!-- Container utama untuk header dan slider -->
    <div class="main-container">
        <!-- Header -->
        <?php include 'bagan/header.php' ?>

        <!-- Slider Iklan -->
        <div class="slider-container">
            <div class="slider">
                <div class="slide">
                    <img src="assets/img/iklan/p1.jpg" alt="Iklan 1">
                </div>
                <div class="slide">
                    <img src="assets/img/iklan/p2.jpg" alt="Iklan 2">
                </div>
                <div class="slide">
                    <img src="assets/img/iklan/p3.jpeg" alt="Iklan 3">
                </div>
            </div>
        </div>

        <!-- Foto Poster Film di bawah Slider -->
        <br>
        <center>
            <h1>Sedang Tayang</h1>
        </center>
        <?php
        include 'koneksi.php'; // Menghubungkan ke database

        // Query untuk mengambil film yang akan tayang dalam waktu dekat
        $sql = "SELECT * FROM film ORDER BY id ASC";
        $result = $conn->query($sql);

        // Memulai output HTML
        ?>
        <div class="poster-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="poster">
                    <h3><?php echo $row['nama_film']; ?></h3>
                    <img src="<?php echo $row['poster']; ?>" alt="Poster Film 1">
                    <a href="lihat_film.php?id=<?php echo $row['id']?>"class="film-button">Lihat Film</a>
                </div>
            <?php endwhile ?>
        </div>
    </div>
    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <div class="socials">
                <a href="#"><i data-feather="instagram"></i></a>
                <a href="#"><i data-feather="twitter"></i></a>
                <a href="#"><i data-feather="facebook"></i></a>
            </div>

            <div class="links">
                <a href="index.php">Home</a>
                <a href="theater.php">Theater</a>
                <a href="UpComing.php">UpComing</a>
                <a href="#contact">Kontak</a>
            </div>

            <div class="credit">
                <p>Created by <a href="#">Muhammad Adriansyah</a> | &copy; 2025.</p>
            </div>
        </div>
    </footer>


    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/button.js"></script>
</body>

</html>