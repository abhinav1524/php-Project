<?php 
session_start(); 
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
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
    <title>Document</title>
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
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
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
    <div class="container" style="margin-top: 90px">
      <!-- search bar section -->
      <div class="d-flex justify-content-center align-items-center">
        <form class="d-flex" role="search">
          <input
            class="form-control me-2"
            type="search"
            placeholder="Search"
            aria-label="Search" />
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
      <!-- image slider section -->
      <div class="mt-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 position-relative">
              <!-- Swiper Container -->
              <div class="swiper-container">
                <div class="swiper-wrapper">
                  <!-- Slides -->
                  <div class="swiper-slide">
                    <div class="banner-card">
                      <div class="banner-img">
                        <img src="images/banner-img-1.png" alt="Slide 1" />
                      </div>
                      <div class="banner-content">
                        <div class="category">
                          <a href="#">Fashion</a>
                        </div>
                        <div class="banner-content-bottom">
                          <div class="author-area">
                            <ul>
                              <li><a href="profile.html">Robert Kcarery</a></li>
                              <li>
                                <a href="life-style.html">
                                  <svg
                                    width="6"
                                    height="6"
                                    viewBox="0 0 6 6"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle
                                      cx="3"
                                      cy="3"
                                      r="3"
                                      fill="#C4C4C4"></circle>
                                  </svg>
                                  "15 Dec 2024"
                                </a>
                              </li>
                            </ul>
                          </div>
                          <h2>
                            <a href="standard-format.html">
                              Style Chronicles Fashion Trends and Tips
                            </a>
                          </h2>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div class="banner-card">
                      <div class="banner-img">
                        <img src="images/banner-img-2.png" alt="Slide 1" />
                      </div>
                      <div class="banner-content">
                        <div class="category">
                          <a href="#">Fashion</a>
                        </div>
                        <div class="banner-content-bottom">
                          <div class="author-area">
                            <ul>
                              <li><a href="profile.html">Robert Kcarery</a></li>
                              <li>
                                <a href="life-style.html">
                                  <svg
                                    width="6"
                                    height="6"
                                    viewBox="0 0 6 6"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle
                                      cx="3"
                                      cy="3"
                                      r="3"
                                      fill="#C4C4C4"></circle>
                                  </svg>
                                  "15 Dec 2024"
                                </a>
                              </li>
                            </ul>
                          </div>
                          <h2>
                            <a href="standard-format.html">
                              Style Chronicles Fashion Trends and Tips
                            </a>
                          </h2>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div class="banner-card">
                      <div class="banner-img">
                        <img src="images/banner-img-3.png" alt="Slide 1" />
                      </div>
                      <div class="banner-content">
                        <div class="category">
                          <a href="#">Fashion</a>
                        </div>
                        <div class="banner-content-bottom">
                          <div class="author-area">
                            <ul>
                              <li><a href="profile.html">Robert Kcarery</a></li>
                              <li>
                                <a href="life-style.html">
                                  <svg
                                    width="6"
                                    height="6"
                                    viewBox="0 0 6 6"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle
                                      cx="3"
                                      cy="3"
                                      r="3"
                                      fill="#C4C4C4"></circle>
                                  </svg>
                                  "15 Dec 2024"
                                </a>
                              </li>
                            </ul>
                          </div>
                          <h2>
                            <a href="standard-format.html">
                              Style Chronicles Fashion Trends and Tips
                            </a>
                          </h2>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div class="banner-card">
                      <div class="banner-img">
                        <img src="images/banner-img-4.png" alt="Slide 1" />
                      </div>
                      <div class="banner-content">
                        <div class="category">
                          <a href="#">Fashion</a>
                        </div>
                        <div class="banner-content-bottom">
                          <div class="author-area">
                            <ul>
                              <li><a href="profile.html">Robert Kcarery</a></li>
                              <li>
                                <a href="life-style.html">
                                  <svg
                                    width="6"
                                    height="6"
                                    viewBox="0 0 6 6"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle
                                      cx="3"
                                      cy="3"
                                      r="3"
                                      fill="#C4C4C4"></circle>
                                  </svg>
                                  "15 Dec 2024"
                                </a>
                              </li>
                            </ul>
                          </div>
                          <h2>
                            <a href="standard-format.html">
                              Style Chronicles Fashion Trends and Tips
                            </a>
                          </h2>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div class="banner-card">
                      <div class="banner-img">
                        <img src="images/banner-img-5.png" alt="Slide 1" />
                      </div>
                      <div class="banner-content">
                        <div class="category">
                          <a href="#">Fashion</a>
                        </div>
                        <div class="banner-content-bottom">
                          <div class="author-area">
                            <ul>
                              <li><a href="profile.html">Robert Kcarery</a></li>
                              <li>
                                <a href="life-style.html">
                                  <svg
                                    width="6"
                                    height="6"
                                    viewBox="0 0 6 6"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle
                                      cx="3"
                                      cy="3"
                                      r="3"
                                      fill="#C4C4C4"></circle>
                                  </svg>
                                  "15 Dec 2024"
                                </a>
                              </li>
                            </ul>
                          </div>
                          <h2>
                            <a href="standard-format.html">
                              Style Chronicles Fashion Trends and Tips
                            </a>
                          </h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Navigation Buttons -->
                <div class="banner-btn-group">
                  <div class="banner-btn prev-1">
                    <svg
                      width="7"
                      height="14"
                      viewBox="0 0 7 14"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M0 7.00008L7 0L2.54545 7.00008L7 14L0 7.00008Z"></path>
                    </svg>
                    <span class="banner-slider-btn">PREV</span>
                  </div>
                  <div class="banner-btn next-1">
                    <span class="banner-slider-btn">NEXT</span>
                    <svg
                      width="7"
                      height="14"
                      viewBox="0 0 7 14"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M7 7.00008L0 0L4.45455 7.00008L0 14L7 7.00008Z"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- discover today section -->
      <div class="discover-section mb-70">
        <div class="container">
          <div class="row mb-20">
            <div class="col-lg-12">
              <div class="section-title">
                <h5>Discover Today’s</h5>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 position-relative">
              <div class="slider-btn-groups">
                <div
                  class="slider-btn prev-1"
                  tabindex="0"
                  role="button"
                  aria-label="Previous slide">
                  <svg
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0.416666 8.96667H15V7.71667H0.416666V8.96667Z"></path>
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M1.04115 7.71667C3.98115 7.71667 6.38281 10.3017 6.38281 13.0583V13.6833H5.13281V13.0583C5.13281 10.9658 3.26448 8.96667 1.04115 8.96667H0.416979V7.71667H1.04115Z"></path>
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M1.04115 8.96667C3.98115 8.96667 6.38281 6.38167 6.38281 3.625V3H5.13281V3.625C5.13281 5.71833 3.26448 7.71667 1.04115 7.71667H0.416979V8.96667H1.04115Z"></path>
                  </svg>
                </div>
                <div
                  class="slider-btn next-1"
                  tabindex="0"
                  role="button"
                  aria-label="Next slide">
                  <svg
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M15.5833 8.96667H1V7.71667H15.5833V8.96667Z"></path>
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M14.9589 7.71667C12.0189 7.71667 9.61719 10.3017 9.61719 13.0583V13.6833H10.8672V13.0583C10.8672 10.9658 12.7355 8.96667 14.9589 8.96667H15.583V7.71667H14.9589Z"></path>
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M14.9589 8.96667C12.0189 8.96667 9.61719 6.38167 9.61719 3.625V3H10.8672V3.625C10.8672 5.71833 12.7355 7.71667 14.9589 7.71667H15.583V8.96667H14.9589Z"></path>
                  </svg>
                </div>
              </div>
              <div
                class="swiper-container discover-slider swiper-initialized swiper-horizontal swiper-backface-hidden">
                <div
                  class="swiper-wrapper"
                  aria-live="off"
                  style="
                    transition-duration: 1500ms;
                    transform: translate3d(-956px, 0px, 0px);
                  ">
                  <div
                    class="swiper-slide"
                    style="width: 298.667px; margin-right: 20px"
                    role="group"
                    aria-label="2 / 6">
                    <div class="discover-content">
                      <div class="number">
                        <span>02</span>
                      </div>
                      <div class="other-content">
                        <a href="life-style.html">05 January, 2024</a>
                        <h6>
                          <a href="standard-formate.html"
                            >Foodie Diaries: Recipes for Every Occasion</a
                          >
                        </h6>
                      </div>
                    </div>
                  </div>
                  <div
                    class="swiper-slide"
                    style="width: 298.667px; margin-right: 20px"
                    role="group"
                    aria-label="3 / 6">
                    <div class="discover-content">
                      <div class="number">
                        <span>03</span>
                      </div>
                      <div class="other-content">
                        <a href="life-style.html">05 January, 2024</a>
                        <h6>
                          <a href="standard-formate.html"
                            >Foodie Diaries: Recipes for Every Occasion</a
                          >
                        </h6>
                      </div>
                    </div>
                  </div>
                  <div
                    class="swiper-slide swiper-slide-prev"
                    style="width: 298.667px; margin-right: 20px"
                    role="group"
                    aria-label="4 / 6">
                    <div class="discover-content">
                      <div class="number">
                        <span>01</span>
                      </div>
                      <div class="other-content">
                        <a href="life-style.html">05 January, 2024</a>
                        <h6>
                          <a href="standard-formate.html"
                            >Foodie Diaries: Recipes for Every Occasion</a
                          >
                        </h6>
                      </div>
                    </div>
                  </div>
                  <div
                    class="swiper-slide swiper-slide-active"
                    style="width: 298.667px; margin-right: 20px"
                    role="group"
                    aria-label="5 / 6">
                    <div class="discover-content">
                      <div class="number">
                        <span>02</span>
                      </div>
                      <div class="other-content">
                        <a href="life-style.html">05 January, 2024</a>
                        <h6>
                          <a href="standard-formate.html"
                            >Foodie Diaries: Recipes for Every Occasion</a
                          >
                        </h6>
                      </div>
                    </div>
                  </div>
                  <div
                    class="swiper-slide swiper-slide-next"
                    role="group"
                    aria-label="6 / 6"
                    style="width: 298.667px; margin-right: 20px">
                    <div class="discover-content">
                      <div class="number">
                        <span>03</span>
                      </div>
                      <div class="other-content">
                        <a href="life-style.html">05 January, 2024</a>
                        <h6>
                          <a href="standard-formate.html"
                            >Foodie Diaries: Recipes for Every Occasion</a
                          >
                        </h6>
                      </div>
                    </div>
                  </div>
                  <div
                    class="swiper-slide"
                    style="width: 298.667px; margin-right: 20px"
                    role="group"
                    aria-label="1 / 6">
                    <div class="discover-content">
                      <div class="number">
                        <span>01</span>
                      </div>
                      <div class="other-content">
                        <a href="life-style.html">05 January, 2024</a>
                        <h6>
                          <a href="standard-formate.html"
                            >Foodie Diaries: Recipes for Every Occasion</a
                          >
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
                <span
                  class="swiper-notification"
                  aria-live="assertive"
                  aria-atomic="true"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- blog posts tab section -->
      <div class="blog-section mt-5">
        <div class="row">
          <!-- Left Column -->
          <div class="border-blog col-12 col-md-12 col-lg-8 py-5">
            <ul
              class="nav nav-pills justify-content-center mb-3"
              id="pills-tab"
              role="tablist">
              <li class="nav-item" role="presentation">
                <button
                  class="tab-btn active"
                  id="pills-home-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-home"
                  type="button"
                  role="tab"
                  aria-controls="pills-home"
                  aria-selected="true">
                  Travel
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  class="tab-btn"
                  id="pills-profile-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-profile"
                  type="button"
                  role="tab"
                  aria-controls="pills-profile"
                  aria-selected="false">
                  Food
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  class="tab-btn"
                  id="pills-contact-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-contact"
                  type="button"
                  role="tab"
                  aria-controls="pills-contact"
                  aria-selected="false">
                  Fashion
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  class="tab-btn"
                  id="pills-tech-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-tech"
                  type="button"
                  role="tab"
                  aria-controls="pills-tech"
                  aria-selected="false">
                  Tech
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  class="tab-btn"
                  id="pills-beauty-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-beauty"
                  type="button"
                  role="tab"
                  aria-controls="pills-beauty"
                  aria-selected="false">
                  Beauty
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  class="tab-btn"
                  id="pills-gaming-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-gaming"
                  type="button"
                  role="tab"
                  aria-controls="pills-gaming"
                  aria-selected="false">
                  Gaming
                </button>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div
                class="tab-pane fade show active"
                id="pills-home"
                role="tabpanel"
                aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="row g-4 gy-5">
                  <div class="col-md-6">
                    <div class="blog-card">
                      <div class="blog-card-img-wrap">
                        <a href="standard-formate.html">
                          <img src="images/travel-01.png" alt="" />
                        </a>
                        <a href="life-style.html"><span>Travel</span> </a>
                      </div>
                      <div class="blog-content">
                        <div class="author-area">
                          <ul>
                            <li>
                              <a href="editor-profile.html">Robert Kcarery</a>
                            </li>
                            <li>
                              <a class="publish-date" href="life-style.html">
                                <svg
                                  width="6"
                                  height="6"
                                  viewBox="0 0 6 6"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <circle
                                    cx="3"
                                    cy="3"
                                    r="3"
                                    fill="#C4C4C4"></circle>
                                </svg>
                                08 Jan, 2024</a
                              >
                            </li>
                          </ul>
                        </div>
                        <h5>
                          <a href="standard-formate.html"
                            >Pairing Wine with Gastronomic Delights.</a
                          >
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="blog-card">
                      <div class="blog-card-img-wrap">
                        <a href="standard-formate.html">
                          <img src="images/travel-02.png" alt="" />
                        </a>
                        <a href="life-style.html"><span>Travel</span> </a>
                      </div>
                      <div class="blog-content">
                        <div class="author-area">
                          <ul>
                            <li>
                              <a href="editor-profile.html">Robert Kcarery</a>
                            </li>
                            <li>
                              <a class="publish-date" href="life-style.html">
                                <svg
                                  width="6"
                                  height="6"
                                  viewBox="0 0 6 6"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <circle
                                    cx="3"
                                    cy="3"
                                    r="3"
                                    fill="#C4C4C4"></circle>
                                </svg>
                                08 Jan, 2024</a
                              >
                            </li>
                          </ul>
                        </div>
                        <h5>
                          <a href="standard-formate.html"
                            >Pairing Wine with Gastronomic Delights.</a
                          >
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="blog-card">
                      <div class="blog-card-img-wrap">
                        <a href="standard-formate.html">
                          <img src="images/travel-01.png" alt="" />
                        </a>
                        <a href="life-style.html"><span>Travel</span> </a>
                      </div>
                      <div class="blog-content">
                        <div class="author-area">
                          <ul>
                            <li>
                              <a href="editor-profile.html">Robert Kcarery</a>
                            </li>
                            <li>
                              <a class="publish-date" href="life-style.html">
                                <svg
                                  width="6"
                                  height="6"
                                  viewBox="0 0 6 6"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <circle
                                    cx="3"
                                    cy="3"
                                    r="3"
                                    fill="#C4C4C4"></circle>
                                </svg>
                                08 Jan, 2024</a
                              >
                            </li>
                          </ul>
                        </div>
                        <h5>
                          <a href="standard-formate.html"
                            >Pairing Wine with Gastronomic Delights.</a
                          >
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="blog-card">
                      <div class="blog-card-img-wrap">
                        <a href="standard-formate.html">
                          <img src="images/travel-02.png" alt="" />
                        </a>
                        <a href="life-style.html"><span>Travel</span> </a>
                      </div>
                      <div class="blog-content">
                        <div class="author-area">
                          <ul>
                            <li>
                              <a href="editor-profile.html">Robert Kcarery</a>
                            </li>
                            <li>
                              <a class="publish-date" href="life-style.html">
                                <svg
                                  width="6"
                                  height="6"
                                  viewBox="0 0 6 6"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <circle
                                    cx="3"
                                    cy="3"
                                    r="3"
                                    fill="#C4C4C4"></circle>
                                </svg>
                                08 Jan, 2024</a
                              >
                            </li>
                          </ul>
                        </div>
                        <h5>
                          <a href="standard-formate.html"
                            >Pairing Wine with Gastronomic Delights.</a
                          >
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="blog-card">
                      <div class="blog-card-img-wrap">
                        <a href="standard-formate.html">
                          <img src="images/travel-01.png" alt="" />
                        </a>
                        <a href="life-style.html"><span>Travel</span> </a>
                      </div>
                      <div class="blog-content">
                        <div class="author-area">
                          <ul>
                            <li>
                              <a href="editor-profile.html">Robert Kcarery</a>
                            </li>
                            <li>
                              <a class="publish-date" href="life-style.html">
                                <svg
                                  width="6"
                                  height="6"
                                  viewBox="0 0 6 6"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <circle
                                    cx="3"
                                    cy="3"
                                    r="3"
                                    fill="#C4C4C4"></circle>
                                </svg>
                                08 Jan, 2024</a
                              >
                            </li>
                          </ul>
                        </div>
                        <h5>
                          <a href="standard-formate.html"
                            >Pairing Wine with Gastronomic Delights.</a
                          >
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="blog-card">
                      <div class="blog-card-img-wrap">
                        <a href="standard-formate.html">
                          <img src="images/travel-02.png" alt="" />
                        </a>
                        <a href="life-style.html"><span>Travel</span> </a>
                      </div>
                      <div class="blog-content">
                        <div class="author-area">
                          <ul>
                            <li>
                              <a href="editor-profile.html">Robert Kcarery</a>
                            </li>
                            <li>
                              <a class="publish-date" href="life-style.html">
                                <svg
                                  width="6"
                                  height="6"
                                  viewBox="0 0 6 6"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <circle
                                    cx="3"
                                    cy="3"
                                    r="3"
                                    fill="#C4C4C4"></circle>
                                </svg>
                                08 Jan, 2024</a
                              >
                            </li>
                          </ul>
                        </div>
                        <h5>
                          <a href="standard-formate.html"
                            >Pairing Wine with Gastronomic Delights.</a
                          >
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center align-items-center">
                    <a href="#" class="loadmore">Loadmore</a>
                  </div>
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="pills-profile"
                role="tabpanel"
                aria-labelledby="pills-profile-tab"
                tabindex="0">
                <div class="row g-4 gy-5">
                  <div class="col-md-6">
                    <div class="blog-card">
                      <div class="blog-card-img-wrap">
                        <a href="standard-formate.html">
                          <img src="images/travel-01.png" alt="" />
                        </a>
                        <a href="life-style.html"><span>Travel</span> </a>
                      </div>
                      <div class="blog-content">
                        <div class="author-area">
                          <ul>
                            <li>
                              <a href="editor-profile.html">Robert Kcarery</a>
                            </li>
                            <li>
                              <a class="publish-date" href="life-style.html">
                                <svg
                                  width="6"
                                  height="6"
                                  viewBox="0 0 6 6"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <circle
                                    cx="3"
                                    cy="3"
                                    r="3"
                                    fill="#C4C4C4"></circle>
                                </svg>
                                08 Jan, 2024</a
                              >
                            </li>
                          </ul>
                        </div>
                        <h5>
                          <a href="standard-formate.html"
                            >Pairing Wine with Gastronomic Delights.</a
                          >
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="blog-card">
                      <div class="blog-card-img-wrap">
                        <a href="standard-formate.html">
                          <img src="images/travel-02.png" alt="" />
                        </a>
                        <a href="life-style.html"><span>Travel</span> </a>
                      </div>
                      <div class="blog-content">
                        <div class="author-area">
                          <ul>
                            <li>
                              <a href="editor-profile.html">Robert Kcarery</a>
                            </li>
                            <li>
                              <a class="publish-date" href="life-style.html">
                                <svg
                                  width="6"
                                  height="6"
                                  viewBox="0 0 6 6"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <circle
                                    cx="3"
                                    cy="3"
                                    r="3"
                                    fill="#C4C4C4"></circle>
                                </svg>
                                08 Jan, 2024</a
                              >
                            </li>
                          </ul>
                        </div>
                        <h5>
                          <a href="standard-formate.html"
                            >Pairing Wine with Gastronomic Delights.</a
                          >
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="pills-contact"
                role="tabpanel"
                aria-labelledby="pills-contact-tab"
                tabindex="0">
                this is the third tab
              </div>
              <div
                class="tab-pane fade"
                id="pills-tech"
                role="tabpanel"
                aria-labelledby="pills-tech-tab"
                tabindex="0">
                this is the fourth tab
              </div>
              <div
                class="tab-pane fade"
                id="pills-beauty"
                role="tabpanel"
                aria-labelledby="pills-beauty-tab"
                tabindex="0">
                this is the fifth tab
              </div>
              <div
                class="tab-pane fade"
                id="pills-gaming"
                role="tabpanel"
                aria-labelledby="pills-gaming-tab"
                tabindex="0">
                this is the sixth tab
              </div>
            </div>
          </div>
          <!-- Right Column -->
          <div class="col-12 col-md-12 col-lg-4">
            <div class="life-style-sidebar">
              <div class="sidebar-widget featured-post">
                <h6>Featured Post</h6>
                <div class="recent-post mb-20">
                  <div class="recent-post-img">
                    <a href="standard-formate.html"
                      ><img src="images/sidebar-img1.png" alt=""
                    /></a>
                  </div>
                  <div class="recent-post-content">
                    <a href="life-style.html">05 January, 2024</a>
                    <h5>
                      <a href="standard-formate.html"
                        >A Guide to Better Sleep Habits.</a
                      >
                    </h5>
                  </div>
                </div>
                <div class="recent-post mb-20">
                  <div class="recent-post-img">
                    <a href="standard-formate.html"
                      ><img src="images/sidebar-img2.png" alt=""
                    /></a>
                  </div>
                  <div class="recent-post-content">
                    <a href="life-style.html">05 January, 2024</a>
                    <h5>
                      <a href="standard-formate.html"
                        >A Guide to Better Sleep Habits.</a
                      >
                    </h5>
                  </div>
                </div>
                <div class="recent-post mb-20">
                  <div class="recent-post-img">
                    <a href="standard-formate.html"
                      ><img src="images/sidebar-img3.png" alt=""
                    /></a>
                  </div>
                  <div class="recent-post-content">
                    <a href="life-style.html">05 January, 2024</a>
                    <h5>
                      <a href="standard-formate.html"
                        >A Guide to Better Sleep Habits.</a
                      >
                    </h5>
                  </div>
                </div>
                <div class="recent-post mb-20">
                  <div class="recent-post-img">
                    <a href="standard-formate.html"
                      ><img src="images/sidebar-img4.png" alt=""
                    /></a>
                  </div>
                  <div class="recent-post-content">
                    <a href="life-style.html">05 January, 2024</a>
                    <h5>
                      <a href="standard-formate.html"
                        >A Guide to Better Sleep Habits.</a
                      >
                    </h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="add-image">
              <img src="images/Sidebar-ads.png" alt="" />
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