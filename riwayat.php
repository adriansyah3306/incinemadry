<?php
include 'koneksi.php';  // Connection to the database
include 'bagan/header.php';  // Include the header file

// Fetching data from the transactions table
$sql = "SELECT * FROM transactions WHERE username";
$sql = "SELECT * FROM transactions ORDER BY id ASC"; // You can modify this query based on specific filters like user or status
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
  /* Warna Retro */
:root {
  --retro-orange: #e07a5f;
  --retro-yellow: #f4a261;
  --retro-brown: #8d5524;
  --retro-green: #4a7c59;
  --retro-blue: #3d405b;
  --retro-bg: #f2cc8f;
}

/* Reset Dasar */
body {
  margin: 0;
  background-color: var(--retro-bg);
  font-family: "Courier New", Courier, monospace;
  color: var(--retro-brown);
}

/* Container Utama */
.main-container {
  width: 100%;
  position: relative;
}

/* HEADER */
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  background-color: var(--retro-blue);
  color: var(--retro-yellow);
  border-bottom: 4px solid var(--retro-brown);
}

/* Logo */
.logo img {
  height: 75px;
}

/* Navigasi */
nav ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
}

nav ul li {
  margin: 0 15px;
}

nav ul li a {
  text-decoration: none;
  color: var(--retro-yellow);
  font-size: 16px;
  font-weight: bold;
  text-transform: uppercase;
  transition: color 0.3s ease;
}

nav ul li a:hover {
  color: var(--retro-orange);
}

/* Dropdown */
nav ul li.dropdown {
  position: relative;
}

nav ul li.dropdown .dropdown-content {
  display: none;
  position: absolute;
  background-color: var(--retro-brown);
  min-width: 160px;
  z-index: 1000;
  max-height: 300px;
  overflow-y: auto;
  padding: 0;
}

nav ul li.dropdown:hover .dropdown-content {
  display: block;
}

nav ul li.dropdown .dropdown-content a {
  color: white;
  padding: 10px;
  text-decoration: none;
  display: block;
}

nav ul li.dropdown .dropdown-content a:hover {
  color: var(--retro-orange);
}

/* Search & Login */
.search-login {
  display: flex;
  align-items: center;
  padding-inline: 5px;
}

.search-login input {
  padding: 5px;
  margin-right: 10px;
  border-radius: 5px;
  border: 2px solid var(--retro-brown);
  font-size: 18px;
  background-color: var(--retro-yellow);
}

.search-login nav ul li .login-btn {
  background-color: var(--retro-orange);
  color: white;
  border: 3px solid var(--retro-brown);
  border-radius: 5px;
  cursor: pointer;
  font-size: 18px;
  padding: 5px 10px;
  box-shadow: 3px 3px var(--retro-brown);
}

.search-login nav ul li .login-btn:hover {
  background-color: var(--retro-yellow);
  color: var(--retro-brown);
}

/* SLIDER */
.slider-container {
  width: 100%;
  overflow: hidden;
  background-color: var(--retro-yellow);
}

.slider {
  display: flex;
  transition: transform 0.5s ease-in-out;
}

.slide {
  min-width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.slide img {
  width: 100%;
  max-height: 700px;
  object-fit: cover;
  filter: sepia(20%) contrast(1.1);
}

/* FILM BUTTON */
.film-selection {
  text-align: center;
  margin-top: 20px;
}

.film-btn {
  padding: 12px 24px;
  background-color: var(--retro-orange);
  color: white;
  border: 3px solid var(--retro-brown);
  font-size: 16px;
  font-weight: bold;
  text-transform: uppercase;
  cursor: pointer;
  box-shadow: 4px 4px var(--retro-brown);
  transition: all 0.2s ease;
}

.film-btn:hover {
  background-color: var(--retro-yellow);
  color: var(--retro-brown);
  transform: translateY(-2px);
}

/* POSTER */
/* Container Poster */
.poster-container {
  display: flex;
  justify-content: center; /* Membuat poster berada di tengah */
  flex-wrap: wrap; /* Agar tetap rapi di layar kecil */
  gap: 15px;
  padding: 20px;
}

/* Poster */
.poster {
  position: relative;
  width: 200px;
  height: 300px;
  overflow: hidden;
  border: 5px solid var(--retro-brown);
  box-shadow: 6px 6px var(--retro-orange);
  transition: transform 0.2s ease-in-out;
}

/* Gambar Poster */
.poster img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  aspect-ratio: 2/3; /* Supaya proporsinya tetap */
  border-radius: 10px;
  filter: sepia(20%) contrast(1.1);
}

/* Efek Hover pada Poster */
.poster:hover {
  transform: scale(1.05);
  box-shadow: 8px 8px var(--retro-green);
}

/* Tombol di Poster */
.film-button {
  padding: 10px 20px;
  background-color: var(--retro-green);
  color: white;
  border: 3px solid var(--retro-brown);
  font-size: 14px;
  font-weight: bold;
  text-transform: uppercase;
  position: absolute;
  bottom: 10px;
  left: 50%;
  transform: translateX(-50%);
  display: none;
}

.poster:hover .film-button {
  display: block;
}

/* Responsif untuk layar kecil */
@media (max-width: 600px) {
  .poster-container {
    justify-content: center; /* Supaya tetap di tengah pada layar kecil */
  }

  .poster {
    width: 150px;
    height: 225px;
  }
}

/* TABEL */
.table-container {
  width: 80%;
  margin: 20px auto;
  padding: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
  background-color: var(--retro-yellow);
  font-family: "Courier New", Courier, monospace;
}

table th {
  background-color: var(--retro-orange);
  color: white;
  border: 3px solid var(--retro-brown);
}

table td {
  border: 2px solid var(--retro-brown);
  padding: 10px;
}

table tr:nth-child(even) {
  background-color: var(--retro-bg);
}

/* FOOTER */
/* FOOTER */
footer {
  background: var(--retro-blue);
  color: #FDF3E7; /* Warna krem untuk kontras lebih nyaman */
  text-align: center;
  padding: 30px 10px;
  font-weight: bold;
  text-transform: uppercase;
  box-shadow: 0px -4px 10px rgba(0, 0, 0, 0.3);
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* Kontainer Footer */
.footer-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
  max-width: 900px;
  width: 100%;
}

/* Bagian Sosial Media */
.socials {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 15px;
}

.socials a {
  color: #FFD166; /* Warna kuning retro */
  font-size: 24px;
  transition: transform 0.3s ease-in-out, color 0.3s;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Efek bayangan retro */
}

.socials a:hover {
  transform: scale(1.2);
  color: #E07A5F; /* Warna jingga retro */
}

/* Link Navigasi Footer */
.links {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 15px;
}

.links a {
  color: #FFD166; /* Warna kuning agar kontras */
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}

.links a:hover {
  color: #E07A5F; /* Warna jingga untuk hover */
}

/* Credit */
.credit p {
  font-size: 14px;
}

.credit a {
  color: #E07A5F; /* Warna jingga */
  text-decoration: none;
  font-weight: bold;
}

.credit a:hover {
  text-decoration: underline;
  color: #FFD166; /* Warna kuning saat hover */
}

/* RESPONSIF UNTUK LAYAR KECIL */
@media (max-width: 600px) {
  .links {
    flex-direction: column;
    text-align: center;
  }
  
  .footer-container {
    gap: 10px;
  }
  
  .logo img {
    height: 50px;
  }
}


    .table-container {
        width: 80%;
        margin: 0 auto;
        padding: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0 auto;
        background-color: #f9f9f9;
    }

    table th,
    table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    table th:first-child,
    table td:first-child {
        width: 5%;
    }

    table th:nth-child(2),
    table td:first-child {
        width: 10%;
    }

    table th {
        background-color: #916648;
        color: black;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Add path to your bootstrap CSS if necessary -->
</head>

<body>
    <div class="main-container">

        <center>
            <h2>History Transaksi</h2>
        </center>

        <div class="table-container">
            <table id="transactionTable" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Username</th>
                        <th>Nama Film</th>
                        <th>Nomer Kursi</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Jenis Pembayaran</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <?php
                $no = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='hover:bg-gray-100 text-center'>
                                <td class='px-4 py-2 border'>{$no}</td>
                                <td class='px-4 py-2 border'>{$row['order_id']}</td>
                                <td class='px-4 py-2 border'>{$row['username']}</td>
                                <td class='px-4 py-2 border'>{$row['nama_film']}</td>
                                <td class='px-4 py-2 border'>{$row['seat_number']}</td>
                                <td class='px-4 py-2 border'>{$row['transaction_time']}</td>
                                <td class='px-4 py-2 border'>{$row['payment_type']}</td>
                                <td class='px-4 py-2 border'>Rp.{$row['amount']}</td>
                                <td class='px-4 py-2 border'>";

                        // Status dengan warna berbeda
                        if ($row['status'] == 'settlement') {
                            echo "<span class='bg-green-500 text-white px-3 py-1 rounded-lg'>Selesai</span>";
                        } elseif ($row['status'] == 'pending') {
                            echo "<span class='bg-yellow-500 text-white px-3 py-1 rounded-lg'>Menunggu</span>";
                        } else {
                            echo "<span class='bg-red-500 text-white px-3 py-1 rounded-lg'>{$row['status']}</span>";
                        }

                        echo "</td></tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center py-4 text-gray-500'>Tidak ada data</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <?php include 'bagan/footer.php' ?>

    </div>
</body>

</html>