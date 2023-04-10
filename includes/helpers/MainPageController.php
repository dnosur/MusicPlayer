<?php
class MainPageController implements IMusicPage
{

    private $conn = null;
    private $user = null;

    private $music = null;

    private $userLikes = null;
    private $userPlaylist = null;

    private $mainPageMusicDefault = [
        'Dire Straits'
    ];

    public function __construct(&$conn, &$user, &$music, &$userLikes, &$userPlaylist)
    {
        $this->conn = $conn;
        $this->user = $user;

        $this->music = $music;

        $this->userLikes = $userLikes;
        $this->userPlaylist = $userPlaylist;
    }

    public function Get()
    {

        if ($this->user) {
            $arr = [];

            foreach ($this->conn->query('SELECT * FROM main_page_video WHERE user_id = ' . $this->user['id'] . ';') as $musicItem) {
                array_push($arr, $musicItem['search']);
            }

            if (count($arr) <= 0) {
                foreach ($this->mainPageMusicDefault as $musicItem) {
                    $this->conn->query('INSERT INTO main_page_video(search, user_id) VALUES("' . $musicItem . '", ' . $this->user['id'] . ')');
                }

                return $this->mainPageMusicDefault;
            }

            return $arr;
        }
        return $this->mainPageMusicDefault;
    }

    public function Add($search)
    {
        $this->conn->query('INSERT INTO main_page_video(search, user_id) VALUES("' . $search . '", ' . $this->user['id'] . ' );');
    }

    public function Count()
    {
        return count($this->Get());
    }

    public function Contains($search)
    {
        return $this->conn->query('SELECT * FROM main_page_video WHERE user_id = ' . $this->user['id'] . ' AND search = "' . $search . '";')->num_rows;
    }

    public function Remove($search)
    {
        $this->conn->query('DELETE FROM main_page_video WHERE user_id = ' . $this->user['id'] . ' AND search = "' . $search . '" ');
    }

    function PrintAll($search)
    {

        $isSearch = isset($_GET['search']) || isset($_REQUEST['search']);

        echo "<div style = 'display: inline-flex'> <h1> " . $search . " </h1>";

        if ($this->user) {
            echo "<form action = 'index.php' method = 'POST'>";
            echo '<input type = "hidden" name = "search" value="' . $search . '" >';

            if ($isSearch && !$this->Contains($search)) {
                echo '<input type = "hidden" name = "isSearch" value = "true">';
                echo "<button name = 'AddToMainPage' id = 'actionButton'> <img src='https://img.icons8.com/stickers/100/null/home-page.png'/> </button>";
            } else echo "<button name = 'DeleteFromMainPage' id = 'actionButton'> <img src='https://img.icons8.com/stickers/100/null/delete-sign.png'/> </button>";

            echo "</form>";
        }
        echo " </div> <hr>";

        echo "<div id = 'contentBlock' class = '" . $search . "'>";
        foreach ($this->music->Search($search)->items as $item) {

            if (isset($item->id->videoId)) {
                echo "<div id = '" . $item->id->videoId . "' >";
                echo ' <iframe onclick = "OnClick(this)" id = "" width="420" height="315"
                src="https://www.youtube.com/embed/' . $item->id->videoId . '">
                </iframe>
                <h2> ' . $item->snippet->title . ' </h2> 
                ';

                if ($this->user) {
                    $isLike = false;

                    foreach ($this->userLikes->Get() as $userLikeItem) {
                        if ($userLikeItem['video_id'] === $item->id->videoId) {
                            $isLike = true;
                            break;
                        }
                    }


                    echo  '<form action = "index.php" method = "GET">';

                    echo '<input type = "hidden" name = "id" value = "' . $item->id->videoId . '">
                <input type = "hidden" name = "video_name" value = "' . $item->snippet->title . '" >';

                    if ($isSearch) echo '<input type = "hidden" name = "search" value = "' . $search . '" >';

                    if (!$isLike) echo  '<button name = "Like" id = "actionButton"> <img src="https://img.icons8.com/fluency/96/null/like.png"/> </button>';
                    else echo  '<button name = "DisLike" id = "actionButton"> <img src="https://img.icons8.com/emoji/48/null/broken-heart.png"/> </button>';

                    echo '<div class="dropdown">
            <button class="dropbtn"><img src="https://img.icons8.com/dusk/64/null/video-playlist.png"/></button>
            <div class="dropdown-content">';

                    foreach ($this->userPlaylist->Get() as $userPlaylistItem) {
                        $isFound = false;

                        foreach ($userPlaylistItem['playlist_music'] as $playlistMusicItem) {
                            if ($playlistMusicItem['video_id'] === $item->id->videoId) {
                                $isFound = true;
                                break;
                            }
                        }

                        if ($isFound) break;

                        if ($isSearch) echo '<a href = "?search=' . $search . '&AddToPlaylist=true&playlist_id=' . $userPlaylistItem['id'] . '&video_id=' . $item->id->videoId . '&video_name=' . $item->snippet->title . '">' . $userPlaylistItem['name'] . '</a>';
                        else echo '<a href = "?AddToPlaylist=true&playlist_id=' . $userPlaylistItem['id'] . '&video_id=' . $item->id->videoId . '&video_name=' . $item->snippet->title . '">' . $userPlaylistItem['name'] . '</a>';
                    }

                    echo '</div>
            </div>';

                    echo '</form>';
                }

                echo "</div>";
            }
        }
        echo "</div>";
    }
};
