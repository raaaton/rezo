<!-- TODO: Add responsive for login and register pages -->
<!-- TODO: Add the home page and style it -->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require __DIR__ . '/assets/php/auth-check.php';

if ($_SERVER['REQUEST_URI'] === '/index.php') {
    header("Location: /home", true, 301);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- "Add to home screen" support -->
        <link rel="manifest" href="/manifest.json" />
        <meta name="msapplication-TileColor" content="#05141C" />
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png" />
        <meta name="theme-color" content="#05141C" />
        <!--  -->
        <link rel="icon" type="image/png" href="./assets/img/logo.png" />
        <link rel="stylesheet" href="./assets/css/main.css" />
        <link rel="stylesheet" href="./assets/css/loader.css" />
        <title>Home | Rezo</title>
    </head>
    <body>
        <?php
            if (isset($user) && isset($user['username'])) {
                echo "<p>Welcome, " . htmlspecialchars($user['username']) . "!<br><a href=\"./assets/php/logout.php\">Logout</a></p>";
            } else {
                echo "<p>You are not logged in. <a href=\"./pages/login.php\">Login here</a></p>";
            }
        ?>
        <div class="topBar">
            <a href="/">
                <img class="logo" src="./assets/img/logoText.png" alt="Rezo logo" />
            </a>
            <div class="search"></div>
            <nav>
                <ul></ul>
            </nav>
            <div class="NavAccount"></div>
        </div>
        <aside class="aboutAccount">
            <div class="aboutMyAccount"></div>
            <div class="accountsRecommended"></div>
        </aside>
        <main>
            <div class="newPost"></div>
            <div class="posts">
                <!-- Content generated automatically -->
            </div>
        </main>
        <aside class="trendsForYou"></aside>
        <footer></footer>

        <div class="loader"></div>

        <script src="/assets/js/script.js"></script>

        <!-- "Add to home screen" support -->
        <script type="text/javascript">
            if ("serviceWorker" in navigator) {
                console.log("Service worker registering...");
                navigator.serviceWorker
                    .register("./assets/js/service-worker.js")
                    .then(function (reg) {
                        console.log("Service worker successfully registered!");
                    })
                    .catch(function (err) {
                        console.error(
                            "Service worker didn't register properly. This happened:",
                            err
                        );
                    });
            }
        </script>
        <!--  -->
        <script src="/assets/js/loader.js"></script>
        <script src="/assets/js/auth-restore.js" defer></script>
    </body>
</html>