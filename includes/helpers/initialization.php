<?php
    include 'IMusicPage.php';
    
    include 'Music.php';
    include 'Likes.php';
    include 'Playlist.php';
    include 'MainPageController.php';

    $isError = false;
    $strError = '';

    $music = new Music($conn); 

    $user = NULL;

    if(isset($_POST['Exit'])){
        UserExit($conn,$_POST);
        Redirect('index.php');
    }

    if(isset($_POST['SingUp'])){
        $res = $conn->query('SELECT * FROM user WHERE login = "'.$_POST['login'].'" AND password = "'.$_POST['password'].'"; ');

        if($res->num_rows > 0){
            $isError = true;
            $strError = 'Такой пользователь уже существует!';
        }
        else if(strlen($_POST['login']) <= 0 || strlen($_POST['password']) <= 0){
            $isError = true;
            $strError = 'Данные введены некоректно!';
        }
        else{
            $conn->query('INSERT INTO user(login, password) VALUES("'.$_POST['login'].'", "'.$_POST['password'].'")');
            SetUserSession($_POST['login'], $_POST['password']);
        }
    }

    if(isset($_POST['Login'])){
        $res = $conn->query('SELECT * FROM user WHERE login = "'.$_POST['login'].'" AND password = "'.$_POST['password'].'"; ');

        if($res->num_rows > 0){
            $user = GetSQLDataById($res, 0);

            SetUserSession($_POST['login'], $_POST['password']);
        }
        else{
            $isError = true;
            $strError = 'Неверный логин или пароль!';
        }
    }

    if(isset($_SESSION['login']) && isset($_SESSION['password']) && $user == NULL){
        $res = $conn->query('SELECT * FROM user WHERE login = "'.$_SESSION['login'].'" AND password = "'.$_SESSION['password'].'"');
        $user = GetSQLDataById($res, 0);
    }

    $likes = ($user) ? new Likes($conn, $user) : null;
    
    $playlist = ($user) ? new Playlist($conn, $user) : null;

    if(isset($_GET['Like'])){
        if(!$user && !$like) Redirect('index.php?Login=1');

        $likes->Add($_GET['id'], $_GET['video_name']); 

        if(isset($_GET['search'])) Redirect("index.php?search=".$_GET['search']."#".$_GET['id']."");
        Redirect("index.php?#".$_GET['id']."");
    }

    if(isset($_GET['DisLike'])){
        if(!$user && !$like) Redirect('index.php?Login=1');

        $likes->Remove($_GET['id']);

        if(isset($_GET['search'])) Redirect("index.php?search=".$_GET['search']."");
        if(isset($_GET['likes'])) Redirect("index.php?likes=true");
        Redirect("index.php");
    }

    if(isset($_POST['AddPlaylist'])){
        if(!$user && !$playlist) Redirect('index.php?Login=1');

        $playlist->Add($_POST['name']);

        Redirect("?playlist=true");
    }

    if(isset($_REQUEST['AddToPlaylist']) && $playlist){
        $playlist->AddMusicToPlaylist($_REQUEST['video_id'],$_REQUEST['video_name'], $_REQUEST['playlist_id']);

        if(isset($_REQUEST['search'])) Redirect('?search='.$_REQUEST['search'].'#'.$_REQUEST['video_id'].'');
        if(isset($_REQUEST['likes'])) Redirect('?likes=true#'.$_REQUEST['video_id'].'');
        Redirect('index.php#'.$_REQUEST['video_id'].'');
    }

    if(isset($_GET['ReomveFromPlaylist']) && $playlist){
        $playlist->RemovePlaylistMusic($_GET['id']);

        Redirect('index.php?playlist=true."'.$_GET['playlist_name'].'"');
    }

    $mainPageController = new MainPageController($conn, $user, $music, $likes, $playlist);

    if(isset($_POST['AddToMainPage'])){
        $mainPageController->Add($_POST['search']);

        if(isset($_POST['isSearch'])) Redirect("?search=".$_POST['search']."");
        Redirect("index.php");
    }

    if(isset($_POST['DeleteFromMainPage'])){
        $mainPageController->Remove($_POST['search']);
        
        if(isset($_POST['isSearch'])) Redirect("?search=".$_POST['search']."");
        Redirect("index.php");
    }

    if(isset($_GET['DeletePlaylist'])){
        $playlist->Remove($_GET['id']);

        Redirect("index.php?playlist=true");
    }

    if(isset($_POST['Rename'])){
        $playlist->Rename($_POST['name'], $_POST['id']);

        Redirect("index.php?playlist=true.".$_POST['name'].";");
    }

    $userPlaylist = ($user && $playlist) ? $playlist->Get() : null;
?>