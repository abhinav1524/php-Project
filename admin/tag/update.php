<?php 
session_start(); 
require_once '../../Db.php';
// require_once "./category.php";
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
$id = $_GET['id'] ?? ''; // Get the ID from the URL
//  echo "<pre>";
//  print_r($id);
//  die();
//  echo "</pre>";
if (empty($id)) {
    $_SESSION['error'] = "ID is missing.";
    header("Location: ./index.php");
    exit();
}

// Fetch the category using the getOne method
$db = new Database();
$tags = $db->getOne('tags', ['id' => $id]); // Fetch the category by ID
//  echo "<pre>";
//  print_r($tags);
//  die();
//  echo "</pre>";
if (!$tags) {
    $_SESSION['error'] = "Tag not found or invalid request.";
    header("Location: ./index.php");
    exit();
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
    <title>Edit</title>
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
                <a class="nav-link" href="#">Posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="category/index.php">Category</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php">Tags</a>
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
        <h1 class="text-center text-capitalize">this is the tag of admin</h1>
        <div class="d-flex justify-content-center align-items-center mb-5">
            <div>
            <?php if (isset($tags) && !empty($tags)): ?>
            <form action="tag.php" method="post">
          <div>
            <label for="tagname" class="form-label">Tag Name</label>
            <input class="form-control" type="text" name="name" id="tagname" value="<?php echo htmlspecialchars($tags['name']); ?>" required>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($tags['id']); ?>">
          </div>
          <div class="mt-2">
            <button type="submit" name="update" value="true" class="p-2 btn btn-primary">update Category</button>
        </div>
        </form>
        <?php else: ?>
    <p>Tag not found or invalid request.</p>
<?php endif; ?>
            </div>
        </div>
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