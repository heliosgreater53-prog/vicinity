<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= e($title ?? 'Vicinity') ?></title>
    <link rel="stylesheet" href="<?= asset('modern.css') ?>" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="login-container">
      <div class="login-container-header">
        <div class="login-logo">
          <div class="login-img">
            <i class="fa-solid fa-users"></i>
          </div>
        </div>
        <div class="login-title">Vicinity</div>
      </div>

      <?php if ($error = session()->getFlash('error')): ?>
        <div style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;padding:.85rem 1rem;border-radius:8px;margin-bottom:1.25rem;font-size:.9rem;display:flex;align-items:center;gap:.5rem;">
          <i class="fa-solid fa-circle-exclamation"></i>
          <span><?= e($error) ?></span>
        </div>
      <?php endif; ?>

      <?php if ($success = session()->getFlash('success')): ?>
        <div style="background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.3);color:#86efac;padding:.85rem 1rem;border-radius:8px;margin-bottom:1.25rem;font-size:.9rem;display:flex;align-items:center;gap:.5rem;">
          <i class="fa-solid fa-circle-check"></i>
          <span><?= e($success) ?></span>
        </div>
      <?php endif; ?>

      <?= $this->yield('content') ?>
    </div>
  </body>
</html>
