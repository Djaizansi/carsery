<?php use carsery\core\Helpers; ?>
<div class="container">


        <?php if(!empty($errors)): ?>
            <div class="alert alert--danger">
                <?php foreach($errors as $uneErreur): ?>
                    <p> <?=$uneErreur?> </p>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    
    <h2 align="center">Edit Piece</h2>

    <form method="POST" action="/editPiece" id="formEditPiece" class="box">
	<input 
          value="<?=$currentPiece->getId()?>"
          type="hidden"
          name="id"
          placeholder="">

    	<input 
          value="<?=$currentPiece->getNomPiece()?>"
          type="text"
          name="nom"
          placeholder="Votre nom"
          required='required' >
    
	<input 
          value="<?=$currentPiece->getDescription()?>"
          type="text"
          name="description"
          placeholder="Votre description"
          required='required' >
	
	<input 
          value="<?=$currentPiece->getPrix()?>"
          type="text"
          name="prix"
          placeholder="Prix : 20.25 et non 20,25 "
          required='required' >

    	<input 
          value="<?=$currentPiece->getReference()?>"
          type="text"
          name="reference"
          placeholder="reference"
          required='required' >

	<input 
          value="<?=$currentPiece->getStock()?>"
          type="number"
          name="stock"
          placeholder="Votre stock "
          required='required' >
 
  <br><br>
  <button class="btn btn--primary" id="btnAdd">Modifier</button>
  
  </form>

    <div class="txt-center">
        <a href="<?php echo Helpers::getUrl("Piece", "piece") ?>">Return to list of pieces</a>
    </div>
	
    
</div>

