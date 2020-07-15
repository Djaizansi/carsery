<?php use carsery\core\Helpers;
use carsery\core\Session;
use carsery\Managers\UserManager;

?>
<div class="container">
	<?php if($_SESSION['success'] === 'suppUser'): ?>
		<?= Helpers::alert('success','',"L'utilisateur a bien été supprimé") ?>
        <?php $_SESSION['success'] = ''?>
    <?php elseif($_SESSION['success'] === 'updateUser'): ?>
        <?= Helpers::alert('success','',"L'utilisateur a bien été modifié") ?>
        <?php $_SESSION['success'] = ''?>
    <?php elseif(isset($errors)): ?>
        <?= Helpers::alert('danger',$errors) ?>
	<?php endif ?>

    <h2>Gestion utilisateur</h2>
    <table id="myTable" class="display">
        <thead>
            <th>Id</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php foreach($foundAll as $unUser): ?>
            <tr>
                <td><?=$unUser->getId()?></td>
                <td><?=$unUser->getLastname()?></td>
                <td><?=$unUser->getFirstname()?></td>
                <td><?=$unUser->getEmail()?></td>
                <td><?=$unUser->getStatus()?></td>
                <td>
                    <?= (($_SESSION['id'] == $unUser->getId()) || ($unUser->getStatus() === "Admin")) ? '' : "<button data-modal-target='modal1' data-id=".$unUser->getId()." class='myBtn' id='myBtn' href='#myBtn'><i class='fas fa-trash-alt'></i></button>" ?>
                    <?= $unUser->getStatus() === "Admin" &&  $_SESSION['id'] != $unUser->getId() ? 'Administrateur' : "<button data-modal-target='modal2' data-iduser=".$unUser->getId()." data-prenom=".$unUser->getFirstname()." data-nom=".$unUser->getLastname()." data-email=".$unUser->getEmail()." data-role=".$unUser->getStatus()." class='myBtn' id='myBtn' href='#myBtn'><i class='fas fa-edit'></i></button>"?> 
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

    <div class="modal" id="modal1"> <!-- This is the background overlay -->
        <div class="modal-content"> <!-- This is the actual modal/popup box -->
            <span class="modal-close">&times;</span>
            <p>Souhaitez-vous vraiment supprimer cette utilisateur?</p>
			<a id="btnYesUser" class="btn btn--success">Oui</a>
			<a id="btnNo" class="btn btn--danger">Non</a>
        </div>
    </div>
    
    <div class="modal" id="modal2">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h3>Modification utilisateur</h3>
            <?php $this->addModal("form", $configFormUpdate);?>
        </div>
    </div>