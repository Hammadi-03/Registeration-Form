<?php
// ===== MENGAKSES DATA FORM =====

// Untuk method POST:
$nama = $_POST['nama'];
$email = $_POST['email'];

// Untuk method GET:
$keyword = $_GET['keyword'];

// ===== CEK APAKAH FORM SUDAH DISUBMIT =====
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kode ini hanya jalan jika form disubmit
    echo "Form sudah disubmit!";
}

// ===== MENGAKSES BERBAGAI JENIS INPUT =====

// Text, Email, Password - langsung akses
$nama = $_POST['nama'];

// Select (dropdown)
$kelas = $_POST['kelas'];  // Nilai dari option yang dipilih

// Radio button
$jenis_kelamin = $_POST['jenis_kelamin'];  // "L" atau "P"

// Checkbox (bisa banyak) - hasilnya array
$hobi = $_POST['hobi'];  // ["Membaca", "Coding"]
foreach ($hobi as $h) {
    echo "Hobi: $h <br>";
}

// ===== MENAMPILKAN DENGAN AMAN =====
// Gunakan htmlspecialchars untuk mencegah XSS
$nama_aman = htmlspecialchars($_POST['nama']);
echo "Halo, $nama_aman!";




?>