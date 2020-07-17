<?php
use carsery\core\Helpers;

$listContact = $contactManager->findAll();
?>
<div class="container">
<?php if($_SESSION['success'] === 'deleteContact'): ?>
		<?= Helpers::alert('success','',"Le contact a bien été supprimé") ?>
        <?php $_SESSION['success'] = ''?>
    <?php elseif($_SESSION['success'] === 'updateContact'): ?>
        <?= Helpers::alert('success','',"Le contact a bien été modifié") ?>
        <?php $_SESSION['success'] = ''?>
        <?php elseif($_SESSION['success'] === 'addContact'): ?>
        <?= Helpers::alert('success','',"Le contact a bien été ajouté") ?>
        <?php $_SESSION['success'] = ''?>
    <?php elseif(isset($errors)): ?>
        <?= Helpers::alert('danger',$errors) ?>
	<?php endif ?>
<table id="myTable">
    <thead>
        <th>ID</th>
        <th>Adresse</th>
        <th>Nom</th>
        <th>Action</th>
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
                    <button data-modal-target="modal2" data-idcontact="<?= $unContact->getId() ?>" data-adresse="<?= $unContact->getAdresse() ?>" data-nom="<?= $unContact->getNom() ?>" class="myBtn" id="myBtn" href="#myBtn"><i class='fas fa-edit'></i></button> 
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<button data-modal-target="modal3" data-idcontact="" data-adresse="" data-nom="" class="btn" id="myBtn" href="#myBtn"><i class='icon-repeat'>Ajouter un contact</i></button></br>
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
			<a id="btnYesContact" class="btn btn--success">Oui</a>
			<a id="btnNo" class="btn btn--danger">Non</a>
        </div>
    </div>
    
    <div class="modal" id="modal2">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h3>Modification contact</h3>
            <?php $this->addModal("form", $formUpdateContact);?>
        </div>
    </div>
    <div class="modal" id="modal3">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h3>Ajouter un contact</h3>
            <?php $this->addModal("form", $formAddContact);?>
        </div>
    </div>