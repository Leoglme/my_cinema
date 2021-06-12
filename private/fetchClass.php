<?php

class fetch
{
    public $result;
    public $req;
    public $db;
    function __construct($db)
    {
        $this->db = $db;
    }

    /* Méthode query dynamic */
    public function query($SQL, &$array, $index = '')
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
}