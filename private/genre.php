<?php
/* CLASS SEARCH BY FILTER */
//require 'autoloader.php';
//Autoloader::__autoload(array("../DbConnect"));
//$db = Database::connect();

class Genre
{
    public $result;
    public $req;
    public $db;
    public $arrayGenre = [];
    public $arrayCategory = [];
    public $arrayDateProd = [];
    public $arrayDistributor = [];
    public $offset = 0;
    public $perPage = 12;
    public $pagesTotales;

    function __construct($db)
    {
        $this->db = $db;
        $this->getDistributor();
        $this->getDate();
        $this->getCategory();
        $this->countArticle();
    }

    /* Méthode requête de la méthode affiche*/
    public function sqlReq($SQL)
    {

        $this->query($SQL, $this->arrayGenre);
        return $this->arrayGenre;
    }

    /* Méthode get category list*/
    public function getCategory()
    {
        $SQL = "SELECT nom FROM genre ORDER BY nom ASC";
        $this->query($SQL, $this->arrayCategory, 'nom');
        if (!isset($_GET['category']) || !in_array($_GET['category'], $this->arrayCategory)) {
            $_GET['category'] = 'All Movies';
        }
        return $this->arrayCategory;
    }

    /* Méthode qui récupère et gère année prod*/
    public function getDate()
    {
        $SQL = "SELECT DISTINCT annee_prod 
                FROM film WHERE annee_prod IS NOT NULL AND annee_prod > 0 
                ORDER BY annee_prod DESC";
        $this->query($SQL, $this->arrayDateProd, 'annee_prod');
        if (!isset($_GET['date']) || !in_array($_GET['date'], $this->arrayDateProd)) {
            $_GET['date'] = 'All Dates';
        }
        return $this->arrayDateProd;
    }

    /* Méthode qui récupère et gère année prod*/
    public function getDistributor()
    {
        $SQL = "SELECT nom FROM distrib ORDER BY nom";
        $this->query($SQL, $this->arrayDistributor, 'nom');
        if (!isset($_GET['distrib']) || !in_array($_GET['distrib'], $this->arrayDistributor)) {
            $_GET['distrib'] = 'All Distributor';
        }
        return $this->arrayDistributor;
    }


    /* Méthode condition de trie*/
    public function filter($perPage, $offset)
    {
        if ($_GET['category'] === 'All Movies' && $_GET['date'] === 'All Dates' && $_GET['distrib'] === 'All Distributor') {
            /* afficher tout les films */
            return 'SELECT id_film, titre, nom, resum, annee_prod FROM film
                    INNER JOIN genre ON film.id_genre = genre.id_genre 
                    ORDER BY annee_prod DESC LIMIT ' . $offset. ',' . $perPage;
        } else if ($_GET['category'] !== 'All Movies' && $_GET['date'] === 'All Dates' && $_GET['distrib'] === 'All Distributor') {
            /* afficher tout les films de la catégorie */
            return 'SELECT DISTINCT id_film, titre, nom, resum, annee_prod FROM film INNER JOIN genre
                    ON film.id_genre = genre.id_genre WHERE genre.nom = ' . '"' . $_GET['category'] . '"' . '
                    ORDER BY annee_prod DESC LIMIT ' . $offset. ',' . $perPage;
        } else if ($_GET['date'] !== 'All Dates' && $_GET['category'] === 'All Movies' && $_GET['distrib'] === 'All Distributor') {
            /* afficher tout les films de la date */
            return 'SELECT id_film, titre, nom, resum, annee_prod FROM film INNER JOIN genre
                    ON film.id_genre = genre.id_genre WHERE film.annee_prod = ' . '"' . $_GET['date'] . '"' . '
                    ORDER BY annee_prod DESC LIMIT ' . $offset. ',' . $perPage;
        } else if ($_GET['distrib'] !== 'All Distributor' && $_GET['category'] === 'All Movies' && $_GET['date'] === 'All Dates') {
            /* afficher tout les films du distributeur */
            return 'SELECT id_film, titre, distrib.nom , genre.nom, resum, annee_prod FROM film 
                    INNER JOIN genre ON (film.id_genre = genre.id_genre)
                    INNER JOIN distrib ON (film.id_distrib = distrib.id_distrib)
                    WHERE distrib.nom = ' . '"' . $_GET['distrib'] . '"' . '
                    ORDER BY annee_prod DESC LIMIT ' . $offset. ',' . $perPage;
        } else if ($_GET['date'] !== 'All Dates' && $_GET['category'] !== 'All Movies' && $_GET['distrib'] === 'All Distributor') {
            /* afficher tout les films de la catégorie / trier par date */
            return 'SELECT id_film, titre, nom, resum, annee_prod FROM film INNER JOIN genre
                    ON film.id_genre = genre.id_genre WHERE genre.nom = ' . '"' . $_GET['category'] . '"' . '
                    AND film.annee_prod = ' . '"' . $_GET['date'] . '"' . '
                    ORDER BY annee_prod DESC LIMIT ' . $offset. ',' . $perPage;
        } else if ($_GET['distrib'] !== 'All Distributor' && $_GET['category'] !== 'All Movies' && $_GET['date'] === 'All Dates') {
            /* afficher tout les films de la catégorie / trier par distrib */
            return 'SELECT id_film, titre, distrib.nom, genre.nom, resum, annee_prod FROM film 
                    INNER JOIN genre ON (film.id_genre = genre.id_genre)
                    INNER JOIN distrib ON (film.id_distrib = distrib.id_distrib) 
                    WHERE genre.nom = ' . '"' . $_GET['category'] . '"' . ' AND distrib.nom = ' . '"' . $_GET['distrib'] . '"' . '
                    ORDER BY annee_prod DESC LIMIT ' . $offset. ',' . $perPage;
        } else if ($_GET['distrib'] !== 'All Distributor' && $_GET['date'] !== 'All Dates' && $_GET['category'] === 'All Movies') {
            /* afficher tout les films de la date / trier par distrib */
            return 'SELECT id_film, titre, distrib.nom, genre.nom, resum, annee_prod FROM film
                    INNER JOIN genre ON (film.id_genre = genre.id_genre)
                    INNER JOIN distrib ON (film.id_distrib = distrib.id_distrib)
                    WHERE annee_prod = ' . '"' . $_GET['date'] . '"' . ' AND distrib.nom = ' . '"' . $_GET['distrib'] . '"' . '
                    ORDER BY annee_prod DESC LIMIT ' . $offset. ',' . $perPage;
        } else if ($_GET['date'] !== 'All Dates' && $_GET['distrib'] !== 'All Distributor' && $_GET['category'] !== 'All Movies') {
            /* afficher tout les films trier par date / distrib / category*/
            return 'SELECT id_film, titre, distrib.nom, genre.nom, resum, annee_prod FROM film 
                    INNER JOIN genre ON (film.id_genre = genre.id_genre)
                    INNER JOIN distrib ON (film.id_distrib = distrib.id_distrib) 
                    WHERE genre.nom = ' . '"' . $_GET['category'] . '"' . ' AND film.annee_prod = ' . '"' . $_GET['date'] . '"' . ' AND distrib.nom = ' . '"' . $_GET['distrib'] . '"' . '
                    ORDER BY annee_prod DESC LIMIT ' . $offset. ',' . $perPage;
        }
        echo count($this->arrayGenre) . '<br>';
    }

    /* Méthode query dynamic */
    private function query($SQL, &$array, $index = '')
    {
        $this->req = $this->db->query($SQL);
        $this->result = $this->req->fetchAll();
        for ($i = 0; $i < count($this->result); $i++) {
            if (empty($index)) {
                array_push($array, $this->result[$i]);
            } else {
                array_push($array, $this->result[$i][$index]);
            }
        }
    }

    /* Méthode pagination*/
    public function countArticle()
    {
        //Conditions pour get page courante
        if (isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0) {
            $_GET['page'] = intval($_GET['page']);
            $currentPage = $_GET['page'];
        } else {

            $_GET['page'] = 1;
            $currentPage = 1;
        }

        //get count article with filter (méthode affiche) ==> 113
        $count = $this->count();

        //Calcul nombres de pages
        $this->pagesTotales = ceil($count / $this->perPage);

        //Condition si la page courante est supérieur au nombre de pages max
        if ($currentPage > $this->pagesTotales) {
            $_GET['page'] = $this->pagesTotales;
            header("Location: " . '?category='.$_GET["category"].'&date='.$_GET["date"].'&distrib='.$_GET["distrib"].'&page=' . $_GET["page"]);
        }
        //calcul de l'offset
        $this->offset = $this->perPage * ($currentPage - 1);
    }

    public function affiche(){
        return $this->sqlReq($this->filter($this->perPage, $this->offset));
    }

    public function count(){
        $count = $this->db->query($this->filter(3000, 0));
        return $count->rowCount();
    }


}