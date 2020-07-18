
  


<div class="container">

	<h2 align="center">Liste des Pièces détachées</h2><br />
	<button class="btn btn--primary" type="button" id="addPiece">Ajouter</button><br />

	<table id="myTable" class="display">
		<thead>
		    <tr>

			<th>Nom</th>
			<th>Description</th>
			<th>Prix</th>
			<th>Référence</th>
			<th>Stock</th>
			<th>Action</th>
				
		    </tr>
		</thead>
		<tbody>
			
			<?php 
			     $allPieces = $this->data['allPieces'] ;

			     if(!empty($allPieces)) : ?>
		        
			     	<?php foreach($allPieces as $piece): ?>
				    <tr>
		
						<td><?=$piece->getNomPiece()?></td>
						<td><?=$piece->getDescription()?></td>
						<td><?=number_format($piece->getPrix(),2)?> €</td>
						<td><?=$piece->getReference()?></td>
						<td><?=$piece->getStock()?></td>

						<td>
							
							 <button>
								<a href="/showFormUpdatePiece?id=<?=
								   $piece->getId()?>">
								   <img src="https://img.icons8.com/metro/16/000000/edit-property.png"/>
								</a>
							</button>
						
							<form method="POST" action="/removePiece">
							<input type="hidden" name="idPiece" value="<?=$piece->getId()?>">
							<button type="submit" onclick="return confirm('Etes-vous sure ?')"> 
								<img src="https://img.icons8.com/fluent/16/000000/delete-sign.png"/>
							</button>
							</form>
						</td>
					
				    </tr>
			    	
		        	<?php endforeach; ?>
		     <?php endif;?>

		</tbody>
    </table>

<script>
$('#addPiece').on('click',function(){
		
		window.location.replace('appendPiece');
});



</script>
</div>
