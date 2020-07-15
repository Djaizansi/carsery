<div class="container">

	<table id="myTable" class="display" cellspacing="0" width="100%">
		<thead>
		    <tr>
				<th>Nom</th>
				<th>Description</th>
				<th>Prix</th>
				<th>Référence</th>
				<th>Quantité</th>
				<th>Stock</th>
				<th>Action</th>

		    </tr>
		</thead>
		<tbody>

		  <h2>Commande de pièces détachées
		  	<a href="/consultPanier" style="float:right;display:inline">
			   <img src="https://img.icons8.com/metro/52/000000/shopping-cart.png"/>
		        </a>
		  </h2>

		<?php foreach($this->data['pieces'] as $piece) : ?>
		
			  <tr>

				<td><?=$piece->getNomPiece()?></td>

				<td><?=$piece->getDescription();?></td>
				<td><?=number_format($piece->getPrix(),2)?> €</td>
				<td><?=$piece->getReference()?></td>

				<form action="/addPieceToPanier" method="POST">
					<td><input id="qte" type="number" 
						       name="quantite" 
						       value=""
						       min="1" 
						       max="<?=$piece->getStock()?>" 
						       required="required"
						       size="3px">
					</td>
					<td><?=$piece->getStock()?></td>
					<td>
						
					    <input type="hidden" name="idPiece" value="<?=$piece->getId()?>">
					    <button id="add" type="submit">
					           <img src="https://img.icons8.com/material-rounded/16/000000/shopping-cart.png">
					    </button>

					</td>
				</form>
			  </tr>

				<?php if($piece->getStock() == 0) : ?>

					<div class="alert alert--danger">
				
						 <?php print_r("La pièce détachée <strong>".$piece->getReference().
								"</strong> n 'est plus disponible en stock.");
						 ?>				
					</div>	
				
				<?php endif; ?>
			
			<?php endforeach;?>

		</tbody>
    </table>
</div>





