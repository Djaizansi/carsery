<?php

use carsery\core\Helpers;
$files = glob("./public/images_upload/*.*");
$alert = isset($alert) ? $alert : '';
?>

<div class="container">
	<?php if($alert == 1): ?>
		<?= Helpers::alert('success','',"L'image a bien été uploadé") ?>
		<?php $alert = 0 ?>
	<?php elseif($alert == "image"): ?>
		<?= Helpers::alert('danger','',"L'image uploadé n'est pas valide : JPG, PNG, JPEG autorisé") ?>
		<?php $alert = 0 ?>
	<?php elseif($_SESSION['success'] === 1): ?>
		<?= Helpers::alert('success','',"L'image a bien été supprimé") ?>
		<?php $_SESSION['success'] = ''?>
	<?php endif ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
            <h2 class="txt-center">Ajout d'image dans la bibliothèque</h2>
            <div style="margin: 0 auto;" class="file-drop-area">
				<span class="fake-btn"><i class="fas fa-download"></i></span>
				<span class="file-msg">Faites glisser vos documents ici</span>
				<input class="file-input" type="file" name="file[]" multiple accept="image/png, image/jpeg, image/jpg">
			</div>
		</div>
		<br>
		<button style="display: block; margin: 0 auto;" class="btn btn--primary" type="submit" name="upload">Enregistrer</button>
    </form>
    <br>
    <h2 class="txt-center">Bibliothèque</h2>
    <table id="myTable" class="display" style="width: 800px !important; ">
        <thead>
            <th>Image</th>
            <th>Nom</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php foreach($files as $file): ?>
            <tr>
                <td>
					<img src="<?=$file?>" style="width:100px !important; height:100px !important;" alt="Image" />
				</td>
				<td><?= pathinfo($file, PATHINFO_FILENAME) ?></td>
				<td>
					<?php $newFile = explode('/',$file) ?>
					<button data-modal-target="modal1" data-file="<?=$newFile[3]?>" class="file" id="myBtn" href="#myBtn"><i class="fas fa-trash-alt"></i></button>
				</td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<div class="modal" id="modal1"> <!-- This is the background overlay -->
        <div class="modal-content"> <!-- This is the actual modal/popup box -->
            <span class="modal-close">&times;</span>
            <p>Souhaitez-vous vraiment supprimer cette Image?</p>
			<a id="btnYesFile" class="btn btn--success">Oui</a>
			<a id="btnNo" class="btn btn--danger">Non</a>
        </div>
    </div>

<script>
		var $fileInput = $('.file-input');
		var $droparea = $('.file-drop-area');

		// highlight drag area
		$fileInput.on('dragenter focus click', function() {
			$droparea.addClass('is-active');
		});

		// back to normal state
		$fileInput.on('dragleave blur drop', function() {
			$droparea.removeClass('is-active');
		});

		// change inner text
		$fileInput.on('change', function() {
			var filesCount = $(this)[0].files.length;
			var $textContainer = $(this).prev();

			if (filesCount === 1) {
				// if single file is selected, show file name
				var fileName = $(this).val().split('\\').pop();
				$textContainer.text(fileName);
			} else {
				// otherwise show number of files
				$textContainer.text(filesCount + ' Fichiers selectionnés');
			}
		});
</script>