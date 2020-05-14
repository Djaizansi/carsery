<div class="container">

    <h1>Apparence</h1>
    <p>Personnaliser l'apparence de votre dashboard selon vos préférences</p>

    <div class="col-3 txt-center">
        <p class="alert--primary">Thème actuel : <?php if(isset($theme)){ echo $theme; } ?></p>
    </div>

    <div class="row">

        <div class="col-4">
            <div class="card-theme">
                <img src="https://pbs.twimg.com/profile_images/791224628140183552/4ij9CwKo_400x400.jpg" alt="Avatar" style="width:100%">
                <div class="card-theme-info">
                    <h4>
                        <b>Par défaut</b>
                    </h4> 
                    <p>Les gôuts de l'équipe</p> 
                </div>
            </div>
        </div>


        <div class="col-4">
            <a id="myBtn">
            <div class="card-theme">
                <img src="https://stickeramoi.com/6737-large_default/autocollant-chiffre-deux.jpg" alt="Avatar" style="width:100%">
                <div class="card-theme-info">
                    <h4>
                        <b>Thème 2</b>
                    </h4> 
                    <p>Pour les joyeux</p>
                </div>
            </div>
            </a>
            <!-- Modal -->
            <div id="myModal" class="modal">
                <!-- Contenu du modal-->
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Thème 2</p>
                    <?php if(isset($_POST['formtheme'])){ ?>
                        <p>Le thème est déjà séléctionné.</p>
                    <?php } else { ?>
                        <form action="apparence/themes" method="post">
                            <input type="hidden" name="theme2" id="theme2" value="<?php if(isset($_POST['theme2'])) { echo $_POST['theme2'];} ?>">
                            <button type="submit" id="formtheme" name="formtheme">Selectionner ce thème</button>
                        </form>
                    <?php 
                    }
                    ?>
                </div>
            </div>
        </div>


        <div class="col-4">
            <div class="card-theme">
                <img src="https://files.cults3d.com/uploaders/14518571/illustration-file/1bdff2d0-99e2-4cf9-8518-e1475c538e6e/3_large.png" alt="Avatar" style="width:100%">
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