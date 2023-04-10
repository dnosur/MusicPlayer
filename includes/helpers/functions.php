<?php

function GetSQLDataById(&$res, $id)
{
    $i = 0;
    foreach ($res as $value) {
        if ($i == $id) return $value;
        $i++;
    }
}

function Redirect($url, $permanent = false)
{
    Header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

function SetUserSession(&$login, &$password)
{
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
}

function UserExit(&$conn, &$data)
{
    session_destroy();
}

function CreatePage(&$music, &$user, &$userLikes, &$userPlaylist, $search)
{

    $isSearch = isset($_GET['search']) || isset($_REQUEST['search']);

    echo "<div style = 'display: inline-flex'> <h1> " . $search . " </h1> <form action = 'index.php' method = 'POST'>";

    if($isSearch){
        echo "<button name = 'AddToMainPage' id = 'actionButton'> <img src='https://img.icons8.com/stickers/100/null/home-page.png'/> </button>";
    }
    else echo "<button name = 'DeletePlaylist' id = 'actionButton'> <img src='https://img.icons8.com/stickers/100/null/delete-sign.png'/> </button>";

    echo "</form> </div> <hr>";

    echo "<div id = 'contentBlock' class = '" . $search . "'>";
    foreach ($music->Search($search)->items as $item) {
        echo "<div id = '".$item->id->videoId."' >";
        echo ' <iframe onclick = "OnClick(this)" id = "" width="420" height="315"
                src="https://www.youtube.com/embed/' . $item->id->videoId . '">
                </iframe>
                <h2> ' . $item->snippet->title . ' </h2> 
                ';

        if ($user) {
            $isLike = false;

            foreach ($userLikes as $userLikeItem) {
                if ($userLikeItem['video_id'] === $item->id->videoId) {
                    $isLike = true;
                    break;
                }
            }


            echo  '<form action = "index.php" method = "GET">';

            echo '<input type = "hidden" name = "id" value = "' . $item->id->videoId . '">
                <input type = "hidden" name = "video_name" value = "' . $item->snippet->title . '" >';

            if($isSearch) echo '<input type = "hidden" name = "search" value = "'.$search.'" >';

            if (!$isLike) echo  '<button name = "Like" id = "actionButton"> <img src="https://img.icons8.com/fluency/96/null/like.png"/> </button>';
            else echo  '<button name = "DisLike" id = "actionButton"> <img src="https://img.icons8.com/emoji/48/null/broken-heart.png"/> </button>';

                echo '<div class="dropdown">
            <button class="dropbtn"><img src="https://img.icons8.com/dusk/64/null/video-playlist.png"/></button>
            <div class="dropdown-content">';

            foreach($userPlaylist as $userPlaylistItem){
                $isFound = false;

                foreach($userPlaylistItem['playlist_music'] as $playlistMusicItem){
                    if($playlistMusicItem['video_id'] === $item->id->videoId){
                        $isFound = true;
                        break;
                    }
                }

                if($isFound) break;

                if($isSearch) echo '<a href = "?search='.$search.'&AddToPlaylist=true&playlist_id='.$userPlaylistItem['id'].'&video_id='.$item->id->videoId.'&video_name='.$item->snippet->title.'">'.$userPlaylistItem['name'].'</a>';
                else echo '<a href = "?AddToPlaylist=true&playlist_id='.$userPlaylistItem['id'].'&video_id='.$item->id->videoId.'&video_name='.$item->snippet->title.'">'.$userPlaylistItem['name'].'</a>';
            }

            echo '</div>
            </div>';

            echo '</form>';
        }

        echo "</div>";
    }
    echo "</div>";
}
