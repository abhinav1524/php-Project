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

if ($postId) {
    // Fetch the post data from the database
    $join = "LEFT JOIN categories c ON posts.category_id = c.id";
    $post = $db->getData('posts', $join, 'posts.*,c.name AS category_name', "WHERE posts.id = $postId");
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
// function to get avatar //
function generateRandomAvatar($hash) {
    // Use gravatar hash if available or generate a random URL
    $gravatarUrl = "https://www.gravatar.com/avatar/{$hash}?d=mp&s=100";
    return $gravatarUrl;
}

$comments = $db->getData("comment","WHERE post_id = $postId");
$groupedComments = [];
if (!empty($comments)) {
    foreach ($comments as $comment) {
        $groupedComments[$comment['parent_id']][] = $comment;
    }
}

// Recursive function to render nested comments
function renderComments($parentId, $groupedComments, $isReply = false) {
    if (!isset($groupedComments[$parentId])) {
        return;
    }
    // Start the unordered list
    echo $isReply ? '<ul class="comment-replay" data-parent-id="' . htmlspecialchars($parentId) . '">' : '<ul class="comment">';
    $post_id = $_GET['id'] ?? null;
    $userName="";
    $userEmail="";
    $isLoggedIn = isset($_SESSION['user']);
    $isOwner="";
    foreach ($groupedComments[$parentId] as $comment) {
        ?>
        <li>
            <div class="single-comment-area">
                <div class="author-img">
                  <?php
                  if (isset($_SESSION['user'])) {
                      $userEmail = $_SESSION['user']['email'];
                      $avatarUrl = generateRandomAvatar(md5($userEmail)); // Generate the avatar.
                      echo "<img src='{$avatarUrl}' alt='User Avatar'/>";
                          $currentUserId = $_SESSION['user']['id'];
                          $isOwner = $comment['user_id'] == $currentUserId;
                  }
                  ?>
                </div>
                <div class="comment-content">
                    <div class="author-name-deg">
                        <h6><?php echo htmlspecialchars($comment['name']); ?>,</h6>
                        <span><?php echo date('d F Y', strtotime($comment['created_at'])); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p><?php echo htmlspecialchars($comment['comment']); ?>.</p>
                        <?php if ($isOwner): ?>
                        <div class="button_container">
                          <button class="repy_edit" data-comment-id="<?php echo htmlspecialchars($comment['id']); ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                          <button class="reply_delete" data-comment-id="<?php echo htmlspecialchars($comment['id']); ?>"><i class="fa-solid fa-trash"></i></button>
                        </div>
                      <?php endif; ?>
                </div>
                    <?php if ($isLoggedIn): ?>
                    <div class="replay-btn">
                        <button class="reply-btn" data-comment-id="<?php echo htmlspecialchars($comment['id']); ?>">Reply</button>
                    </div>
                    <?php endif; ?>
                    <div class="reply-form-container" style="display: none;" data-comment-id="<?php echo htmlspecialchars($comment['id']); ?>">
                          <?php
                      if (isset($_SESSION['user'])) {
                          $userName = $_SESSION['user']['name'];
                          $userEmail = $_SESSION['user']['email'];
                      }
                      ?>
                      <form method="post" action="comment/comment.php">
                      <input type="hidden" id="name" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>"/>
                      <input type="hidden" id="userName" name="userName" value="<?php echo htmlspecialchars($userName); ?>"/>
                      <input type="hidden" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($userEmail); ?>"/>
                      <input type="hidden"id="parent_id" name="parent_id" value="<?php echo htmlspecialchars($comment['id']); ?>"/>
                      <textarea class="reply" id="reply" name="reply" placeholder="Write your reply..."></textarea>
                      <button type="submit" class="submit-reply-btn" id="submitForm" name="submitReply" value="true"><i class="fa-solid fa-paper-plane"></i></button>
                      </form>
                    </div>
                    <div class="update-form-container" style="display: none;" data-comment-id="<?php echo htmlspecialchars($comment['id']); ?>">
                      <form method="post" action="comment/comment.php">
                          <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                          <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
                          <input type="hidden" name="userName" value="<?php echo htmlspecialchars($userName); ?>">
                          <input type="hidden" name="userEmail" value="<?php echo htmlspecialchars($userEmail); ?>">
                          <input type="hidden" name="parent_id" value="<?php echo htmlspecialchars($comment['parent_id']?? null); ?>">
                          <textarea class="reply" name="updated_comment" placeholder="Edit your comment"><?php echo htmlspecialchars($comment['comment']); ?></textarea>
                          <button type="submit" class="submit-reply-btn" name="updateReplyComment" value="true"><i class="fa-solid fa-paper-plane"></i></</button>
                      </form>
                    </div>
                </div>
            </div>
            <?php
            // Recursively render child comments
            renderComments($comment['id'], $groupedComments, true);
            ?>
        </li>
        <?php
    }

    // Close the unordered list
    echo '</ul>';
}
// tracking user activity //
$action = "Visited Blog Post ID: $postId";
recordUserActivity($action);
// Function to record user activity
function recordUserActivity($action) {
  $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
  $db =new Database();
  $tableName="user_activity";
  $data=[
    "user_id"=>$userId??null,
    "action"=>$action
  ];
    $result=$db->insert($tableName,$data);
    if ($result !== true) {
        error_log("Error inserting user activity: $result"); // Log error
        return "An error occurred while recording your activity. Please try again.";
    }
    exit();
}
// Fetch previous and next post IDs
$prevArr = $db->getData('posts', '', 'id', "WHERE id < $postId ORDER BY id DESC LIMIT 1");
$nextArr = $db->getData('posts', '', 'id', "WHERE id > $postId ORDER BY id ASC LIMIT 1");
$prev = $prevArr[0]['id'] ?? null;
$next = $nextArr[0]['id'] ?? null;
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
                <!-- <blockquote>
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
                </blockquote> -->
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
                  <?php if ($prev): ?>
                  <a href="standard.php?id=<?php echo $prev ?>"> PREVIOUS POST</a>
                  <?php else: ?>
                    <a href="#" disabled> PREVIOUS POST</a>
                  <?php endif; ?>
                </div>
                <div class="next-post-btn">
                  <?php if ($next): ?>
                  <a href="standard.php?id=<?php echo $next ?>"> NEXT POST</a>
                  <?php else: ?>
                  <a href="#" disabled> NEXT POST</a>
                  <?php endif; ?>
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
                          id="postLink"
                          value=""
                          readonly="" />
                        <button type="button" id="copyPostLink">
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
                        </button>
                        <span  class="copy-text"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="comment-area mb-60">
                    <div class="comment-title">
                      <h4>Comments (<?php echo (count($comments) < 9 ? '0' : '') . count($comments); ?>)</h4>
                    </div>
                    <ul class="comment">
                     <?php renderComments(null, $groupedComments); ?>
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
                    <?php if ($isLoggedIn): ?>
                    <form method="post" action="comment/comment.php">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-inner mb-20">
                            <label>Your Name* :</label>
                            <input type="text" name="name" placeholder="Jackson Mile" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-inner mb-20">
                            <label>Your Email* :</label>
                            <input
                              type="email"
                              name="email"
                              placeholder="example@gamil.com" />
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-inner mb-15">
                            <label>Your Comments*</label>
                            <textarea
                              name="comment"
                              placeholder="Write Something..."></textarea>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-inner mb-15">
                            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($postId); ?>">
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
                          type="submit"
                          name="insert" 
                          value="true"
                          >
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
                      <?php else: ?>
                      <p>Please <a href="login.php">log in</a> to post a comment.</p>
                  <?php endif; ?>
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
                    <a href="standard.php?id=<?php echo $feature_post['id']; ?>"
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
    <script>
      function getPostIdFromUrl() {
      var urlParams = new URLSearchParams(window.location.search);
      var postId = urlParams.get('id');
      return postId;
      }
      function updatePostLink() {
        var postId = getPostIdFromUrl(); // Example post ID, you can capture this dynamically based on the post
        var postLink = `http://localhost/Blog/standard.php?id=${postId}`;
        document.getElementById('postLink').value = postLink;
      }

      // Call the function when the page loads or on relevant event
      updatePostLink();
      document.getElementById('copyPostLink').addEventListener('click', function() {
      var postLink = document.getElementById('postLink').value;
      navigator.clipboard.writeText(postLink).then(function() {
        alert('Link copied to clipboard!');
      }).catch(function(err) {
        console.error('Failed to copy: ', err);
      });
    });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.6/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
  </body>
</html>
