<div class="container">

    <h1>Apparence</h1>
    <p>Personnaliser l'apparence de votre dashboard selon vos préférences</p>

    <div class="row">

        <?php foreach ($foundTheme as $theme) { ?>
            <div class="col-4">
                <div class="card-theme">
                    <img src="../public/img/theme.jpg" alt="Thème" style="width:100%">
                    <div class="card-theme-info">
                        <h4>
                            <b><?php echo $theme->getTitle(); ?></b>
                        </h4>
                        <p><?php echo $theme->getContent(); ?></p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </div>
</div>