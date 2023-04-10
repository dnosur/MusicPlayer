<?php
session_start();

include("ConnectDb.php");

$instance = ConnectDb::getInstance();
$conn = $instance->getConnection();

?>