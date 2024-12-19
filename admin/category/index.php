<?php 
session_start(); 
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
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
    <title>Category</title>
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
                <a class="nav-link" href="#">Category</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Tags</a>
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
     <div class="container" style="margin-top:100px">
        <h1 class="text-center text-capitalize">this is the category of admin</h1>
        <div class="d-flex justify-content-end mb-5">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Add Category
          </button>
        </div>
      <table class="table table-striped">
      <thead class="table-dark">
        <tr>
          <th>S.no</th>
          <th>Category</th>
          <th>Slug</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="table-body">
        <?php 
        foreach ($categories as $index => $category): ?>
        <tr class="table_body">
            <td style="background-color:transparent"><?= $category['id'] ?></td>
            <td style="background-color:transparent"><?= htmlspecialchars($category['name']) ?></td>
            <td style="background-color:transparent"><?= htmlspecialchars($category['slug']) ?></td>
            <td style="background-color:transparent">
                <div class="d-flex justify-content-around align-items-center">
                     <a href="#" class="btn btn-warning edit-btn" data-id="<?= $category['id'] ?>">Edit</a>
                    <a href="#" class="btn btn-danger delete-btn" data-id="<?= $category['id'] ?>">Delete</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
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
      <!-- model  -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="category.php" method="post">
          <div class="modal-body">
            <label for="categoryname" class="form-label">Category Name</label>
            <input class="form-control" type="text" name="name" id="categoryname" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
              </form>
    </div>
  </div>
</div>
<script>
    $(document).on('click', '.edit-btn', function(e) {
        e.preventDefault();
        let categoryId = $(this).data('id');
        $('#category-id').val(categoryId);
        $('#exampleModal').modal('show'); // Show the modal
    });

    // Delete button click
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        let categoryId = $(this).data('id');
        if (confirm('Are you sure you want to delete this category?')) {
            // Perform AJAX request to delete
            $.ajax({
                url: 'category.php',
                method: 'POST',
                data: { id: categoryId, action: 'delete' },
                success: function(response) {
                    location.reload(); // Reload the page after deletion
                }
            });
        }
    });
</script>
</body>
</html>