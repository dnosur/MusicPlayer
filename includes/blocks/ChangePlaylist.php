<form action="index.php" method="POST">

    <input type = "hidden" name = "id" value = "<?php echo $_GET['id'] ?>" >
    <input type = "text" name = "name" placeholder="playlist name" value = "<?php echo $_GET['name'] ?>" require> 
    
    <button type="submit" name = "Rename"> Rename </button>
</form>