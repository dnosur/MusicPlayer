<?php

class Music{
    private $conn = null;
    private $music = null;

    private $key = "AIzaSyDOxdPxXTDivwjpK2Airlt1ptpjR4QyRiQ";

    public function __construct(&$conn){
        $this->conn = $conn;
    }

    public function Search($search, $maxSearch = 6){
        $search = str_replace(" ", "", $search);

        $response = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&q=".$search."&maxResults=".$maxSearch."&key=".$this->key);
        return json_decode($response);
    }


}

?>