<div class="container">
	
	<table id="myTable" class="display" cellspacing="0" width="100%">

		<thead>
		    <tr>
				<th>Nom</th>
				<th>Prix</th>
				<th>Référence</th>
				<th>Qté</th>
				<th>Total</th>
				<th>Action</th>
		    </tr>
		</thead>
		<tbody>

		  <h2>Mon Panier<br /><br />
			<a href="/commandPiece" style="float:right;display:inline">
			   <img src="https://img.icons8.com/nolan/52/administrative-tools.png"/>
			</a>
			
			</a>
			<?php print_r(number_format($this->data['sommePanier'],2));?><a style="left:right;display:inline">
			   <img src="https://img.icons8.com/small/32/000000/euro-pound-exchange.png"/>
			</a>			
			
			<?php echo $nbPiecesPanierUser." "?> <a href="#" style="left:right;display:inline">
			   <img src="https://img.icons8.com/android/40/000000/ingredients.png"/>
			</a>

		  </h2>

		  <?php foreach($this->data['userPanier'] as $panier) : ?>
		
			  <tr>

				<td><?=$panier->getPiece()->getNomPiece()?></td>
				<td><?=number_format($panier->getPiece()->getPrix(),2)?> €</td>
				<td><?=$panier->getPiece()->getReference()?></td>

				<form action="/updateQteDeletePiece" method="POST">
					<td><input type="number" 
						       name="quantite"
						       value="<?=$panier->getQuantite()?>"
						       min="1"
						       max="<?=$panier->getPiece()->getStock() + $panier->getQuantite()?>"
						       size="3px"
						       required="required">
					</td>

					<?php $prix= $panier->getPiece()->getPrix() * $panier->getQuantite();?>

					<td><strong><?=number_format($prix,2)?> €</strong></td>
					<td>
						
						<input type="hidden" name="idPiece" value="<?=$panier->getPiece()->getId()?>">
						<input type="hidden" name="idPanier" value="<?=$panier->getId()?>">

					        <button type="submit">
							<img src="https://img.icons8.com/windows/20/000000/save-to-grid.png"/>
						</button>

					        <button type="submit" onclick="return confirm('Etes-vous sure ?')">
							<img src="https://img.icons8.com/plasticine/20/000000/filled-trash.png"/>
						</button>

					</td>

				</form>

			  </tr>
			 
			<?php endforeach;?>
		</tbody>
    </table>
</div>








