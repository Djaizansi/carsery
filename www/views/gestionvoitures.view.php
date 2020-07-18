
  <h2 align="center">Liste des Voitures</h2>
  
  <div align="center">
  
	  <button class="" type="button" id="addVoiture"> 
	  
			<img src="https://img.icons8.com/android/22/000000/car.png"/>

	  </button>
	  
	  <button class="" type="button" id="addMarque"> 
	  
			<img src="https://img.icons8.com/color/22/000000/bmw--v1.png"/>

	  </button>
	  
	  <button class="" type="button" id="addModele"> 
	  
			<img src="https://img.icons8.com/color/22/000000/mercedes-benz.png"/>

	  </button>
  
  </div>
  
  </br />

<div class="container">
	<table id="myTable" class="display">
		<thead>
		    <tr>

				<th>Matricule</th>
				<th>Marque</th>
				<th>Modèle</th>
		        <th>Km</th>
		        <th>Situation</th>
				<th>Etat</th>
				<th>Date Création</th>
				<th>Action</th>
				

		    </tr>
		</thead>
		<tbody>
			
			<?php 
			     $allVoitures = $this->data['allVoitures'] ;

			     if(!empty($allVoitures)) : ?>
		        
			     	<?php foreach($allVoitures as $voiture): ?>
				    <tr>
		

						<td><?=$voiture->getImmatriculation()?></td>
						<td><?=$voiture->getMarque()->getNomMarque()?></td>
						<td><?=$voiture->getModele()->getNomModele()?></td>
						<td><?=$voiture->getCompteur()?></td>
						<td><?=$voiture->getSituation()?></td>
						<td><?=$voiture->getEtat()?></td>
						<td><?=date("d/m/Y")?></td>
						<td>
							<!--<button>
								<a href="/editVoiture?id=<?=
								   $voiture->getId()?>">
								   <img src="https://img.icons8.com/metro/16/000000/edit-property.png"/>
								</a>
							</button>-->
						
							<button>
							
								<a onclick="return confirm('Etes-vous sure ?')" href="/removeVoiture?id=<?=$voiture->getId()?>">
									<img src="https://img.icons8.com/fluent/16/000000/delete-sign.png"/>
								</a>
							</button>
						</td>
					
				    </tr>
			    	
		        	<?php endforeach; ?>
		     <?php endif;?>

		</tbody>
    </table>

<script>

	$('#addVoiture').on('click',function(){
			
			window.location.replace('addVoiture');
	});
	
	$('#addMarque').on('click',function(){
		
		window.location.replace('addMarque');
	});

	
	$('#addModele').on('click',function(){
		
		window.location.replace('addModele');
});

</script>
</div>
