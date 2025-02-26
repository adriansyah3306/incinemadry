<?php
include 'koneksi.php';

$tanggal_hari_ini = date('Y-m-d');

$sql = "SELECT f.id, f.nama_film, f.poster, f.usia, MIN(j.tanggal_tayang) AS 
 tanggal_tayang 
    FROM film f
    INNER JOIN jadwal_film j ON f.id = j.film_id
    WHERE j.tanggal_tayang > ?
    
    GROUP BY f.id, f.nama_film, f.poster, f.usia
    ORDER BY tanggal_tayang ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tanggal_hari_ini);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Logo1.jpg">
    <title>Up Coming - INCINEMADRY</title>
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
            <h1>Up Coming</h1>
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