<div class="container">
    <h1>Apparence</h1>
    <p>Personnaliser l'apparence de votre dashboard selon vos préférences</p>

    <?php

    /* Test variable
    if(isset($myTheme1)){
        echo $myTheme1;
    }
    */
    ?>

    <!-- Trigger/Open The Modal -->
    <button id="myBtn">Open Modal</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
                <p>Some text in the Modal..</p>
        </div>
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
            <div class="card-theme">
                <img src="https://stickeramoi.com/6737-large_default/autocollant-chiffre-deux.jpg" alt="Avatar" style="width:100%">
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