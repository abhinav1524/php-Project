<?php 
session_start(); 
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
if (!isset($_SESSION["user"])) {
    echo "User not logged in. Redirecting...";
    header("Location: ./index.php");
    exit;
}
// if (isset($_SESSION["error"])) {
//     echo "<pre>";
//     print_r($_SESSION["error"]);
//     unset($_SESSION['error']);
//     exit;
// }

// Check if the user is an admin
$user = $_SESSION["user"];
if ($user["role"] !== "admin") {
    echo "Access denied. Redirecting...";
    header("Location: ./index.php");
    exit;
}
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
    <link rel="stylesheet" href="../../style.css" />
    <title>Posts</title>
</head>
<body>
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
                <a class="nav-link active" aria-current="page" href="../dashboard.php"
                  >Home</a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../post/index.php">Posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../category/index.php">Category</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="tags.php">Tags</a>
              </li>
              <li class="nav-item">
                <?php if ($isLoggedIn): ?>
              <a href="../../logout.php" class="nav-link">Logout</a>
              <?php else: ?>
              <a href="../../login.php" class="nav-link">Login</a>
              <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
     <div class="container" style="margin-top:100px">
        <h1 class="text-center text-capitalize">this is the Posts of admin</h1>
        <div class=" mt-5 d-flex justify-content-center align-items-center search_bar">
        <div class="d-flex">
          <input
            id="searchInput"
            class="form-control me-2"
            type="search"
            placeholder="Search"
            aria-label="Search"
            value ="";
            />
        </div>
      </div>
        <div class="d-flex justify-content-end mb-5">
          <a href="../post/create.php" class="btn btn-primary">
          Add Post
          </a>
        </div>
      <table class="table table-striped">
      <thead class="table-dark">
        <tr>
          <th>S.no</th>
          <th>Title</th>
          <th>Slug</th>
          <th>Author</th>
          <th>Description</th>
          <th>Category</th>
          <th>Image</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="posts-table-body"></tbody>
    </table>
    <nav>
      <ul class="pagination justify-content-center" id="pagination">
        <!-- Pagination items will be inserted here dynamically -->
      </ul>
    </nav>
    </div>
<footer class="fixed-bottom">
      <p class="text-center">all copyright reserve to Abhinav</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.6/swiper-bundle.min.js"></script>
    <script src="../../script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
</body>
</html>