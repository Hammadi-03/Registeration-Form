<?php
$registered = isset($_GET['registered']) && $_GET['registered']=='1';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'id';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="bg-blob" aria-hidden="true"></div>
  <div class="bg-blob2" aria-hidden="true"></div>
  <div class="container">
    <header class="header">
      <div class="header-left">
        <div class="logo" aria-hidden="true">
          <img src="assets/logo.png" alt="Boarding School" class="logo-image">
        </div>
        <div>
          <span class="brand-text">Boarding School</span>
          <h1 class="title">Login</h1>
          <p class="subtitle">Masuk untuk melanjutkan</p>
        </div>
      </div>
      <div class="header-right">
        <div class="lang-switch" role="tablist" aria-label="Language selector">
          <button type="button" class="lang-btn" data-lang="id">ID</button>
          <button type="button" class="lang-btn" data-lang="en">EN</button>
        </div>
      </div>
    </header>
    <div class="header-accent" aria-hidden="true"></div>

    <?php if($registered): ?>
      <div class="sukses">
        <h3>✅ Registration successful — please sign in</h3>
      </div>
    <?php endif; ?>

    <form method="POST" action="#" class="form-grid">
      <div class="input-group span-3">
        <label class="input-label">Email</label>
        <div class="input-wrapper">
          <input class="input-field" type="email" name="email" placeholder="name@example.com">
        </div>
      </div>

      <div class="input-group span-3">
        <label class="input-label">Password</label>
        <div class="input-wrapper">
          <input class="input-field" type="password" name="password" placeholder="••••••">
        </div>
      </div>

      <div class="input-group span-3">
        <button class="primary" type="submit">Sign in</button>
      </div>
    </form>
  </div>

  <script>window.initialLang = '<?php echo htmlspecialchars($lang); ?>';</script>
  <script src="lang.js"></script>
  <script src="ui.js"></script>
</body>
</html>