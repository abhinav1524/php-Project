<?php 
session_start(); 
require_once '../Db.php';
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
$db = new Database();
$totalPosts =count($db->getData('posts'));
$categories = count($db->getData('categories'));
$activity = count($db->getData('user_activity'));
// echo "<pre>";
// print_r($totalPosts);
// die();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.6/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../style.css" />
    <title>Dashboard</title>
</head>
<body class="bg-light text-dark">
    <header class="fixed-top">
      <nav class="navbar navbar-expand-lg px-5" id="navbar">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Navbar</a>
          <button id="toggleDarkMode" class="btn btn-light">
            <i id="darkModeIcon" class="fas fa-moon"></i>
          </button>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.html"
                  >Home</a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="post/index.php">Posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="category/index.php">Category</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="tag/index.php">Tags</a>
              </li>
              <li class="nav-item">
                <?php if ($isLoggedIn): ?>
              <a href="../logout.php" class="nav-link">Logout</a>
              <?php else: ?>
              <a href="../login.php" class="nav-link">Login</a>
              <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
 <div class="container mt-100">
        <!-- Welcome Banner -->
        <div class="alert alert-primary text-center shadow">
            <h1>Welcome Back, Admin!</h1>
            <p>Here's a quick overview of your blog performance today.</p>
        </div>

        <!-- Stats Section -->
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h5 class="card-title">Total Posts</h5>
                        <h2 class="text-primary"><?php echo $totalPosts?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h5 class="card-title">Active Users</h5>
                        <h2 class="text-success"><?php echo $activity?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <h2 class="text-warning"><?php echo $categories?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="fixed-bottom">
      <p class="text-center">all copyright reserve to Abhinav</p>
    </footer>
    <script src="../script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
</body>
</html>