<?php
session_start(); 
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
require_once "./Db.php";
$db =new Database();
// feature posts //
$feature_posts=$db->getData("posts",'','posts.*', 'WHERE feature_post = 1');
// Get the post ID from the URL
$postId = $_GET['id'] ?? null;
// echo "<pre>";
// print_r($postId);
// die();
// echo "</pre>";

if ($postId) {
    // Fetch the post data from the database
    $join = "LEFT JOIN categories c ON posts.category_id = c.id";
    $post = $db->getData('posts', $join, 'posts.*,c.name AS category_name', "WHERE posts.id = $postId");
    // echo "<pre>";
    // print_r($post);
    // die();
    // echo "</pre>";
    // If post exists, display it
    if (!empty($post)) {
        $post = $post[0]; // Since getData returns an array of results
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "Invalid post ID.";
    exit;
}
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
    <title>Post</title>
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
                <a class="nav-link active" aria-current="page" href="index.php"
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
                <a class="nav-link" href="login.php">Login</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <div class="container" style="margin-top: 100px">
      <div class="row g-4 gy-5">
        <div class="col-12 col-md-12 col-lg-8">
          <div class="post-thump">
            <img src="<?php echo str_repeat('../', substr_count($post['image'], '/')) . 'images/' . basename($post['image']); ?>" alt="" />
          </div>
          <ul class="post-meta">
            <li><a href="#"><?php echo htmlspecialchars($post['author']); ?></a></li>
            <li><a href="#" class="publish-date"><?php echo date('d M Y', strtotime($post['created_at'])); ?></a></li>
          </ul>
          <h1 class="post-heading">
            <?php echo htmlspecialchars($post['title']); ?>
          </h1>
          <div class="row justify-content-center">
            <div class="col-lg-10 mb-60">
              <div class="blog-content">
                <?php echo $post['content']; ?>
                <p>
                  "Infinite Odyssey: Your Journey into Gaming Infinity" is a
                  groundbreaking gaming experience that transcends traditional
                  boundaries, offering players an infinite universe of
                  exploration, discovery, and adventure.
                </p>
                <p>
                  In this game, players embark on an
                  <a class="text" href="#">Epic Journey</a>
                  through a vast and ever-expanding multiverse of interconnected
                  worlds, each with its own unique challenges, mysteries, and
                  wonders.players have the opportunity to establish their own
                  thriving economies, trading goods and services with other
                  pioneers and NPCs (non-player characters). Whether they're
                  farming crops, crafting rare items, or running their own shops
                  and businesses, players can earn wealth and prestige in the
                  world of Pixel Pioneers.
                </p>
                <h3>Endless Exploration</h3>
                <p>
                  Players are free to chart their own course through the vast
                  expanse of the multiverse, uncovering hidden secrets, forging
                  alliances strange civilizations.
                </p>
                <p>
                  The narrative of Infinite Odyssey is shaped by the actions and
                  choices of the players, with branching storylines, dynamic
                  events, and emergent gameplay
                </p>
                <blockquote>
                  <p>
                    The universe of
                    <a class="text" href="#">"Infinite Odyssey"</a> is filled
                    with countless challenges and rewards for players to
                    discover. From hidden treasures and rare artifacts to epic
                    boss battles and world-altering events, there's always
                    something new and exciting waiting to be found.
                  </p>
                  <div class="author-name">
                    <span>Dr. Samuel Nathan</span>
                  </div>
                </blockquote>
              </div>
              <div class="mt-5">
                <a href="#" class="add-image">
                  <img src="images/Ads-Banner.png" alt="" />
                </a>
              </div>
              <div class="blog-tag">
                <div class="author-name">
                  <h6>
                    Posted by <a href="editor-profile.html"><?php echo htmlspecialchars($post['author']); ?></a>
                  </h6>
                </div>
                <div class="tag-items">
                  <h6>Categorized:</h6>
                  <ul>
                    <li><a href="life-style.html"><?php echo htmlspecialchars($post['category_name']); ?></a></li>
                  </ul>
                </div>
              </div>
              <div class="post-btn">
                <div class="privious-post-btn">
                  <a href="#"> PREVIOUS POST</a>
                </div>
                <div class="next-post-btn">
                  <a href="#"> NEXT POST</a>
                </div>
              </div>
              <div class="share-post-area">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="share-post-content">
                      <h3>Share This Post</h3>
                      <ul>
                        <li>
                          <a class="icon" href="https://www.facebook.com/">
                            <svg
                              width="6"
                              height="12"
                              viewBox="0 0 6 12"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M3.81526 11.2483V6.46735H5.42818L5.66793 4.59543H3.81526V3.4031C3.81526 2.86293 3.96576 2.4931 4.74101 2.4931H5.72334V0.824182C5.24538 0.77296 4.76495 0.748228 4.28426 0.750099C2.85859 0.750099 1.87976 1.62043 1.87976 3.21818V4.59193H0.277344V6.46385H1.88326V11.2483H3.81526Z"></path>
                            </svg>
                          </a>
                        </li>
                        <li>
                          <a class="icon" href="https://x.com/">
                            <svg
                              width="14"
                              height="14"
                              viewBox="0 0 14 14"
                              xmlns="http://www.w3.org/2000/svg">
                              <g>
                                <path
                                  d="M11.025 0.65625H13.1722L8.48225 6.0305L14 13.3438H9.68012L6.2965 8.9075L2.42462 13.3438H0.2765L5.29287 7.595L0 0.65625H4.43013L7.48825 4.71012L11.025 0.65625ZM10.2725 12.0557H11.4625L3.78262 1.87687H2.50688L10.2725 12.0557Z"></path>
                              </g>
                            </svg>
                          </a>
                        </li>
                        <li>
                          <a class="icon" href="https://www.linkedin.com/">
                            <svg
                              width="14"
                              height="14"
                              viewBox="0 0 14 14"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M2.90719 4.1972C3.61209 4.1972 4.18353 3.62576 4.18353 2.92086C4.18353 2.21597 3.61209 1.64453 2.90719 1.64453C2.20229 1.64453 1.63086 2.21597 1.63086 2.92086C1.63086 3.62576 2.20229 4.1972 2.90719 4.1972Z"></path>
                              <path
                                d="M5.38752 5.16523V12.2463H7.5861V8.74457C7.5861 7.82057 7.75994 6.92573 8.9056 6.92573C10.0355 6.92573 10.0495 7.98215 10.0495 8.8029V12.2469H12.2493V8.36365C12.2493 6.45615 11.8386 4.99023 9.60911 4.99023C8.53869 4.99023 7.82119 5.57765 7.52777 6.13357H7.49802V5.16523H5.38752ZM1.80469 5.16523H4.00677V12.2463H1.80469V5.16523Z"></path>
                            </svg>
                          </a>
                        </li>
                        <li>
                          <a class="icon" href="https://www.instagram.com/">
                            <svg
                              width="14"
                              height="14"
                              viewBox="0 0 14 14"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M12.2191 4.84492C12.2132 4.40312 12.1305 3.96571 11.9747 3.55226C11.8396 3.20351 11.6332 2.88679 11.3687 2.62233C11.1043 2.35786 10.7875 2.15147 10.4388 2.01634C10.0307 1.86313 9.59948 1.78029 9.16362 1.77134C8.60246 1.74626 8.42454 1.73926 7.00004 1.73926C5.57554 1.73926 5.39296 1.73926 4.83587 1.77134C4.40022 1.78036 3.96924 1.8632 3.56129 2.01634C3.21249 2.15138 2.89572 2.35773 2.63124 2.62221C2.36677 2.88669 2.16041 3.20346 2.02537 3.55226C1.87186 3.96008 1.7892 4.39116 1.78096 4.82684C1.75587 5.38859 1.74829 5.56651 1.74829 6.99101C1.74829 8.41551 1.74829 8.59751 1.78096 9.15517C1.78971 9.59151 1.87196 10.022 2.02537 10.4309C2.16064 10.7796 2.36715 11.0963 2.63171 11.3606C2.89628 11.625 3.21308 11.8313 3.56187 11.9663C3.96871 12.1256 4.39976 12.2144 4.83646 12.2288C5.39821 12.2538 5.57612 12.2614 7.00062 12.2614C8.42512 12.2614 8.60771 12.2614 9.16479 12.2288C9.60063 12.2202 10.0318 12.1375 10.44 11.9843C10.7886 11.8491 11.1053 11.6426 11.3697 11.3782C11.6341 11.1137 11.8406 10.7971 11.9759 10.4484C12.1293 10.0401 12.2115 9.60959 12.2203 9.17267C12.2454 8.61151 12.253 8.43359 12.253 7.00851C12.2518 5.58401 12.2518 5.40317 12.2191 4.84492ZM6.99654 9.68484C5.50671 9.68484 4.29979 8.47792 4.29979 6.98809C4.29979 5.49826 5.50671 4.29134 6.99654 4.29134C7.71176 4.29134 8.39769 4.57546 8.90343 5.0812C9.40917 5.58694 9.69329 6.27287 9.69329 6.98809C9.69329 7.70331 9.40917 8.38924 8.90343 8.89498C8.39769 9.40072 7.71176 9.68484 6.99654 9.68484ZM9.80062 4.82042C9.71802 4.8205 9.63622 4.80429 9.55989 4.77271C9.48356 4.74114 9.41421 4.69482 9.3558 4.63641C9.29739 4.57801 9.25108 4.50865 9.2195 4.43233C9.18793 4.356 9.17171 4.27419 9.17179 4.19159C9.17179 4.10905 9.18805 4.02732 9.21964 3.95106C9.25122 3.8748 9.29752 3.80551 9.35589 3.74714C9.41425 3.68878 9.48354 3.64248 9.5598 3.61089C9.63606 3.57931 9.71779 3.56305 9.80033 3.56305C9.88287 3.56305 9.96461 3.57931 10.0409 3.61089C10.1171 3.64248 10.1864 3.68878 10.2448 3.74714C10.3031 3.80551 10.3494 3.8748 10.381 3.95106C10.4126 4.02732 10.4289 4.10905 10.4289 4.19159C10.4289 4.53926 10.1477 4.82042 9.80062 4.82042Z"></path>
                              <path
                                d="M6.99589 8.73983C7.96336 8.73983 8.74764 7.95554 8.74764 6.98808C8.74764 6.02061 7.96336 5.23633 6.99589 5.23633C6.02843 5.23633 5.24414 6.02061 5.24414 6.98808C5.24414 7.95554 6.02843 8.73983 6.99589 8.73983Z"></path>
                            </svg>
                          </a>
                        </li>
                      </ul>
                      <div class="input-area" id="inviteCode">
                        <input
                          id="link-input"
                          value="https://www.egenstheme.com/"
                          readonly="" />
                        <div id="copy-link-icon">
                          <svg
                            width="16"
                            height="16"
                            viewBox="0 0 16 16"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                              fill-rule="evenodd"
                              clip-rule="evenodd"
                              d="M6.97324 10.9956C6.99524 11.0066 7.02724 11.0066 7.02724 11.0066V11.0286C7.06024 11.0286 7.12424 10.9846 7.12424 10.9846L8.29028 9.82042L8.32328 9.78845C8.35314 9.76404 8.37852 9.73462 8.39828 9.70151C8.42028 9.65854 8.43028 9.61457 8.40828 9.5716C8.38828 9.52863 8.35528 9.48566 8.31228 9.48566C7.87035 9.39014 7.46545 9.1691 7.14624 8.84912C6.76572 8.47567 6.53189 7.97821 6.48723 7.44712C6.45456 7.1118 6.49673 6.77341 6.61069 6.45634C6.72464 6.13926 6.90755 5.85138 7.14624 5.61343L10.2003 2.55962C11.0634 1.69624 12.5744 1.69624 13.4384 2.55962C13.8704 3.0023 14.1084 3.57389 14.1084 4.18845C14.1084 4.80301 13.8704 5.3856 13.4384 5.81729L12.0464 7.1983C12.0306 7.21556 12.0193 7.23645 12.0136 7.25912C12.0078 7.28178 12.0077 7.30551 12.0134 7.32821C12.1434 7.79088 12.2184 8.27653 12.2184 8.76218C12.2184 8.99901 12.2084 9.20387 12.1754 9.37674C12.1754 9.4307 12.1974 9.49566 12.2514 9.51664C12.2768 9.532 12.3066 9.53828 12.3361 9.53447C12.3655 9.53066 12.3928 9.51697 12.4134 9.49566L14.7775 7.14434C16.4075 5.50451 16.4075 2.85041 14.7775 1.22158C13.9921 0.43928 12.9283 0 11.8194 0C10.7104 0 9.6467 0.43928 8.86129 1.22158L5.80721 4.27539C5.5372 4.5452 5.32219 4.83699 5.16019 5.12778L5.14719 5.13778C5.13719 5.14577 5.12718 5.15276 5.12718 5.15976C4.79591 5.74751 4.61115 6.40632 4.58852 7.0805C4.56589 7.75467 4.70606 8.42438 4.99718 9.03299C5.20319 9.45269 5.46219 9.83042 5.80721 10.1762C6.14221 10.5209 6.54123 10.8017 6.97324 10.9956ZM1.23107 14.7709C2.0501 15.5803 3.12013 15.99 4.18816 15.99L4.15616 16C5.22419 16 6.30422 15.5903 7.11424 14.7819L10.1683 11.7291C10.727 11.1773 11.1165 10.4777 11.2914 9.7125L11.3564 9.23784C11.3774 9.12992 11.3774 9.02199 11.3774 8.91407V8.48338C11.3774 8.37446 11.3674 8.26654 11.3454 8.1806C11.3354 8.06168 11.3134 7.96475 11.2914 7.86782C11.2664 7.74735 11.234 7.62854 11.1944 7.51208C11.0008 6.87575 10.652 6.29748 10.1793 5.82928C9.84282 5.49624 9.45228 5.22256 9.0243 5.01986C8.9813 4.98788 8.87329 5.04184 8.87329 5.04184L7.70726 6.20601C7.67526 6.23899 7.63226 6.28196 7.59926 6.34591C7.57826 6.37889 7.57826 6.42186 7.59926 6.46582C7.62126 6.50879 7.65326 6.54077 7.69626 6.54077C8.13927 6.62671 8.53828 6.84256 8.86229 7.16632C9.29431 7.60901 9.53231 8.19159 9.52131 8.82713C9.51031 9.21685 9.41331 9.59359 9.2293 9.91635C9.17794 10.0094 9.11658 10.0965 9.0463 10.1762C9.0033 10.2411 8.9493 10.3161 8.86229 10.402L5.80721 13.4548C5.37361 13.8759 4.79279 14.1115 4.18816 14.1115C3.58352 14.1115 3.00271 13.8759 2.56911 13.4548C2.13942 13.0215 1.89858 12.436 1.89909 11.826C1.89909 11.2114 2.1371 10.6288 2.56911 10.1972L3.96215 8.80615C3.99415 8.76318 4.00515 8.70922 3.99415 8.66625C3.77779 8.01315 3.71483 7.31903 3.81015 6.6377C3.81488 6.60938 3.81008 6.58029 3.79651 6.55498C3.78294 6.52966 3.76136 6.50956 3.73515 6.4978C3.69214 6.46483 3.58414 6.51879 3.58414 6.51879L1.23007 8.85911C0.838368 9.24512 0.527785 9.70543 0.316558 10.213C0.105332 10.7206 -0.00228147 11.2653 3.66695e-05 11.815C3.66695e-05 12.9252 0.44305 13.9834 1.23007 14.7699L1.23107 14.7709Z"></path>
                          </svg>
                        </div>
                        <span id="copy-text" class="copy-text"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="comment-area mb-60">
                    <div class="comment-title">
                      <h4>Comments (02)</h4>
                    </div>
                    <ul class="comment">
                      <li>
                        <div class="single-comment-area">
                          <div class="author-img">
                            <img src="images/comment-img1.png" alt="" />
                          </div>
                          <div class="comment-content">
                            <div class="author-name-deg">
                              <h6>Mr. Bowmik Haldar,</h6>
                              <span>02 March, 2024</span>
                            </div>
                            <p>Great! Have to learn more.</p>
                            <div class="replay-btn">
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="14"
                                height="11"
                                viewBox="0 0 14 11">
                                <path
                                  d="M8.55126 1.11188C8.52766 1.10118 8.50182 1.09676 8.47612 1.09903C8.45042 1.1013 8.42569 1.11018 8.40419 1.12486C8.3827 1.13954 8.36513 1.15954 8.35311 1.18304C8.34109 1.20653 8.335 1.23276 8.33539 1.25932V2.52797C8.33539 2.67388 8.2791 2.81381 8.17889 2.91698C8.07868 3.02016 7.94277 3.07812 7.80106 3.07812C7.08826 3.07812 5.64984 3.08362 4.27447 3.98257C3.2229 4.66916 2.14783 5.9191 1.50129 8.24735C2.59132 7.16575 3.83632 6.57929 4.92635 6.2679C5.59636 6.07737 6.28492 5.96444 6.97926 5.93121C7.26347 5.91835 7.54815 5.92129 7.83205 5.94001H7.84594L7.85129 5.94111L7.80106 6.48906L7.85449 5.94111C7.98638 5.95476 8.10864 6.01839 8.19751 6.11966C8.28638 6.22092 8.33553 6.35258 8.33539 6.48906V7.75771C8.33539 7.87654 8.45294 7.95136 8.55126 7.90515L12.8088 4.67796C12.8233 4.66692 12.8383 4.65664 12.8537 4.64715C12.8769 4.63278 12.8962 4.61245 12.9095 4.58816C12.9229 4.56386 12.9299 4.53643 12.9299 4.50851C12.9299 4.4806 12.9229 4.45316 12.9095 4.42887C12.8962 4.40458 12.8769 4.38425 12.8537 4.36988C12.8382 4.36039 12.8233 4.35011 12.8088 4.33907L8.55126 1.11188ZM7.26673 7.02381C7.19406 7.02381 7.11391 7.02711 7.02842 7.03041C6.56462 7.05242 5.92342 7.12504 5.21169 7.32859C3.79464 7.7335 2.11684 8.65116 1.00115 10.7175C0.940817 10.8291 0.844683 10.9155 0.729224 10.9621C0.613765 11.0087 0.486168 11.0124 0.368304 10.9728C0.250441 10.9331 0.149648 10.8525 0.0831985 10.7447C0.0167484 10.6369 -0.011219 10.5086 0.0040884 10.3819C0.499949 6.29981 2.01959 4.15202 3.70167 3.05391C5.03215 2.18467 6.40218 2.01743 7.26673 1.98552V1.25932C7.26663 1.03273 7.32593 0.810317 7.43839 0.615545C7.55084 0.420773 7.71227 0.260866 7.90565 0.152696C8.09902 0.0445258 8.31717 -0.00789584 8.53707 0.000962485C8.75698 0.00982081 8.97048 0.0796305 9.15506 0.203025L13.4233 3.43792C13.5998 3.55133 13.7453 3.7091 13.8462 3.8964C13.9471 4.08369 14 4.29434 14 4.50851C14 4.72269 13.9471 4.93333 13.8462 5.12063C13.7453 5.30792 13.5998 5.4657 13.4233 5.57911L9.15506 8.814C8.97048 8.9374 8.75698 9.00721 8.53707 9.01607C8.31717 9.02492 8.09902 8.9725 7.90565 8.86433C7.71227 8.75616 7.55084 8.59626 7.43839 8.40148C7.32593 8.20671 7.26663 7.9843 7.26673 7.75771V7.02381Z"></path>
                              </svg>
                              Reply (01)
                            </div>
                          </div>
                        </div>
                        <ul class="comment-replay">
                          <li>
                            <div class="single-comment-area">
                              <div class="author-img">
                                <img src="images/comment-img2.png" alt="" />
                              </div>
                              <div class="comment-content">
                                <div class="author-name-deg">
                                  <h6>Jacoline Juie,</h6>
                                  <span>05 March, 2024</span>
                                </div>
                                <p>Take Love Brothers!</p>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <div class="single-comment-area">
                          <div class="author-img">
                            <img src="images/comment-img3.png" alt="" />
                          </div>
                          <div class="comment-content">
                            <div class="author-name-deg">
                              <h6>Mr. Bowmik Haldar,</h6>
                              <span>02 March, 2024</span>
                            </div>
                            <p>Masterclass article!</p>
                            <div class="replay-btn">
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="14"
                                height="11"
                                viewBox="0 0 14 11">
                                <path
                                  d="M8.55126 1.11188C8.52766 1.10118 8.50182 1.09676 8.47612 1.09903C8.45042 1.1013 8.42569 1.11018 8.40419 1.12486C8.3827 1.13954 8.36513 1.15954 8.35311 1.18304C8.34109 1.20653 8.335 1.23276 8.33539 1.25932V2.52797C8.33539 2.67388 8.2791 2.81381 8.17889 2.91698C8.07868 3.02016 7.94277 3.07812 7.80106 3.07812C7.08826 3.07812 5.64984 3.08362 4.27447 3.98257C3.2229 4.66916 2.14783 5.9191 1.50129 8.24735C2.59132 7.16575 3.83632 6.57929 4.92635 6.2679C5.59636 6.07737 6.28492 5.96444 6.97926 5.93121C7.26347 5.91835 7.54815 5.92129 7.83205 5.94001H7.84594L7.85129 5.94111L7.80106 6.48906L7.85449 5.94111C7.98638 5.95476 8.10864 6.01839 8.19751 6.11966C8.28638 6.22092 8.33553 6.35258 8.33539 6.48906V7.75771C8.33539 7.87654 8.45294 7.95136 8.55126 7.90515L12.8088 4.67796C12.8233 4.66692 12.8383 4.65664 12.8537 4.64715C12.8769 4.63278 12.8962 4.61245 12.9095 4.58816C12.9229 4.56386 12.9299 4.53643 12.9299 4.50851C12.9299 4.4806 12.9229 4.45316 12.9095 4.42887C12.8962 4.40458 12.8769 4.38425 12.8537 4.36988C12.8382 4.36039 12.8233 4.35011 12.8088 4.33907L8.55126 1.11188ZM7.26673 7.02381C7.19406 7.02381 7.11391 7.02711 7.02842 7.03041C6.56462 7.05242 5.92342 7.12504 5.21169 7.32859C3.79464 7.7335 2.11684 8.65116 1.00115 10.7175C0.940817 10.8291 0.844683 10.9155 0.729224 10.9621C0.613765 11.0087 0.486168 11.0124 0.368304 10.9728C0.250441 10.9331 0.149648 10.8525 0.0831985 10.7447C0.0167484 10.6369 -0.011219 10.5086 0.0040884 10.3819C0.499949 6.29981 2.01959 4.15202 3.70167 3.05391C5.03215 2.18467 6.40218 2.01743 7.26673 1.98552V1.25932C7.26663 1.03273 7.32593 0.810317 7.43839 0.615545C7.55084 0.420773 7.71227 0.260866 7.90565 0.152696C8.09902 0.0445258 8.31717 -0.00789584 8.53707 0.000962485C8.75698 0.00982081 8.97048 0.0796305 9.15506 0.203025L13.4233 3.43792C13.5998 3.55133 13.7453 3.7091 13.8462 3.8964C13.9471 4.08369 14 4.29434 14 4.50851C14 4.72269 13.9471 4.93333 13.8462 5.12063C13.7453 5.30792 13.5998 5.4657 13.4233 5.57911L9.15506 8.814C8.97048 8.9374 8.75698 9.00721 8.53707 9.01607C8.31717 9.02492 8.09902 8.9725 7.90565 8.86433C7.71227 8.75616 7.55084 8.59626 7.43839 8.40148C7.32593 8.20671 7.26663 7.9843 7.26673 7.75771V7.02381Z"></path>
                              </svg>
                              Reply (01)
                            </div>
                          </div>
                        </div>
                        <ul class="comment-replay two">
                          <li>
                            <div class="single-comment-area">
                              <div class="author-img">
                                <img src="images/comment-img2.png" alt="" />
                              </div>
                              <div class="comment-content">
                                <div class="author-name-deg">
                                  <h6>Jacoline Juie,</h6>
                                  <span>05 March, 2024</span>
                                </div>
                                <p>Take Love Brothers!</p>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="inquiry-form">
                    <div class="title">
                      <h4>Leave Your Comment:</h4>
                    </div>
                    <form>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-inner mb-20">
                            <label>Your Name* :</label>
                            <input type="text" placeholder="Jackson Mile" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-inner mb-20">
                            <label>Your Email* :</label>
                            <input
                              type="email"
                              placeholder="example@gamil.com" />
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-inner mb-15">
                            <label>Your Comments*</label>
                            <textarea
                              placeholder="Write Something..."></textarea>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="checkbox"
                              value=""
                              id="contactCheck" />
                            <label class="form-check-label" for="contactCheck">
                              Please save my name, email address for the next
                              time I comment.
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-inner">
                        <button
                          class="primary-btn1"
                          data-text="Post Comment"
                          type="submit">
                          <span>
                            <svg
                              class="arrow"
                              width="10"
                              height="10"
                              viewBox="0 0 10 10"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9"
                                stroke="#191919"
                                stroke-width="1.5"
                                stroke-linecap="round"></path>
                            </svg>
                            SUBMIT COMMENT</span
                          >
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
          <div class="life-style-sidebar">
            <div class="sidebar-widget featured-post">
              <h6>Featured Post</h6>
              <?php foreach($feature_posts as $feature_post): ?>
              <div class="recent-post mb-20">
                <div class="recent-post-img">
                  <a href="standard-formate.html"
                    ><img src="<?php echo str_repeat('../', substr_count($feature_post['image'], '/')) . 'images/' . basename($feature_post['image']); ?>" alt=""
                  /></a>
                </div>
                <div class="recent-post-content">
                  <a href="life-style.html"><?php echo date('d F Y', strtotime($feature_post['created_at'])); ?></a>
                  <h5>
                    <a href="standard-formate.html"
                      ><?php echo htmlspecialchars($feature_post['title']); ?></a
                    >
                  </h5>
                </div>
              </div>
              <?php endforeach; ?>
              <!-- <div class="recent-post mb-20">
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
              </div> -->
            </div>
          </div>
          <div class="sidebar-widget discover-post mt-5">
            <h6 class="discover-title">
              Discover By Tags
              <svg
                class="arrow"
                width="10"
                height="10"
                viewBox="0 0 10 10"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9"
                  stroke="white"
                  stroke-width="1.5"
                  stroke-linecap="round"></path>
              </svg>
            </h6>
            <ul class="category">
              <li>
                <a href="life-style.html">Beauty (10)</a>
              </li>
              <li>
                <a href="life-style.html">Gaming Tips (05)</a>
              </li>
              <li>
                <a href="life-style.html">Fashion (02)</a>
              </li>
              <li>
                <a href="life-style.html">Tech (03)</a>
              </li>
              <li>
                <a href="life-style.html">Parenting (03)</a>
              </li>
              <li>
                <a href="life-style.html">Health (03)</a>
              </li>
              <li>
                <a href="life-style.html">Events (04)</a>
              </li>
              <li>
                <a href="life-style.html">Art (03)</a>
              </li>
              <li>
                <a href="life-style.html">Food (06)</a>
              </li>
              <li>
                <a href="life-style.html">Travel (02)</a>
              </li>
            </ul>
          </div>
          <div class="add-image">
            <img src="images/Sidebar-ads.png" alt="" />
          </div>
        </div>
      </div>
    </div>
    <footer class="mt-5">
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
