<?php
$pesan = "";

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $kelas = $_POST['kelas'];
    $jk = $_POST['jenis_kelamin'];
    
    // Buat pesan sukses (multi-language)
    $currentLang = isset($_POST['lang']) ? $_POST['lang'] : 'id';
    $display_jk = $jk;
    if ($currentLang === 'en') {
        if ($jk === 'Laki-laki') $display_jk = 'Male';
        elseif ($jk === 'Perempuan') $display_jk = 'Female';
        $pesan = "
            <div class='sukses'>
                <h3>✅ Registration Successful!</h3>
                <p><strong>Name:</strong> $nama</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Class:</strong> $kelas</p>
                <p><strong>Gender:</strong> $display_jk</p>
            </div>
        ";
    } else {
        $pesan = "
            <div class='sukses'>
                <h3>✅ Pendaftaran Berhasil!</h3>
                <p><strong>Nama:</strong> $nama</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Kelas:</strong> $kelas</p>
                <p><strong>Jenis Kelamin:</strong> $display_jk</p>
            </div>
        ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pendaftaran Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-left">
                <div class="logo" aria-hidden="true">
                    <img src="assets/logoddd.png" alt="Boarding School" class="logo-image">
                </div>
                <div>
                    <h1 class="title" data-i18n="title">Buat Akun</h1>
                    <p class="subtitle" data-i18n="subtitle">Daftar untuk mengakses layanan</p>
                </div>
            </div>
            <div class="header-right">
                <div class="lang-switch" role="tablist" aria-label="Language selector">
                    <button type="button" class="lang-btn active" data-lang="id" aria-pressed="true">ID</button>
                    <button type="button" class="lang-btn" data-lang="en" aria-pressed="false">EN</button>
                </div>
            </div>
        </header>
        <div class="header-accent" aria-hidden="true"></div>

        <!-- Tampilkan pesan sukses jika ada -->
        <?php echo $pesan; ?>
        
        
        <div>
            <button >Sign in</button>
        </div>
    </div>
    <script>window.initialLang = '<?php echo isset($currentLang)?htmlspecialchars($currentLang):'id'; ?>';</script>
    <script src="lang.js"></script>
</body>
</html>