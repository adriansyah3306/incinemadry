<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Logo1.jpg">
    <title>Teater - INCINEMADRY</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .bg-white {
    background-color: white !important;
}

    </style>
</head>

<!-- Header -->
<?php include 'bagan/header.php' ?>

<body>
    <!-- Container utama untuk header dan slider -->
    <div class="main-container">

        <center>
            <h1>Daftar Mall</h1>
        </center>
        <div class="table-container">
        <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-blue-800 text-white" style="background-color: white;">
                            <th class="border p-2">No</th>
                            <th class="border p-5">Nama Mall</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    // Koneksi ke database
    include 'koneksi.php';

    // Query untuk mengambil data film
    $sql = "SELECT * FROM akun_mall";
    $result = $conn->query($sql);
    $no = 1; // Nomor urut
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Tambahkan class bg-white untuk baris pertama
            $bgClass = ($no == 1) ? 'bg-white' : '';
            echo "<tr class='{$bgClass}'>
                    <td class='border border-gray-300 px-2 py-1 text-center'>{$no}</td>
                    <td class='border border-gray-300 px-4 py-2'>{$row['nama_mall']}</td>
                  </tr>";
            $no++;
        }
    } else {
        echo "<tr><td colspan='13' class='border border-gray-300 px-4 py-2 text-center'>Tidak ada data</td></tr>";
    }

    // Tutup koneksi
    $conn->close();
    ?>
</tbody>

                </table>
        </div>

        <!-- Footer Section -->
        <?php include 'bagan/footer.php' ?>

    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/button.js"></script>
</body>

</html>