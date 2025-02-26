<?php
// Menyertakan autoloader Composer
require '../vendor/autoload.php'; // Pastikan pathnya sesuai dengan struktur project Anda
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
// Inisialisasi variabel untuk menyimpan input
$name = '';
$email = '';
$password = '';
if (isset($_POST['send_otp'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Simpan password di session
    $_SESSION['password'] = $password;
    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    $_SESSION['otp_sent_time'] = time(); // Store the time OTP was sent
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'muhammadadriansyah390@gmail.com';
        $mail->Password = 'reuk xblp wxic ffjr'; // Gunakan App Password jika 2FA aktif
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Untuk port 465
        $mail->Port = 465; // Port untuk SSL

        $mail->setFrom('muhammadadriansyah390@gmail.com', 'incinemadry');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'OTP Verifikasi Akun';
        $mail->Body = "Hai $name, <br> Berikut adalah kode OTP Anda:
<b>$otp</b>.<br>Kode ini berlaku selama 15 menit.";

        $mail->send();
        $otp_sent = true; // Set flag untuk menampilkan SweetAlert
    } catch (Exception $e) {
        echo "Gagal mengirim email: {$mail->ErrorInfo}";
    }
}
if (isset($_POST['verify_otp'])) {
    $otp_input = $_POST['otp'];
    // Check if OTP is valid and not expired (15 minutes)
    if ($otp_input == $_SESSION['otp'] && (time() - $_SESSION['otp_sent_time'] <
        900)) {
        // OTP valid, simpan data pengguna ke database
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT); //Hash password
        // Koneksi ke database dan insert data pengguna
        $conn = new mysqli("localhost", "root", "", "db_adi");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Use prepared statement
        $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES
(?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $registration_success = true; // Set flag untuk menampilkan SweetAlert
            // Hapus session setelah verifikasi
            unset($_SESSION['otp']);
            unset($_SESSION['otp_sent_time']);
            unset($_SESSION['password']); // Hapus password dari session
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
    <title>Akun Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <aside class="w-64 bg-blue-900 text-white p-6 h-screen" style="background-color: #281E15;"w-64 bg-purple-900 text-white p-5">
            <h1 class="text-2xl font-bold mb-6">Admin INCINEMADRY</h1>
            <nav>
                <ul>
                    <li class="mb-4 border-b border-gray-400 pb-2">
                        <a href="dashboard.php" class="hover:text-gray-300">
                            <i class="fas fa-home mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="akun_admin.php" class="hover:text-gray-300">
                            <i class="fas fa-user mr-2"></i> Akun Admin
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="akun_mall.php" class="hover:text-gray-300">
                            <i class="fas fa-store mr-2"></i> Akun Mall
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="jadwal_film.php" class="hover:text-gray-300">
                            <i class="fas fa-calendar-alt mr-2"></i> Jadwal Film
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="data_film.php" class="flex items-center gap-2 hover:text-gray-300">
                            <i class="fas fa-film"></i> Data Film
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="history_pembelian.php" class="hover:text-gray-300">
                            <i class="fas fa-history mr-2"></i> History Pembelian
                        </a>
                    </li>
                    <li class="mb-4 mt-6 border-t border-gray-400 pt-2">
                        <a href="index.php" class="hover:text-gray-300">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="flex-1 p-6">
            <header class="bg-white p-4 rounded shadow mb-6 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Akun Admin</h2>
                <button onclick="openModal()" class="bg-purple-800 text-white px-4 py-2 rounded">Tambah Akun</button>
            </header>

            <section class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Daftar Akun Admin</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200" style="background-color:rgb(147, 117, 182);">
                            <th class="border border-gray-300 px-2 py-1">No</th>
                            <th class="border border-gray-300 px-4 py-2">Email</th>
                            <th class="border border-gray-300 px-4 py-2">Nama</th>
                            <th class="border border-gray-300 px-4 py-2">Password</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        <?php
                        // Koneksi ke database
                        include '../koneksi.php';

                        // Query untuk mengambil data admin
                        $sql = "SELECT id, name, email, password FROM admin";
                        $result = $conn->query($sql);
                        $no = 1; // Nomor urut

                        // Tampilkan data jika ada hasil
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                        <td class='border border-gray-300 px-2 py-1 text-center'>{$no}</td>
                        <td class='border border-gray-300 px-4 py-2'>{$row['email']}</td>
                        <td class='border border-gray-300 px-4 py-2'>{$row['name']}</td>
                        <td class='border border-gray-300 px-4 py-2'>********</td>
                      </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='4' class='border border-gray-300 px-4 py-2 text-center'>Tidak ada data</td></tr>";
                        }

                        // Tutup koneksi
                        $conn->close();
                        ?>
                    </tbody>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <h3 class="text-lg font-semibold mb-4 ">Tambah Akun Admin</h3>
            <form method="POST" action="akun_admin.php">
                <div class="mb-3">
                    <input type="text" name="name" placeholder="Name" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded" required>
                </div>
                <button type="submit" name="send_otp" class="bg-red-600 text-white px-4 py-2 rounded w-full">Kirim OTP</button>
            </form>
            <br>
            <?php if (isset($_SESSION['otp'])): ?>
                <form method="POST" action="akun_admin.php">
                    <div class="mb-3">
                        <input type="text" name="otp" placeholder="Masukan OTP" class="w-full p-2 border rounded" required>
                    </div>
                    <button type="submit" name="verify_otp" class="bg-green-600 text-white px-4 py-2 rounded w-full">Verifikasi OTP</button>
                </form>
            <?php endif; ?>
            <button onclick="closeModal()" class="mt-3 bg-purple-600 text-white px-4 py-2 rounded w-full">Tutup</button>
        </div>
    </div>
    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            resetModalFields();
        }

        function resetModalFields() {
            document.querySelector('#modal form').reset(); // Reset semua input di dalam modal
        }

        // SweetAlert untuk OTP terkirim
        <?php if (isset($otp_sent) && $otp_sent): ?>
            Swal.fire({
                title: 'OTP Terkirim!',
                text: 'Kode OTP telah dikirim ke email Anda.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    openModal(); // Tampilkan modal setelah OK diklik
                }
            });
        <?php endif; ?>

        // SweetAlert untuk OTP berhasil diverifikasi
        <?php if (isset($registration_success) && $registration_success): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Akun admin telah berhasil ditambahkan.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'akun_admin.php'; // Redirect ke menu admin
                }
            });
        <?php endif; ?>
    </script>
</body>

</html>