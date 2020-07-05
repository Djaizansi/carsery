<?php
$files = glob("./public/images_upload/*.*");
?>

<div class="container">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
            <h2>Ajout d'image dans la bibliothèque</h2>
            <div class="file-drop-area">
				<span class="fake-btn"><i class="fas fa-download"></i></span>
				<span class="file-msg">Faites glisser vos documents ici</span>
				<input class="file-input" type="file" name="file[]" multiple accept="image/png, image/jpeg, image/jpg">
			</div>
            <button class="btn btn--primary" type="submit" name="upload">Enregistrer</button>
        </div>
    </form>
    <br>
    <h2>Bibliothèque</h2>
    <table id="myTable" class="display">
        <thead>
            <th>Image</th>
            <th>Nom</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php foreach($files as $file): ?>
            <tr>
                <td><img src="<?=$file?>" style="width:100px !important; height:100px !important;" alt="Image" /></td>
                <td><?= pathinfo($file, PATHINFO_FILENAME) ?></td>
                <td>Test</td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

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
				$textContainer.text(filesCount + ' files selected');
			}
		});
</script>