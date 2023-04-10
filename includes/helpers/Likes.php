<?php

class Likes implements IMusicPage
{
    private $conn = null;
    private $user = null;

    public function __construct(&$conn, &$user)
    {
        $this->conn = $conn;
        $this->user = $user;
    }

    public function Add($video_id, $video_name)
    {
        echo $video_id;
        $this->conn->query('INSERT INTO user_like(video_id, video_name, user_id) VALUES("' . $video_id . '", "' . $video_name . '", ' . $this->user['id'] . ')');
    }

    public function Remove($video_id)
    {
        $this->conn->query('DELETE FROM user_like WHERE video_id = "' . $video_id . '" AND user_id = ' . $this->user['id'] . '; ');
    }

    public function Get()
    {
        return $this->conn->query('SELECT * FROM user_like WHERE user_id = ' . $this->user['id'] . ';');
    }

    public function Contains($video_id)
    {
        $get = $this->conn->query('SELECT * FROM user_like WHERE video_id = "' . $video_id . '" user_id = ' . $this->user['id'] . ';');

        return $get->num_rows;
    }

    public function Count()
    {
        return $this->conn->query('SELECT * FROM user_like WHERE user_id = ' . $this->user['id'] . ';')->num_rows;
    }

    public function PrintAll(&$userPlaylist)
    {
        echo "<h1> User Likes </h1> <hr> 
            <div id = 'contentBlock' class = 'User Likes'>";
        foreach ($this->Get() as $item) {
            echo "<div id = '" . $item['video_id'] . "' >";
            echo ' <iframe onclick = "OnClick(this)" id = "" width="420" height="315"
                src="https://www.youtube.com/embed/' . $item['video_id'] . '">
                </iframe>
                <h2> ' . $item['video_name'] . ' </h2> 
                ';

            if ($this->user) {


                echo  '<form action = "index.php" method = "GET">';

                echo '<input type = "hidden" name = "id" value = "' . $item['video_id'] . '">
                <input type = "hidden" name = "video_name" value = "' . $item['video_name'] . '" >';

                echo '<input type = "hidden" name = "likes" value = "true">';

                echo  '<button name = "DisLike" id = "actionButton"> <img src="https://img.icons8.com/emoji/48/null/broken-heart.png"/> </button>';

                echo '<div class="dropdown">
            <button class="dropbtn"><img src="https://img.icons8.com/dusk/64/null/video-playlist.png"/></button>
            <div class="dropdown-content">';

            foreach($userPlaylist as $userPlaylistItem){
                $isFound = false;

                foreach($userPlaylistItem['playlist_music'] as $playlistMusicItem){
                    if($playlistMusicItem['video_id'] === $item['video_id']){
                        $isFound = true;
                        break;
                    }
                }

                if($isFound) break;

                else echo '<a href = "?likes=true&AddToPlaylist=true&playlist_id='.$userPlaylistItem['id'].'&video_id='.$item['video_id'].'&video_name='.$item['video_name'].'">'.$userPlaylistItem['name'].'</a>';
            }

            echo '</div>
            </div>';

                echo '</form>';
            }

            echo "</div>";
        }
        echo "</div>";
    }
};
