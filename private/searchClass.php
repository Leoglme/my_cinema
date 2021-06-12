<?php
/* CLASS SEARCH BY SEARCH-BAR */
class searchResult
{

    public $db;
    public $ClassFetch;
    public $resultArray = [];
    public $offset = 0;
    public $perPage = 12;
    public $pagesTotales;
    public $POST;
    public $tableName;
    public $arrayLike = [];
    public $orderBy;

    function __construct($db, $postValue, $tableName, $arrayLike, $orderBy)
    {
        $this->db = $db;
        include_once 'fetchClass.php';
        $this->ClassFetch = new fetch($db);
        $this->POST = $postValue;
        $this->tableName = $tableName;
        $this->arrayLike = $arrayLike;
        $this->orderBy = $orderBy;
        $this->postVerify();
//        $this->countArticle();
    }

    public function postVerify()
    {
        if (isset($_POST[$this->POST]) and !empty($_POST[$this->POST])) {
            $_POST[$this->POST] = trim($_POST[$this->POST]);
            $_POST[$this->POST] = stripslashes($_POST[$this->POST]);
            $_POST[$this->POST] = htmlspecialchars($_POST[$this->POST]);
            return $_POST[$this->POST];
        } else {
            return $_POST[$this->POST] = false; //redirect => page not found ?
        }


    }

    public function sqlReq($SQL)
    {
        $this->ClassFetch->query($SQL, $this->resultArray);
        return $this->resultArray;
    }

    public function filter($perPage, $offset)
    {
        $cond1 = $this->arrayLike[0];
        $cond2 = $this->arrayLike[1];
        return  "SELECT * FROM $this->tableName WHERE $cond1 LIKE '" . $_POST[$this->POST] . "' OR $cond2 LIKE '" . $_POST[$this->POST] . "'
                OR CONCAT($cond2, ' ', $cond1) LIKE '" . $_POST[$this->POST] . "' OR CONCAT($cond1, ' ', $cond2) LIKE '" . $_POST[$this->POST] . "' 
                ORDER BY $this->orderBy DESC LIMIT " . $offset . "," . $perPage;
    }

    public function affiche(){
        return $this->sqlReq($this->filter($this->perPage, $this->offset));
    }
    /* Méthode pagination*/
//    public function countArticle()
//    {
//        //Conditions pour get page courante
//        if (isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0) {
//            $_GET['page'] = intval($_GET['page']);
//            $currentPage = $_GET['page'];
//        } else {
//            $_GET['page'] = 1;
//            $currentPage = 1;
//        }
//
//        //get count article with filter (méthode affiche) ==> 113
//        $count = $this->count();
//        //Calcul nombres de pages
//        $this->pagesTotales = ceil($count / $this->perPage);
//
//        //Condition si la page courante est supérieur au nombre de pages max
//        if ($currentPage > $this->pagesTotales && $count > 0) {
//            $_GET['page'] = $this->pagesTotales;
//            header("Location: " . '?page=' . $_GET["page"]);
//        }elseif ($count === 0){
//            $_GET['page'] = 1;
//        }
//        //calcul de l'offset
//        $this->offset = $this->perPage * ($currentPage - 1);
//    }
//
//    public function count(){
//        $count = $this->db->query($this->filter(3000, 0));
//        return $count->rowCount();
//    }



}