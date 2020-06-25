<?php

use carsery\Managers\PageManager;

$inputData = $GLOBALS["_".strtoupper($data["config"]["method"])]; ?>

<form 
method="<?= $data["config"]["method"]?>" 
action="<?= $data["config"]["action"]?>"
id="<?= $data["config"]["id"]?>"
class="<?= $data["config"]["class"]?>">


      <?php foreach ($data["fields"] as $name => $configField):?>
        <!-- <div class="form-group row">
          <div class="col-sm-12"> -->


            <?php if($configField["type"] == "captcha"):?>
                <img src="script/captcha.php" width="300px">
            <?php endif;?>

            <?php if($configField["type"] == "checkbox"): ?>
                <p>Voulez-vous ajouter cette page au menu ? </p>
            <?php endif ?>

            <?php if($configField["balise"] === "textarea"): ?>
              <textarea
                value="<?= (isset($inputData[$name])) ? $inputData[$name] : '' ?>"
                name="<?= $name??'' ?>"
                id="<?= $configField["id"]??'' ?>"
                type="<?= $configField["type"]??'' ?>"
                placeholder="<?= $configField["placeholder"]??'' ?>"
              >
              <?php if(empty($configField["placeholder"])): ?>
                  <?php $pageManager = new PageManager() ?>
                  <?php $pageFound = $pageManager->find($_GET['id']) ?>
                  <?php $titre = $pageFound->getTitre() ?>
                  <?php $notiret = str_replace(' ','',strtolower($titre)) ?>
                  <?= file_get_contents("Views/$notiret.view.php") ?>
              <?php else: ?>
              <?php endif ?>

              </textarea>
            <?php else: ?>
              <input 
                  value="<?= (isset($inputData[$name]) && $configField["type"]!="password") ? $inputData[$name] : '' ?>"
                    <?php  /* $inputData -> $_POST | $name => les champs : firstname, lastname, email ... | $inputdData[$name]
                    => $_POST[$name]=> ex: $_POST["firstname"] 
                    value ici permet de stocker la valeur et de la laisser dans le champs */ ?>
                  type="<?= $configField["type"]??'' ?>"
                  name="<?= $name??'' ?>"
                  placeholder="<?= $configField["placeholder"]??'' ?>"
                  class="<?= $configField["class"]??'' ?>"
                  id="<?= $configField["id"]??'' ?>"
                  value="<?= $configField["value"]??'' ?>"
                  <?= (!empty($configField["required"])) ? "required='required'" : "" ?> >
            <?php endif ?>
        <!--  </div>
      </div> -->
      <?php endforeach;?>
    


  <br><br>
  <button class="btn btn--primary" id="btnAdd"><?= $data["config"]["submit"];?></button>
</form>