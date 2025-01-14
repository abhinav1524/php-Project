<?php
session_start(); 
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
require_once "./Db.php";
$db =new Database();
$feature_posts=$db->getData("posts",'','posts.*', 'WHERE feature_post = 1');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <link rel="stylesheet" href="style.css" />
    <title>contact us</title>
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
                <a class="nav-link" href="about.php">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
              </li>
              <li class="nav-item">
                <?php if ($isLoggedIn): ?>
              <a href="logout.php" class="nav-link">Logout</a>
              <?php else: ?>
              <a href="login.php" class="nav-link">Login</a>
              <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
        <div class="contianer pt-5 mb-120">
                <div class="row mx-5 pt-5">
                    <div class="col-12 col-lg-8">
                        <div class="inquiry-form contact-inquiry">
                            <div class="title">
                                <h1>Contact Us!</h1>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-inner mb-20">
                                            <label>Your Name* :</label>
                                            <input type="text" placeholder="Jackson Mile">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-inner mb-20">
                                            <label>Your Email* :</label>
                                            <input type="email" placeholder="example@gamil.com">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-inner mb-20">
                                            <label>Subject*</label>
                                            <input type="text" placeholder="What’s kind of topic">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-inner mb-15">
                                            <label>Message <span> (Optional)</span></label>
                                            <textarea class="contact-massage" placeholder="Write Something..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="contactCheck">
                                            <label class="form-check-label" for="contactCheck">
                                                Please save my name, email address for the next time I
                                                comment.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-inner">
                                    <button class="primary-btn1 contact-btn" data-text="Post Comment" type="submit">
                                        <span> <svg class="arrow" width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9" stroke="#191919" stroke-width="1.5" stroke-linecap="round"></path>
                                            </svg>
                                            SUBMIT</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 col-sm-mt-5">
                        <div class="life-style-sidebar">
                        <div class="sidebar-widget featured-post">
                            <h6>Featured Post</h6>
                            <?php foreach($feature_posts as $feature_post): ?>
                            <div class="recent-post mb-20">
                            <div class="recent-post-img">
                                <a href="standard.php"
                                ><img src="<?php echo str_repeat('../', substr_count($feature_post['image'], '/')) . 'images/' . basename($feature_post['image']); ?>" alt=""
                                /></a>
                            </div>
                            <div class="recent-post-content">
                                <a href="life-style.html"><?php echo date('d F Y', strtotime($feature_post['created_at'])); ?></a>
                                <h5>
                                <a href="standard.php?id=<?php echo $feature_post['id']; ?>"
                                    ><?php echo htmlspecialchars($feature_post['title']); ?></a
                                >
                                </h5>
                            </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
    <footer class="footer">
      <p class="text-center">all copyright reserve to Abhinav</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.6/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
</body>
</html>