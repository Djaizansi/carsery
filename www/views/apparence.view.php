<div class="container">

    <h1>Apparence</h1>
    <p>Personnaliser l'apparence de votre dashboard selon vos préférences</p>

    <div class="col-3 txt-center">
        <p class="alert--primary">
            
            Thème actuel : 
            
            <?php 
            
            if(isset($_SESSION['theme'])){ 
                echo $_SESSION['theme'];
            } else {
                echo "Par défaut";
            }
                
            ?>
        </p>
    </div>

    
    <div class="row">
        <div class="col-12">

        <?php if($theme !== "Par défaut") { ?>

        <form action="" method="post">
            <input type="hidden" name="themeOne" value="<?php echo $theme; ?>">
            <input type="submit" class="btn" value="Séléctionner le thème 1">
        </form>

        <?php } ?>

        <?php
        
        if(isset($theme)){
            if($theme !== "Thème 2") {
        ?>

        <form action="" method="post">
            <input type="hidden" name="themeTwo" value="<?php echo $theme; ?>">
            <input type="submit" class="btn btn--primary" value="Séléctionner le thème 2">
        </form>

        <?php } ?>

        <?php
            if($theme !== "Thème 3") {
        ?>
            <form action="" method="post">
                <input type="hidden" name="themeThree" value="<?php echo $theme; ?>">
                <input type="submit" class="btn btn--success" value="Séléctionner le thème 3">
            </form>
        <?php 
            }
        } 
        ?>
        </div>
    </div>

    <div class="row">

        <div class="col-4">
            <div class="card-theme">
                <img src="../public/img/default_theme.jpg" alt="Avatar" style="width:100%">
                <div class="card-theme-info">
                    <h4>
                        <b>Par défaut</b>
                    </h4> 
                    <p>Les gôuts de l'équipe</p> 
                </div>
            </div>
        </div>


        <div class="col-4">
            <div class="card-theme">
                <img src="../public/img/theme_2.jpg" alt="Avatar" style="width:100%">
                <div class="card-theme-info">
                    <h4>
                        <b>Thème 2</b>
                    </h4> 
                    <p>Pour les joyeux</p>
                </div>
            </div>
        </div>


        <div class="col-4">
            <div class="card-theme">
                <img src="../public/img/theme_3.png" alt="Avatar" style="width:100%">
                <div class="card-theme-info">
                    <h4>
                        <b>Thème 3</b>
                    </h4> 
                    <p>Pour les grincheux</p> 
                </div>
            </div>
        </div>


    </div>
</div>

<script src="../public/js/modal_newv.js"></script>