<?php $inputData = $GLOBALS["_".strtoupper($data["config"]["method"])]; ?>

<form 
method="<?= $data["config"]["method"]?>" 
action="<?= $data["config"]["action"]?>"
id="<?= $data["config"]["id"]?>"
class="<?= $data["config"]["class"]?>">

      <?php foreach ($data["fields"] as $name => $configField):?>
        <div class="form-group">
          <div class="col-sm-12">


            <?php if($configField["type"] == "captcha"):?>
                <img src="script/captcha.php" width="600px">
            <?php endif;?>
            
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
                <?= (!empty($configField["required"])) ? "required='required'" : "" ?> >
        </div>
      </div>
      <?php endforeach;?>
      
  <button class="btn btn-primary"><?= $data["config"]["submit"];?></button>
</form>

