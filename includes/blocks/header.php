<header class="p-3 bg-secondary text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
          <use xlink:href="#bootstrap"></use>
        </svg>
      </a>


      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <form action="index.php">
          <button class="navbar-brand" style="background: transparent; outline: none; border: 0;" name="Home">
            <img src="https://img.icons8.com/external-smashingstocks-circular-smashing-stocks/65/null/external-music-player-technology-and-hardware-smashingstocks-circular-smashing-stocks.png" style="height: 60px; width: 60px;" />
          </button>
        </form>

        <?php
        if ($user) {
          if ($likes->Count() > 0) {
        ?>

            <a href="?likes=true" style="text-decoration: none">
              <img src="https://img.icons8.com/fluency/96/null/likes-folder--v1.png" style="height: 60px; width: 60px; margin-left: 30px" />
            </a>
          <?php
          }

          ?>
          <a href="?playlist=true" style="text-decoration: none">
            <img src="https://img.icons8.com/plasticine/100/null/video-playlist.png" style="height: 60px; width: 60px; margin-left: 30px" />
          </a>
        <?php
        }
        ?>
      </ul>

      <ul style="margin-right: 20%; display: inline-flex">
        <form action="index.php" method="GET" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input type="search" name='search' style="width: 400px" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
        </form>
      </ul>

      <div class="text-end" style='display: inline-flex'>
        <?php
        if ($user == NULL) {
        ?>
          <form action='index.php' method='GET'>
            <button class="btn btn-outline-dark me-2" name="Login">Login</button>
            <button class="btn btn-primary" name="SingUp">Sign-up</button>
          </form>
        <?php
        } else {
          echo '
                  <div><form action = "index.php" method = "POST">
                    <input type = "hidden" name = "id" value = "' . $user['id'] . '" >          
                    <label for = "exit"> ' . $user['login'] . ' </label>
                    <button class="btn btn-warning" style = "margin-left: 10px" id = "exit" name="Exit"> Exit </button>
                  </form></div>';

          if (isset($_REQUEST['playlist'])) {
            echo '<div style = "margin-left: 20px"><form action = "index.php" method = "GET">
                      <button class="btn btn-warning" style = "background: green; border: inherit" name="AddPlaylist"> Add Playlist </button>
                    </form></div>';
          }
        }
        ?>
      </div>
    </div>
  </div>
</header>