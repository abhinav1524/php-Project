<?php 
session_start(); 
require_once '../../Db.php';
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
if (!isset($_SESSION["user"])) {
    echo "User not logged in. Redirecting...";
    header("Location: ./index.php");
    exit;
}

// Check if the user is an admin
$user = $_SESSION["user"];
if ($user["role"] !== "admin") {
    echo "Access denied. Redirecting...";
    header("Location: ./index.php");
    exit;
}
$db = new Database();
$categories = $db->getData('categories'); // Fetch the category by ID
//  echo "<pre>";
//  print_r($categories);
//  die();
//  echo "</pre>";
if (!$categories) {
    $_SESSION['error'] = "posts not found or invalid request.";
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
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <title>Create Post</title>
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
     <div class="container" style="margin-top:100px; margin-bottom:50px">
        <h1 class="text-center text-capitalize">this is the Posts of admin</h1>
        <div class="row">
            <div class="col-12">
                <form action="post.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text"  name="title" class="form-control" id="title"/>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Author</label>
                    <input type="text"  name="author" class="form-control" id="author"/>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Descripiton</label>
                    <input type="text"  name="description" class="form-control" id="description"/>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <div id="content"></div>
                    <textarea type="text" name="content" style="display:none" class="form-control" id="hidden-content"></textarea>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select" aria-label="Default select example">
                        <option value="">Select the category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Feature Image</label>
                    <input type="file" name="image" class="form-control" id="image"/>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="1" name="feature_post" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">
                        Feature Post
                      </label>
                    </div> 
                </div>
                <button type="submit" name="insert" value="true" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
<footer>
      <p class="text-center">all copyright reserve to Abhinav</p>
    </footer>
    <!-- <script src="https://cdn.tiny.cloud/1/r8jon8h8qgvna4rm62vzmjuf0g4qrgszc0ucjrcin7t3n4s0/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> -->
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
 var quill = new Quill('#content', {
  theme: 'snow', // or 'bubble'
  modules: {
    toolbar: [
      [{ header: [1, 2, false] }],
      ['bold', 'italic', 'underline'],
      ['link', 'image']
    ]
  }
});
    // Set initial content
    var contentFromDatabase = "";
    let sanitizedContent = contentFromDatabase.replace(/<span[^>]*>/g, '').replace(/<\/span>/g, '');
    quill.root.innerHTML = sanitizedContent;

    // Update hidden textarea on submit
    document.querySelector('form').addEventListener('submit', function () {
        document.getElementById('hidden-content').value = quill.root.innerHTML;
    });
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.6/swiper-bundle.min.js"></script>
    <script src="../../script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
</body>
</html>