<?php

class Playlist implements IMusicPage
{
    private $conn = null;
    private $user = null;

    public function __construct(&$conn, &$user)
    {
        $this->conn = $conn;
        $this->user = $user;
    }

    public function Add($name)
    {
        $this->conn->query('INSERT INTO playlist(name, user_id) VALUES("' . $name . '", ' . $this->user['id'] . ')');
    }

    public function AddMusicToPlaylist($video_id, $video_name, $playlist_id)
    {
        $this->conn->query('INSERT INTO playlist_music(playlist_id, video_id, video_name) VALUES(' . $playlist_id . ', "' . $video_id . '", "' . $video_name . '")');
    }

    public function Get()
    {
        $playlist_obj = [];

        foreach ($this->conn->query('SELECT * FROM playlist WHERE user_id = ' . $this->user['id'] . ';') as $playlist_item) {
            $playlist_music_obj = [];
            foreach ($this->conn->query('SELECT * FROM playlist_music WHERE playlist_id = ' . $playlist_item['id'] . ';') as $playlist_music_item) {
                array_push($playlist_music_obj, $playlist_music_item);
            }

            array_push($playlist_obj, [
                "id" => $playlist_item['id'],
                "name" => $playlist_item['name'],
                "user_id" => $playlist_item['user_id'],
                "playlist_music" => $playlist_music_obj
            ]);
        }

        return $playlist_obj;
    }

    public function GetPlaylist()
    {
        return $this->conn->query('SELECT * FROM playlist WHERE user_id = ' . $this->user['id'] . ';');
    }

    public function GetPlaylistMusic($id)
    {
        return $this->conn->query('SELECT * FROM playlist_music WHERE playlist_id = ' . $id . ';');
    }

    public function Rename($name, $id){
        $this->conn->query("UPDATE playlist SET name = '".$name."' WHERE id = ".$id.";");
    }

    public function Remove($id)
    {
        $this->conn->query('DELETE FROM playlist_music WHERE playlist_id = ' . $id . ';');
        $this->conn->query('DELETE FROM playlist WHERE id = ' . $id . ';');
    }

    public function RemovePlaylistMusic($id)
    {
        $this->conn->query('DELETE FROM playlist_music WHERE id = ' . $id . ';');
    }

    public function Count()
    {
        return $this->conn->query('SELECT * FROM playlist WHERE user_id = ' . $this->user['id'] . ';')->num_rows;
    }

    public function PrintAll()
    {
        foreach ($this->GetPlaylist() as $playlistItem) {
            echo "<div style = 'display: inline-flex'> <h1> " . $playlistItem['name'] . " </h1> 
            <form action = 'index.php' method = 'GET'>
                <input type = 'hidden' name = 'name' value = '".$playlistItem['name']."' >
                <input type = 'hidden' name = 'id' value = '".$playlistItem['id']."' >

                <button name = 'Rename' id = 'actionButton'> <img src='https://img.icons8.com/stickers/100/null/rename.png'/> </button>
                <button name = 'DeletePlaylist' id = 'actionButton'> <img src='https://img.icons8.com/stickers/100/null/delete-sign.png'/> </button>
            </form>
            </div> 
            <hr> 
            <div id = 'contentBlock' class = '".$playlistItem['name']."'>";
            foreach ($this->GetPlaylistMusic($playlistItem['id']) as $item) {
                echo "<div id = '" . $item['video_id'] . "' >";
                echo ' <iframe onclick = "OnClick(this)" id = "" width="420" height="315"
                src="https://www.youtube.com/embed/' . $item['video_id'] . '">
                </iframe>
                <h2> ' . $item['video_name'] . ' </h2> 
                ';

                if ($this->user) {
                    echo  '<form action = "index.php" method = "GET">';

                    echo '<input type = "hidden" name = "id" value = "' . $item['id'] . '">
                    <input type = "hidden" name = "playlist_name" value = "'.$playlistItem['name'].'" >';

                    echo '<input type = "hidden" name = "playlist" value = "true">';

                    echo '<button name = "ReomveFromPlaylist" id = "actionButton"> <img src="https://img.icons8.com/office/80/null/remove-tag.png"/> </button>';

                    echo '</form>';
                }

                echo "</div>";
            }
            echo "</div>";
        }
    }
};
