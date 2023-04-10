<div style="display: flex; flex-wrap: wrap;">
    <div style="left: 0; margin-left: 40px; margin-top: 30px">
        <?php
        include "categoryes.php";
        ?>
    </div>

    <div style="margin-left: 200px; margin-top: 10px;  display: flexbox; flex-wrap: wrap">
        <?php

        if (isset($_REQUEST['likes'])) {
            $likes->PrintAll($userPlaylist);
        }
        else if(isset($_REQUEST['playlist'])){
            $playlist->PrintAll();
        } 
        else {

            if (isset($_GET['search']) && !empty($_GET['search']) || isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {

                $search = (isset($_GET['search']) ? $_GET['search'] : $_REQUEST['search']);

                $mainPageController->PrintAll($search);
            } else {

                foreach ($mainPageController->Get() as $mainPageMusicItem) {
                    $mainPageController->PrintAll($mainPageMusicItem);
                }
            }
        }
        ?>
    </div>
</div>