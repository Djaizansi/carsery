<?php

use carsery\Managers\PageManager;
use carsery\Managers\UserManager;

$inputData = $GLOBALS["_".strtoupper($data["config"]["method"])]; 
$pageManager = new PageManager();
$userManager = new UserManager();


if(isset($_GET['id'])){
  $pageFound = $pageManager->find($_GET['id']);
  $menu = $pageFound->getMenu();
  $public = $pageFound->getPublie();
  $home = $pageFound->getHome();
}

$arrayRole = ['Admin','Client'];
?>
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

            <?php if($configField["id"] == "id_checkbox_public"): ?>
                <p>Voulez-vous publier cette page ? </p>
                
            <?php endif ?>

            <?php if($configField["id"] == "id_checkbox"): ?>
                <p>Voulez-vous ajouter cette page au menu ? </p>
            <?php endif ?>

            <?php if($configField["id"] == "id_checkbox_home"): ?>
                <p>Doit-elle être la page d'accueil ? </p>
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
                  <?= $content = $pageFound->getContent() ?>
              <?php else: ?>
              <?php endif ?>
              </textarea>

            <?php elseif($configField['balise'] === "select"): ?>
              <select
                name="<?= $name??'' ?>"
                id="<?= $configField["id"]??'' ?>"
                type="<?= $configField["type"]??'' ?>"
                placeholder="<?= $configField["placeholder"]??'' ?>"
              >
                <?php foreach($arrayRole as $unRole): ?>
                      <option value="<?= $unRole ?>"><?= $unRole ?></option>
                <?php endforeach ?>
              </select>
            <?php else: ?>
              <input 
                  value="<?= (isset($inputData[$name]) && $configField["type"]!="password") ? $inputData[$name] : '' ?>"
                  type="<?= $configField["type"]??'' ?>"
                  name="<?= $name??'' ?>"
                  placeholder="<?= $configField["placeholder"]??'' ?>"
                  class="<?= $configField["class"]??'' ?>"
                  id="<?= $configField["id"]??'' ?>"
                  value="<?= $configField["value"]??'' ?>"
                  <?= (!empty($configField["required"])) ? "required='required'" : "" ?>
                  <?= (!empty($configField["hidden"])) ? "hidden" : "" ?>
                  <?php if(isset($_GET['id'])): ?>
                    <?= $configField["id"] == "id_checkbox_public" && $public == 1 ? 'checked' : '' ?>
                    <?= $configField["id"] == "id_checkbox" && $menu == 1  ? 'checked' : '' ?>
                    <?= $configField["id"] == "id_checkbox_home" && $home == 1  ? 'checked' : '' ?>
                  <?php endif ?>
                  >
            <?php endif ?>
        <!--  </div>
      </div> -->
      <?php endforeach;?>
    


  <br><br>
  <button class="btn btn--primary" id="btnAdd"><?= $data["config"]["submit"];?></button>
</form>