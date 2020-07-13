<?php
$listContact = $contactManager->findAll();
?>
<div class="container">
<table id="myTable">
    <thead>
        <th>ID</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Modifier</th>
    </thead>
    <tbody>
        <?php foreach($listContact as $unContact): ?>
            <tr>
                <td><?= $unContact->getId() ?></td>
                <td><?= $unContact->getAdresse() ?></td>
                <td><?= $unContact->getNom() ?></td>
                <td>
                            <!-- <a href="/modifier_page"><i class="fas fa-edit"></i></a> --> 
                            <button data-modal-target="modal1" data-id="<?= $unContact->getId() ?>" class="myBtn" id="myBtn" href="#myBtn"><i class="fas fa-trash-alt"></i></button>
                            <?= "<button data-modal-target='modal2' data-idcontact=".$unContact->getId()." data-nom=".$unContact->getNom()." data-adresse=".$unContact->getAdresse()." class='myBtn' id='myBtn' href='#myBtn'><i class='fas fa-edit'></i></button>"?> 

                        </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<form>
  <fieldset>
    <p>Souhaitez vous activer la page contact sur le front</p>

    <input type="radio" id="active" name="front" value="active" checked>
    <label for="active">Activer</label>
    <input type="radio" id="inactive" name="front" value="inactive">
      <button type="submit">Valider</button>
    </div>
  </fieldset>
</form>
</div>
<div class="modal" id="modal1"> <!-- This is the background overlay -->
        <div class="modal-content"> <!-- This is the actual modal/popup box -->
            <span class="modal-close">&times;</span>
            <p>Souhaitez-vous vraiment supprimer cette adresse?</p>
			<a id="btnYesUser" class="btn btn--success">Oui</a>
			<a id="btnNo" class="btn btn--danger">Non</a>
        </div>
    </div>
    
    <div class="modal" id="modal2">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h3>Modification contact</h3>
            <?php $this->addModal("form", $configFormUpdate);?>
        </div>
    </div>