<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ./pages/login.php');
    exit;
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
        <link rel="stylesheet" href="./assets/css/styles.css" />
        <title>Home | Rezo</title>
    </head>
    <body>
        <?php
            echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "!";
            echo '<br><a href="./pages/logout.php">Logout</a>';
        ?>
        <div class="topBar">
            <a href="/">
                <img class="logo" src="" alt="" />
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
    </body>
</html>