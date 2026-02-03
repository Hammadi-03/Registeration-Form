<?php
$pesan = "";

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = isset($_POST['nama']) ? trim(htmlspecialchars($_POST['nama'])) : '';
    $email = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
    $kelas = isset($_POST['kelas']) ? trim(htmlspecialchars($_POST['kelas'])) : '';
    $jk = isset($_POST['jenis_kelamin']) ? trim(htmlspecialchars($_POST['jenis_kelamin'])) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
    // After successful registration, redirect user to login page
    // preserve language choice (if provided)
    $currentLang = isset($_POST['lang']) ? $_POST['lang'] : 'id';

    // Basic server-side validation
    $errors = [];
    if(empty($nama)) $errors[] = 'Nama wajib diisi.';
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
    if(empty($password) || strlen($password) < 8) $errors[] = 'Password minimal 8 karakter.';
    if($password !== $password_confirm) $errors[] = 'Password dan konfirmasi tidak cocok.';

    // load existing users (users.json in project root)
    $usersFile = __DIR__ . DIRECTORY_SEPARATOR . 'users.json';
    $users = [];
    if(file_exists($usersFile)){
        $raw = file_get_contents($usersFile);
        $users = json_decode($raw, true) ?: [];
    }

    // check duplicate email
    foreach($users as $u){ if(isset($u['email']) && strtolower($u['email']) === strtolower($email)){ $errors[] = 'Email sudah terdaftar.'; break; } }

    if(empty($errors)){
        // hash the password and store user
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $users[] = [
            'nama' => $nama,
            'email' => $email,
            'kelas' => $kelas,
            'jenis_kelamin' => $jk,
            'password_hash' => $hash,
            'created_at' => date('c')
        ];
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE), LOCK_EX);

        header('Location: login.php?registered=1&lang=' . urlencode($currentLang));
        exit;
    } else {
        // prepare error HTML (already escaped above)
        $pesan = '<div class="alert error"><ul>';
        foreach($errors as $e) $pesan .= '<li>'.htmlspecialchars($e).'</li>';
        $pesan .= '</ul></div>';
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
                    <img src="assets/logo.png" alt="Boarding School" class="logo-image">
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

        <!-- Tampilkan pesan sukses jika ada -->
        <?php echo $pesan; ?>
        
        <form method="POST">
            <input type="hidden" name="lang" id="lang" value="<?php echo isset($_POST['lang'])?htmlspecialchars($_POST['lang']):'id'; ?>">
            <div class="form-grid">
                <div class="input-group">
                    <label class="input-label" for="nama" data-i18n="label_name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input class="input-field" type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" data-i18n-placeholder="ph_name" value="<?php echo isset($_POST['nama'])?htmlspecialchars($_POST['nama']):''; ?>" required>
                    </div>
                    <div class="supporting-text"></div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="email" data-i18n="label_email">Email</label>
                    <div class="input-wrapper">
                        <input class="input-field" type="email" id="email" name="email" placeholder="contoh@email.com" data-i18n-placeholder="ph_email" value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):''; ?>" required>
                    </div>
                    <div class="supporting-text"></div>
                </div>

                    <div class="input-group">
                    <label class="input-label" for="kelas" data-i18n="label_kelas">Kelas</label>
                    <div class="input-wrapper">
                        <select class="input-field" id="kelas" name="kelas" required>
                            <option value="" data-i18n="opt_select">-- Pilih Kelas --</option>
                            <option value="X RPL 1" <?php if(isset($_POST['kelas']) && $_POST['kelas']=='X RPL 1') echo 'selected'; ?>>X RPL 1</option>
                            <option value="X RPL 2" <?php if(isset($_POST['kelas']) && $_POST['kelas']=='X RPL 2') echo 'selected'; ?>>X RPL 2</option>
                            <option value="XI RPL 1" <?php if(isset($_POST['kelas']) && $_POST['kelas']=='XI RPL 1') echo 'selected'; ?>>XI RPL 1</option>
                            <option value="XI RPL 2" <?php if(isset($_POST['kelas']) && $_POST['kelas']=='XI RPL 2') echo 'selected'; ?>>XI RPL 2</option>
                        </select>
                    </div>
                    <div class="supporting-text"></div>
                </div>

                <div class="input-group span-3">
                    <label class="input-label" data-i18n="label_jk">Jenis Kelamin</label>
                    <div class="input-wrapper">
                        <label style="margin-right:18px"><input type="radio" name="jenis_kelamin" value="Laki-laki" <?php if(isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin']=='Laki-laki') echo 'checked'; ?> required> <span data-i18n="jk_l">Laki-laki</span></label>
                        <label><input type="radio" name="jenis_kelamin" value="Perempuan" <?php if(isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin']=='Perempuan') echo 'checked'; ?> > <span data-i18n="jk_p">Perempuan</span></label>
                    </div>
                    <div class="supporting-text"></div>
                </div>

                <div class="input-group" style="margin-top:6px">
                    <label class="input-label" for="password" data-i18n="label_password">Password</label>
                    <div class="input-wrapper">
                        <input class="input-field" type="password" id="password" name="password" placeholder="Buat password minimal 8 karakter" data-i18n-placeholder="ph_password" required minlength="8">
                    </div>
                    <div class="supporting-text"></div>
                </div>

                <div class="input-group" style="margin-top:6px">
                    <label class="input-label" for="password_confirm" data-i18n="label_confirm">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <input class="input-field" type="password" id="password_confirm" name="password_confirm" placeholder="Ulangi password" data-i18n-placeholder="ph_confirm" required minlength="8">
                    </div>
                    <div class="supporting-text"></div>
                </div>

                <div class="input-group span-3">
                    <button type="submit" class="primary" data-i18n="btn_submit">Daftar Sekarang</button>
                </div>
            </div>
        </form>
    </div>
    <script>window.initialLang = '<?php echo isset($currentLang)?htmlspecialchars($currentLang):'id'; ?>';</script>
    <script src="lang.js"></script>
    <script src="ui.js"></script>
</body>
</html>