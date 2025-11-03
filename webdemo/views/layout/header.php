<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PHP MVC Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
  body { background-color: #f8fafc; }
  
  /* Navbar Gradient Buttons */
  .btn-gradient {
    background: linear-gradient(135deg, #0d9488, #14b8a6);
    color: white;
    border: none;
    border-radius: 20px;
    transition: all 0.3s ease;
  }
  .btn-gradient:hover, .btn-gradient:focus {
    background: linear-gradient(135deg, #14b8a6, #0d9488);
    transform: scale(1.05);
    outline: none;
  }

  /* Search Bar */
  .search-form {
    display: flex;
    width: 100%;
    max-width: 400px;
  }
  .search-input-container {
    position: relative;
    flex-grow: 1;
  }
  .search-input {
    width: 100%;
    padding: 0.5rem 1rem 0.5rem 2.5rem;
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    height: 38px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
  }
  .search-input:focus {
    border-color: #0d9488;
    box-shadow: 0 0 0 3px rgba(13,148,136,0.2);
    outline: none;
  }
  .search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
  }
  .search-btn {
    margin-left: 0.5rem;
    height: 38px;
  }

  /* Navbar Links */
  .nav-link {
    font-weight: 500;
    transition: all 0.2s ease;
  }
  .nav-link:hover {
    color: #0d9488;
    transform: scale(1.05);
  }

  /* Responsive: search bar full width on small screens */
  @media (max-width: 992px) {
    .search-form { max-width: 100%; margin-bottom: 0.5rem; }
  }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php?page=products">
      <i class="fas fa-shopping-bag me-2 text-success"></i>MVC Shop
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <!-- Search Bar -->
      <form class="search-form mx-lg-3" action="index.php?page=search" method="GET">
        <div class="search-input-container">
          <i class="fas fa-search search-icon"></i>
          <input class="search-input" type="search" name="q" placeholder="Search products..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
        </div>
        <button type="submit" class="btn btn-gradient search-btn">Search</button>
      </form>

      <!-- Menu Items -->
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="index.php?page=products"><i class="fas fa-box-open me-1"></i>Products</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="index.php?page=admin"><i class="fas fa-clipboard-list me-1"></i>Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?page=cart"><i class="fas fa-shopping-cart me-1"></i>Cart (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : '0' ?>)</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?page=orders"><i class="fas fa-clipboard-list me-1"></i>My Orders</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?page=logout"><i class="fas fa-sign-out-alt me-1"></i>Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="index.php?page=login"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?page=register"><i class="fas fa-user-plus me-1"></i>Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
