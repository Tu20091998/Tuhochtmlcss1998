<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%; backdrop-filter: blur(12px); background: rgba(245, 245, 245, 0.85);">
    <h1 class="text-center mb-4 display-6 fw-bold" style="background: linear-gradient(135deg, #0d9488, #14b8a6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
      Login
    </h1>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger shadow-sm" role="alert" aria-live="assertive">
        <ul class="mb-0">
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=login" novalidate>
      <div class="form-floating mb-4">
        <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Username" autocomplete="username" required autofocus />
        <label for="username">Username</label>
      </div>
      <div class="form-floating mb-4">
        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password" autocomplete="current-password" required />
        <label for="password">Password</label>
      </div>
      <button type="submit" class="btn btn-gradient w-100 py-3 fw-semibold" style="background: linear-gradient(135deg, #0d9488, #14b8a6); color: white; border: none; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.6); transition: all 0.3s ease;">
        Login
      </button>
    </form>

    <p class="text-center mt-4 mb-0" style="color: #0d9488;">
      Don't have an account? <a href="index.php?page=register" class="text-decoration-none" style="color: #14b8a6;">Register here</a>.
    </p>
  </div>
</div>

<style>
  body {
    background: linear-gradient(135deg, #e0f2f1 0%, #a7f3d0 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
  }
  .btn-gradient:hover, .btn-gradient:focus {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
    box-shadow: 0 6px 20px rgba(20, 184, 166, 0.8);
    outline: none;
    transform: scale(1.05);
    transition: all 0.3s ease;
  }
</style>

<?php require __DIR__ . '/../layout/footer.php'; ?>

