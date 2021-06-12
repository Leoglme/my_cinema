<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    <title>MyCinéma</title>
    <!-- Loading third party fonts -->
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/b574b73ebd.js" crossorigin="anonymous"></script>
    <script src="public/script/pagination.js"></script>
    <link rel="stylesheet" href="public/style.css">
</head>


<body>
<?php require 'private/autoloader.php';
Autoloader::__autoload(array("genre", "DbConnect", "cinemaAPI", "searchClass"));
$db = Database::connect();
$genre = new genre($db);
$poster = new cinemaAPI('3b9d3c2d');
$search = new searchResult($db, "inputSearch", "film", array("titre", "annee_prod"), "annee_prod");
?>

<div id="site-content">
    <header class="site-header">
        <div class="container">
            <a href='<?= 'http://' . $_SERVER["HTTP_HOST"] . '/myCinema/' ?>' id="branding">
                <img src="public/assets/images/logo.png" alt="" class="logo">
                <div class="logo-copy">
                    <h1 class="site-title">My Cinema</h1>
                    <small class="site-description">PROJET</small>
                </div>
            </a>

            <div class="main-navigation">
                <nav style="display: flex; justify-content: center;" class="navbar navbar-light bg-light">
                    <form class="form-inline" method="post">
                        <input name="inputSearch" type="search" placeholder="Search" aria-label="Search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                        <button><a href="admin" style="color: #84878d"><i class="fas fa-user"></i>  Admin Access</a> </button>
                    </form>
                </nav>

            </div>

            <div class="mobile-navigation"></div>
        </div>
    </header>
    <main class="main-content">
        <div class="container">
            <div class="page">
                <div class="breadcrumbs">
                    <a href='<?= 'http://' . $_SERVER["HTTP_HOST"] . '/myCinema/' ?>'>Home</a>
                    <span>Movie Review</span>
                </div>

                <div class="filters">
                    <form method="get">
                        <label for="#"></label><select name="category" id="#" onchange="submit()">
                            <option selected><?php $genre->getCategory();
                                echo $_GET["category"] ?></option>
                            <?php foreach ($genre->getCategory() as $value) {
                                echo '<option>' . $value . '</option>';
                            } ?>
                        </select>
                        <select name="date" id="#" onchange="submit()">
                            <p>(Choose Date)</p>
                            <option selected><?php $genre->getDate();
                                echo $_GET['date'] ?></option>
                            <?php foreach ($genre->getDate() as $value) {
                                echo '<option>' . $value . '</option>';
                            } ?>
                        </select>

                        <select name="distrib" id="#" onchange="submit()">
                            <p>(Choose Date)</p>
                            <option selected><?php $genre->getDistributor();
                                echo $_GET['distrib'] ?></option>
                            <?php foreach ($genre->getDistributor() as $value) {
                                echo '<option>' . $value . '</option>';
                            } ?>
                        </select>
                    </form>
                </div>


                <div class="movie-list">
                    <?php if ($_POST['inputSearch'] === false): ?>
                    <?php foreach ($genre->affiche() as $film) {
                        echo '<div class="movie">
                                        <figure class="movie-poster"><img src="' . $poster->getPoster('' . $film["titre"] . '') . '" alt="#"></figure>
                                        <div class="movie-title"><a href="single.html">' . $film["titre"] . '</a></div>
                                        <p>' . $film["resum"] . '</p>
                                        <p>Category: ' . $film["nom"] . '</p> 
                                        <p>Date: ' . $film["annee_prod"] . '</p>
                              </div>';

                    }
                    ?>
                    <?php endif; ?>

                    <?php if ($_POST['inputSearch'] !== false): ?>
                        <?php foreach ($search->affiche()  as $film) {
                            echo '<div class="movie">
                                        <figure class="movie-poster"><img src="' . $poster->getPoster('' . $film["titre"] . '') . '" alt="#"></figure>
                                        <div class="movie-title"><a href="single.html">' . $film["titre"] . '</a></div>
                                        <p>' . $film["resum"] . '</p>
                                        <p>Category:</p> 
                                        <p>Date: ' . $film["annee_prod"] . '</p>
                              </div>';

                        }
                        ?>
                    <?php endif; ?>
                </div>
                <div class="pagination">
                    <script>
                        let nbrPages = <?php echo $genre->pagesTotales; ?>;
                        let nameClass = "<?php echo 'pagination' ?>";
                        let pageCourante = <?php echo $_GET["page"] ?>;
                        let myURL = "<?php echo '?category='.$_GET["category"].'&date='.$_GET["date"].'&distrib='.$_GET["distrib"].'&page='?>";
                        newPagination(nbrPages, pageCourante, nameClass, myURL)
                    </script>
                    <?php Database::disconnect(); ?>
                </div>
            </div>
        </div>
    </main>
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="widget">
                        <h3 class="widget-title">About Us</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia tempore vitae mollitia
                            nesciunt saepe cupiditate</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="widget">
                        <h3 class="widget-title">Recent Review</h3>
                        <ul class="no-bullet">
                            <li>Lorem ipsum dolor</li>
                            <li>Sit amet consecture</li>
                            <li>Dolorem respequem</li>
                            <li>Invenore veritae</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="widget">
                        <h3 class="widget-title">Help Center</h3>
                        <ul class="no-bullet">
                            <li>Lorem ipsum dolor</li>
                            <li>Sit amet consecture</li>
                            <li>Dolorem respequem</li>
                            <li>Invenore veritae</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="widget">
                        <h3 class="widget-title">Join Us</h3>
                        <ul class="no-bullet">
                            <li>Lorem ipsum dolor</li>
                            <li>Sit amet consecture</li>
                            <li>Dolorem respequem</li>
                            <li>Invenore veritae</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="widget">
                        <h3 class="widget-title">Social Media</h3>
                        <ul class="no-bullet">
                            <li>Facebook</li>
                            <li>Twitter</li>
                            <li>Google+</li>
                            <li>Pinterest</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="widget">
                        <h3 class="widget-title">Newsletter</h3>
                        <form action="#" class="subscribe-form">
                            <input type="text" placeholder="Email Address">
                        </form>
                    </div>
                </div>
            </div> <!-- .row -->

            <div class="colophon">© COPYRIGHT 2020 LÉO  MYCINÉMA - PROJET</div>
        </div>

    </footer>
</div>
</body>

</html>