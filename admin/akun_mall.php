<?php
// Menyertakan autoloader Composer
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
// Inisialisasi variabel untuk menyimpan input
$name = '';
$email = '';
$password = '';

if (isset($_POST['send_otp'])) {
    $name = $_POST['name']; // Pastikan name digunakan
    $nik = $_POST['nik'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id = $_POST['id'];

    $_SESSION['password'] = $password;
    $_SESSION['nik'] = $nik;
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['id'] = $id;

    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_sent_time'] = time();

    // Kirim email OTP
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'muhammadadriansyah930@gmail.com';
        $mail->Password = 'ylut dtgg mfkd pbrw';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom('muhammadadriansyah930@gmail.com', 'incinemadry');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verifikasi Akun Mall';
        $mail->Body = "<br> Berikut adalah kode OTP Anda: <b>$otp</b>.<br>Kode ini berlaku selama 60 menit.";
        $mail->send();
        $otp_sent = true;
    } catch (Exception $e) {
        echo "Gagal mengirim email: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['verify_otp'])) {
    $otp_input = $_POST['otp'];
    if ($otp_input == $_SESSION['otp'] && (time() - $_SESSION['otp_sent_time'] < 900)) {
        $name = $_SESSION['name'];
        $nik = $_SESSION['nik'];
        $email = $_SESSION['email'];
        $id = $_SESSION['id'];
        $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);

        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "db_adi");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Perbaiki query untuk menyertakan nama_mall
        $stmt = $conn->prepare("UPDATE akun_mall SET nama_mall = ?, nik = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $nik, $email, $password, $id);

        if ($stmt->execute()) {
            $registration_success = true;
            unset($_SESSION['otp']);
            unset($_SESSION['otp_sent_time']);
            unset($_SESSION['password']);
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "OTP salah atau kadaluarsa.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Logo1.jpg">
    <title>Akun Mall - INCINEMADRY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white p-6 h-screen fixed left-0 top-0 flex-shrink-0 overflow-y-auto" style="background-color: #281E15;">
            <h1 class="text-2xl font-bold mb-6">Admin Studio G</h1>
            <nav>
                <ul>
                    <li class="mb-4 border-b border-gray-400 pb-2">
                        <a href="dashboard.php" class="hover:text-gray-300 flex items-center">
                            <i class="fas fa-home mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="akun_admin.php" class="hover:text-gray-300 flex items-center">
                            <i class="fas fa-user mr-2"></i> Akun Admin
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="akun_mall.php" class="hover:text-gray-300 flex items-center">
                            <i class="fas fa-store mr-2"></i> Akun Mall
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="jadwal_film.php" class="hover:text-gray-300 flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i> Jadwal Film
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="data_film.php" class="hover:text-gray-300 flex items-center">
                            <i class="fas fa-film mr-2"></i> Data Film
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="history_pembelian.php" class="hover:text-gray-300 flex items-center">
                            <i class="fas fa-history mr-2"></i> History Pembelian
                        </a>
                    </li>
                    <li class="mb-4 mt-6 border-t border-gray-400 pt-2">
                        <a href="index.php" class="hover:text-gray-300 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 ml-64">
            <header class="bg-white p-4 rounded shadow mb-6 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Akun Mall</h2>
            </header>

            <!-- Tabel Akun Mall -->
            <section class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Daftar Akun Mall</h3>
                <?php
                include '../koneksi.php';

                $query = "SELECT * FROM akun_mall";
                $result = mysqli_query($conn, $query);
                ?>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-[#ff0ebf] text-white" style="background-color: #916648;">
                            <th class="border border-gray-300 px-4 py-2">No</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Mall</th>
                            <th class="border border-gray-300 px-4 py-2">NIK</th>
                            <th class="border border-gray-300 px-4 py-2">Email</th>
                            <th class="border border-gray-300 px-4 py-2">Password</th>
                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2"><?= $no++ ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['nama_mall']) ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['nik']) ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['email']) ?></td>
                                    <td class="border border-gray-300 px-4 py-2">****</td>
                                    <td>
                                        <button class="btn btn-warning btn-edit"
                                            data-id="<?= $row['id'] ?>"
                                            data-nama="<?= htmlspecialchars($row['nama_mall']) ?>"
                                            data-nik="<?= htmlspecialchars($row['nik']) ?>"
                                            data-email="<?= htmlspecialchars($row['email']) ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalTambahJadwal">
                                            Edit
                                        </button>

                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <?php mysqli_close($conn); ?>

            </section>
        </main>

        <script>
            $('.btn-edit').click(function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var nik = $(this).data('nik');
                var email = $(this).data('email');

                $('#edit-id').val(id);
                $('#edit-nama').val(nama);
                $('#edit-nik').val(nik);
                $('#edit-email').val(email); // Mengisi input email dari data tombol edit
            });

            // Menampilkan SweetAlert setelah mengirim OTP
            <?php if (isset($otp_sent) && $otp_sent): ?>
                Swal.fire({
                    title: 'OTP Terkirim!',
                    text: 'Kode OTP telah dikirim ke email Anda.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var myModal = new
                        bootstrap.Modal(document.getElementById('modalTambahJadwal'));
                        myModal.show();
                    }
                });
            <?php endif; ?>
            // // Menampilkan SweetAlert setelah pendaftaran berhasil
            <?php if (isset($registration_success) && $registration_success): ?>
                Swal.fire({
                    title: 'Pendaftaran Berhasil!',
                    text: 'Anda telah berhasil Mengupdate.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Mengarahkan pengguna ke register.php setelah menekan OK
                    window.location.href = 'akun_mall.php'; // Ganti dengan path yang sesuai
                });
            <?php endif; ?>

            $('.btn-edit').click(function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var nik = $(this).data('nik');
                var email = $(this).data('email');
                $('#edit-id').val(id);
                $('#edit-nama').val(nama);
                $('#edit-nik').val(nik);
                $('#edit-email').val(email);
            });
        </script>

</body>

<div class="modal fade" id="modalTambahJadwal" tabindex="-1" arialabelledby="modalTambahJadwalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahJadwalLabel">Edit Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" arialabel="Close"></button>
            </div>
            <div class="modal-body">
                <form action="akun_mall.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Mall</label>
                        <input type="text" class="form-control" name="name" id="edit-nama"
                            value="<?php echo isset($_SESSION['nama_mall']) ? htmlspecialchars($_SESSION['nama_mall']) : ''; ?>" required>


                    </div>
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="id" id="edit-id"
                            value="<?php echo isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) :
                                        ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" id="edit-nik"
                            value="<?php echo isset($_SESSION['nik']) ? htmlspecialchars($_SESSION['nik'])
                                        : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" id="edit-email"
                            value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required>

                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password"
                            required>
                    </div>
                    <button type="submit" name="send_otp" class="btn btn-primary">Kirim
                        OTP</button>
                </form>
                <?php if (isset($_SESSION['otp'])): ?>
                    <form action="akun_mall.php" method="POST">
                        <div class="mb-3">
                            <label for="otp" class="form-label">Masukan OTP</label>
                            <input type="text" class="form-control" name="otp" required>
                        </div>
                        <button type="submit" name="verify_otp" class="btn btn-success">Verifikasi OTP</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</html>