<!-- TODO: Add the home page and style it -->
<!-- TODO: Add responsive for login and register pages -->

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
                echo "<p>You are not logged in. <a href=\"/login\">Login here</a></p>";
            }
        ?>
        <div class="topBar">
            <a href="/">
                <div class="logo">
                    <img src="./assets/img/logoText.png" alt="Rezo logo" />
                </div>
            </a>
            <form action="/">
                <input class="searchBar" type="text" placeholder="Explore">
                    <svg class="searchBarIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="#6390AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hash"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>
                </input>
            </form>
            <nav>
                <ul>
                    <li class="link selected"><a href="/"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 42 42"><path fill="#6390AF" d="M2.68 15.726c-.1.039-.16.09-.18.149l.18-.149zm-.18.149v20.627c0 2.509.49 2.998 3 2.998h7c2.51 0 3-.461 3-3v-8h9v8.031c0 2.51.51 2.979 3 2.969c.04.031 7 0 7 0c2.529 0 3-.526 3-2.997V16.495c0-.08-.09-.15-.27-.23L20 1.5L2.68 15.726l-.18.149z"/></svg>Home</a></li>
                    <li class="link"><a href="/messages"></a></li>
                    <li class="link"><a href="/notifications"></a></li>
                    <li class="link"><a href="/bookmarks"></a></li>
                </ul>
            </nav>
            <div class="navAccount"></div>
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