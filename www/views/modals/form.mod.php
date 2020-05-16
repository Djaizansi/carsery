
<?php $inputData = $GLOBALS["_".strtoupper($data["config"]["method"])];?>


<form 
method="<?= $data["config"]["method"]?>" 
action="<?= $data["config"]["action"]?>"
id="<?= $data["config"]["id"]?>"
class="<?= $data["config"]["class"]?>">

	  <!--Récupération des informations-->
      <?php foreach ($data["fields"] as $name => $configField):?>
        <div class="form-group row">
          <div class="col-sm-12">

			<!--Si le champ est de type captcha : 
			
				* Intégration de l'image du captcha
				* Intégration d'un champ de type input [text]-->
            <?php if($configField["type"] == "captcha"):?>
			
                <img src="script/captcha.php" width="300px">

				<input 
					value="<?= (isset($inputData[$name]) && $configField["type"]!="password") ? $inputData[$name]:'' ?>"
					type="<?= $configField["type"]??'' ?>"
					name="<?= $name??'' ?>"
					placeholder="<?= $configField["placeholder"]??'' ?>"
					class="<?= $configField["class"]??'' ?>"
					id="<?= $configField["id"]??'' ?>"
					<?=(!empty($configField["required"]))?"required='required'":""?>>
				
			
			<!--Sinon si le champ est de type text ou number : 
			
				* Intégration d'un champ de type input [text]
				* Intégration d'un champ de type input [number]-->
			<?php elseif($configField["type"]== 'text' || $configField["type"]== 'number') : ?>

				<input 
					value="<?= (isset($inputData[$name]) && $configField["type"]!="password") ? $inputData[$name]:'' ?>"
					type="<?= $configField["type"]??'' ?>"
					name="<?= $name??'' ?>"
					placeholder="<?= $configField["placeholder"]??'' ?>"
					class="<?= $configField["class"]??'' ?>"
					id="<?= $configField["id"]??'' ?>"
					<?=(!empty($configField["required"]))?"required='required'":""?>>
					
			<!--Sinon si le champ est de type select: 
			
				* Intégration d'une liste déroulante-->
			<?php elseif($configField["type"]== 'select'):?>
			
				<select name="<?= $name??'' ?>" 
						class="<?= $configField["class"]??'' ?>"
						id="<?= $configField["id"]??'' ?>"
						<?=(!empty($configField["required"]))?"required='required'":""?>>
						
						<option value="" disabled="disabled">Veuillez choisir un(e) <?= $name??'' ?></option>
						
						<!--Si le tableau de la liste déroulante contenant les valeurs n'est pas vide : 
							* On parcours le tableau des clés
								* On parcours le tableau des valeurs
								* On affiche chaque valeur du tableau par la variable $value-->
						<?php if(!empty($configField['valuesInSelect'])) : ?>
						
							<?php foreach($configField['valuesInSelect'] as $values) : ?>

								<?php foreach ($values as $key => $value) : ?>
									
									<option value="<?= $value?>"
										<?=(isset($inputData[$name]) && $inputData[$name] == $value) ? "selected='selected'":""?>><?= $value?>
										
									</option>
							
								<?php endforeach; ?>

							<?php endforeach; ?>

							
						<?php endif;?>

				</select>
			
			<?php endif;?>


			
        </div>
      </div>
      <?php endforeach;?>

      <?php if(!empty($this->data['errors'])) print_r("<span>".implode("<br />",$this->data['errors'])."</span><br /><br />");?>

  <button class="btn btn-primary"><?= $data["config"]["submit"];?></button>
</form>

