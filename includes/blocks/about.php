

<div style = 'display: inline-flex; flex-wrap: wrap; '>

<div style = "left: 0; margin-left: 40px; margin-top: 30px">
    <?php
        include "categoryes.php";
    ?>
</div>

<div style = "margin-left: 50px; margin-top: 10px;  display: flexbox; flex-wrap: wrap">
    <?php
        $car = $cars->GetCarById($id);
        echo '<h1> '.$car['name'].' </h1> <hr>';
        echo '<img src = "data:image/jpeg;base64,'.base64_encode($car['img']).'" style = " width: 600; height: 400px; border: 1px solid black"/>';
    ?>
</div>

<?php

    echo '<div style = "margin-left: 80px; margin-top: 280px;  display: flexbox;  ">';
    
    $carUser = $conn->query('SELECT login, phone FROM users WHERE id = '.$car['userId'].'; ')->fetch_assoc();

    echo "<h1 style = 'margin-left: 30px'>".$carUser['login']."</h1>
          <h1 style = 'margin-left: 30px'>".$carUser['phone']."</h1>";
          
    echo "<h1 style = 'color: green; margin-left: 30px'>".round($car['price'], 2)." $</h1>";

    echo '</div>';

?>

</div>

<?php
$screens = $conn->query('SELECT screen FROM screens WHERE carId = '.$car['id'].';');
if($screens->num_rows){
    include 'UIkit.php';
?>
<div style="width: 1200px; margin-top: 50px; margin-left: 210px">
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>
                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m">
                    <?php
                        $count = 1;
                        foreach($screens as $screen){
                        echo '<li>
                                <img src="data:image/jpeg;base64,'.base64_encode($screen['screen']).'" width="400" height="600" alt="Слайдер">
                                <div class="uk-position-center uk-panel">
                                    <div class="uk-h1">'.$count.'</div>
                                </div>
                            </li>';
                            $count++;
                        }
                    ?>
                </ul>
                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
            </div>
        </div>
<?php } ?>

<div style = 'margin-left: 200px; margin-top: 50px; '>
    <h1> About </h1> <hr width = 1010px>
    <pre style = 'width: 1010px; white-space: pre-wrap; background: transparent; color: black; border: none'> <?php echo $car['about']; ?> </pre>
</div>