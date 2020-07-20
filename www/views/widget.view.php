<?php

use carsery\core\Helpers;

$i = 1;
$files = glob("./public/images_upload/*.*");
$choix = [];
$findAllShort = $shortCodeManager->findAll(); 
?>

    <div class="container">
        <h2 class="txt-center">Ajout de widget</h2>
        <form action="" method="POST" class="box">
            <label>Caroussel</label>
            <input id="check" type="checkbox" name="caroussel" value="caroussel">
            <div class="caroussel off">
                <h3>Ajouter les images pour votre caroussel</h3>
                <table id="myTable" class="display">
                    <thead>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php foreach($files as $file): ?>
                            <tr>
                                <td><img src="<?=$file?>" style="width:100px !important; height:100px !important;" alt="Image" /></td>
                                <td><?= pathinfo($file, PATHINFO_FILENAME) ?></td>
                                <td><input type="checkbox" name="image[]" value='<?=$i?>'></td>
                                <?php $images = isset($_POST['image']) ? $_POST['image'] : ''?>
                                <?php if($images): ?>
                                    <?php foreach($images as $uneImage): ?>
                                        <?php if($uneImage == $i): ?>
                                            <?php $choix[]= '.'.$file ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tr>
                            <?php $i++ ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <br>
                <label>Nom du shortcode: </label>
                <input type="text" name="namecarousel" required>

                <label>Description: </label>
                <textarea type="text" name="description" required></textarea>
                <br><br><br>
            </div>

            <br><br>
            <button type="submit" class="btn btn--primary">Ajout Widget</button>
            <br><br>
        </form>

        <?php 
            if(isset($_POST['caroussel'])){
                $findShortCode = false;
                $shortcodechoice = '['.htmlspecialchars($_POST['namecarousel']).']';
                foreach($findAllShort as $unCode){
                    $shortcode = $unCode->getShortcode();
                    if($shortcode == $shortcodechoice){
                        $findShortCode = true;
                    }
                }
                $data = implode(',',$choix);
                if(empty($_POST['namecarousel']) && !empty($_POST['description'] && !empty($_POST['image']))){
                    $errors[] = "Vous devez renseigner le nom de votre shortcode";
                }

                elseif(empty($_POST['image']) && !empty($_POST['namecarousel']) && !empty($_POST['description'])){
                    $errors[] = "Veuillez choisir une image";
                }

                elseif(empty($_POST['description']) && !empty($_POST['namecarousel']) && !empty($_POST['image'])){
                    $errors[] = "Vous devez renseigner une description";
                }
                elseif(empty($_POST['description']) && empty($_POST['namecarousel']) && empty($_POST['image'])){
                    $errors[] = "Vous devez renseigner une description";
                    $errors[] = "Vous devez renseigner le nom de votre shortcode";
                    $errors[] = "Veuillez choisir une image";
                    
                }
                else{
                    if($findShortCode){
                        $errors[] = "Le shortcode existe déjà";
                    }else{
                        $shortCode->setShortCode('['.htmlspecialchars($_POST['namecarousel']).']');
                        $shortCode->setDescription(htmlspecialchars($_POST['description']));
                        $shortCode->setImages($data);
                        $shortCode->setType('caroussel');
                        $shortCodeManager->save($shortCode);
                        $success[] = 'Le shortcode a été ajouté avec succès';
                    }
                }
                if(!empty($errors)){
                    echo Helpers::alert('danger',$errors);
                }elseif(!empty($success)){
                    echo Helpers::alert('success',$success);
                }
            }
        ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('input[type="checkbox"]').click(function(){
                var val = $(this).attr("value");
                $("." + val).toggle();
            });
        });
    </script>
