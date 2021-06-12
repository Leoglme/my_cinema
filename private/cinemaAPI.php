<?php
class cinemaAPI
{
    private $apiKey;
    public $data;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function callAPI($filmName)
    {
        $curl = curl_init('http://www.omdbapi.com/?apikey=' . $this->apiKey . '&t=' . $filmName . '');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $this->data = curl_exec($curl);

        if ($this->data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return $this->data = null;
        } else {
            $this->data = json_decode($this->data, true);
            return $this->data;
        }
    }

    public function getPoster($filmName){
        $filmName = preg_replace('/\s+/', '+', trim($filmName));
        $this->callAPI($filmName);
        if(!isset($this->data["Poster"]) || $this->data["Poster"] === 'N/A'){
            return 'public/assets/images/no-image.png';
        }
        return $this->data["Poster"];

    }
}

//$poster = new cinemaAPI('3b9d3c2d');
//echo $poster->getPoster('avengers');



//API : http://www.omdbapi.com/?i=tt3896198&apikey=3b9d3c2d
//http://www.omdbapi.com/?apikey=3b9d3c2d&t=avengers
//http://img.omdbapi.com/?apikey=3b9d3c2d&t=avengers