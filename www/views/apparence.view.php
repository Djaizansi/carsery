<div class="container">

    <h1>Apparence</h1>
    <p>Personnaliser l'apparence de votre dashboard selon vos préférences</p>

    <div class="col-3 txt-center">
        <p class="alert alert--info"><?php echo 'Thème actuelle : ' . $result; ?></p>
    </div>

    <div class="row">
        <div class="col-12 txt-center">
            <?php if (isset($msg)) { ?>
                <h4 class="alert alert--success" style="padding: 5px 5px 5px;">
                    <?php echo $msg; ?>
                </h4>
            <?php } else { ?>
                <h4 class="alert alert--info txt-center" style="padding: 5px 5px 5px;">
                    Deux nouveaux thèmes sont disponibles
                </h4>
            <?php } ?>
        </div>
    </div>

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

    <div class="row txt-center">
        <div class="col-12">
            <form action="apparence" method="post" class="box">
                <label for="theme-select">Choissisez un thème</label>
                <select name="theme" id="theme-select">
                    <?php foreach ($foundTheme as $theme) { ?>
                        <option value="<?php echo $theme->getId(); ?>"><?php echo $theme->getId() . ' - ' . $theme->getContent(); ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn" name="form">Appliquer</button>
            </form>
        </div>
    </div>
</div>