<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="https://img.icons8.com/external-smashingstocks-circular-smashing-stocks/65/null/external-music-player-technology-and-hardware-smashingstocks-circular-smashing-stocks.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <title>Music Player</title>

    <link rel="stylesheet" type="text/css"  href="css/categoryes.css" />

    <link rel="stylesheet" type="text/css"  href="css/searchPanel.css" />

    <link rel="stylesheet" type="text/css"  href="css/contentBlock.css" />

    <link rel="stylesheet" type="text/css"  href="css/showAllButton.css" />

    <link rel="stylesheet" type="text/css"  href="css/add.css" />
    
    <link rel="stylesheet" type="text/css"  href="css/actionButton.css" />

    <link rel="stylesheet" type="text/css"  href="css/dropdown.css" />

</head>

<style>

body{
    background: linear-gradient(to right, #295FA6, #733D56)
}

</style>

<body>

<?php
    include "includes/helpers/connect.php";
    include "includes/helpers/functions.php";
    include "includes/helpers/initialization.php";

    include "includes/blocks/header.php";

    if(isset($_GET['About']) || (isset($_REQUEST['action']) && $_REQUEST['action'] == 'about')){
        $id = (isset($_GET['id'])) ? $_GET['id'] : $_REQUEST['id'];

        echo '<div style = "display: flexbox; flex-wrap: wrap; ">';
            include "includes/blocks/about.php";
        echo '</div>';
    }
    else if(isset($_GET['AddPlaylist'])){
        include 'includes/blocks/AddPlaylist.php';
    }
    else if(isset($_GET['Rename'])){
        include 'includes/blocks/ChangePlaylist.php';
    }
    else if(isset($_GET['Login']) || isset($_POST['Login'])){
        if(isset($_GET['Login']) || (isset($_POST['Login']) && $isError) ) include 'includes/blocks/login.php';
        else include "includes/blocks/main.php";
    }
    else if(isset($_GET['SingUp']) || isset($_POST['SingUp'])){
        if(isset($_GET['SingUp']) || ($_POST['SingUp'] && $isError)) include 'includes/blocks/singUp.php';
        else include "includes/blocks/main.php";
    }
    else include "includes/blocks/main.php";

?>
    
</body>
</html>
