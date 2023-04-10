<div id="categoryes">

    <?php




    foreach ($mainPageController->Get() as $mainPageMusicItem) {



        echo "
                    <div>
                        <a href = '?search=" . $mainPageMusicItem . "' style = 'text-decoration: none'> " . $mainPageMusicItem . "  </a>
                    </div>
                ";
    }

    ?>

</div>