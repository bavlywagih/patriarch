<?php

$filename = basename($_SERVER['PHP_SELF']);

$activeHome = $filename ===  "index.php";
$activeLogin = $filename ===  "login-page.php";
$activeSignup = $filename ===  "signup.php";



// $activeContent = $currentPageURL === $baseUrl  . "gates-jerusalem.php";

// if (isset($_GET["add"])) {
//     $url_addPage = "";
//     if ($_GET["add"] == "verse") {
//         $url_addPage = "verse";
//     }
//     if ($_GET["add"] == "page") {
//         $url_addPage = "page";
//     }
//     if ($_GET["add"] == "manyverse") {
//         $url_addPage = "manyverse";
//     }
//     $activeaddPage = $currentPageURL === $baseUrl  . "add-pages.php?add=" . $url_addPage;
// }

// $activelogin = $currentPageURL === $baseUrl  . "login.php";
// $activesignup = $currentPageURL === $baseUrl  . "signup.php";

// if (isset($_GET["search"])) {
//     $activeSearch = $currentPageURL === $baseUrl  . "search.php?search=" . $_GET['search'];
// } else {
//     $activeSearch = ' ';
// }
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="">الاباء البطاركه</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="navLinks">
                <li class="nav-item">
                    <a class="nav-link <?= $activeHome ? 'active' : '' ?>" aria-current="page" href="/patriarch/index.php">الصفحة الرئيسية</a>
                </li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item"> <a class="nav-link " href="index.php">الاباء البطاركة</a></li>';
                } else { ?>
                    <li class="nav-item" id="loginNavItem"><a class="nav-link <?= $activeLogin ? 'active' : '' ?>" href="login-page.php">تسجيل الدخول</a></li>
                    <li class="nav-item" id="signinNavItem"><a class="nav-link <?= $activeSignup ? 'active' : '' ?>" href="signup.php">انشاء حساب</a></li>
                <?php }
                ?>
            </ul>

            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <i class="fa-solid fa-moon p-2" id="theme-toggle" style="cursor: pointer;"></i>
        </div>
    </div>
</nav>