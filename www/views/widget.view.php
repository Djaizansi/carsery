<?php
use carsery\core\Helpers;
$i = 1;
$files = glob("./public/images_upload/*.*");
$choix = [];
?>

        <div class="container">
            <h2>Ajout de widget</h2>
            <form action="" method="POST">
                <label>Caroussel</label>
                <input id="check" type="checkbox" name="caroussel" value="caroussel">
                <div class="caroussel off">
                    <h3>Ajouter les images pour votre caroussel</h3>
                    <table id="myTable" class="display" style="width:300px;float: left;">
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
                    <label>Nom du shortcode: </label>
                    <input type="text" name="namecarousel" required>
                    <br><br><br>
                </div>

                <label>Forum</label>
                <input id="check" type="checkbox" name="forum" value="forum">
                <div class="forum off">Vous avez sélectionné le rouge</div>

                <label>Formulaire Contact</label>
                <input id="check" type="checkbox" name="contact" value="contact">
                <div class="contact off">Vous avez sélectionné le vert</div>

                <label>Tableau vehicule</label>
                <input id="check" type="checkbox" name="vehicule" value="vehicule">
                <div class="vehicule off">Vous avez sélectionné le vert</div>

                <label>Pièce détaché Disponible</label>
                <input id="check" type="checkbox" name="piece" value="piece">
                <div class="piece off">Vous avez sélectionné le vert</div>
                
                <br><br>
                <button type="submit" class="btn btn--primary">Ajout Widget</button>
                <br><br>
            </form>
            <?php if(isset($_POST['caroussel'])): ?>
                <?php $data = implode(',',$choix) ?>
                <?php if(empty($_POST['namecarousel'])): ?>
                    <?php $errors[] = "Vous devez renseigner le nom de votre shortcode" ?>
                    <?php if(!empty($errors)): ?>
                        <?= Helpers::alert('danger',$errors) ?>
                    <?php endif ?>
                <?php else: ?>
                    <?php $shortCode->setShortCode('['.$_POST['namecarousel'].']'); ?>
                <?php endif ?>
                <?php $shortCode->setImages($data); ?>
                <?php $shortCode->setType('caroussel'); ?>
                <?php $shortCodeManager->save($shortCode); ?>
            <?php endif ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('input[type="checkbox"]').click(function(){
                var val = $(this).attr("value");
                $("." + val).toggle();
            });
        });
    </script>