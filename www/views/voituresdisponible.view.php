
  <h2 align="center">Liste des Voitures Disponible
	<img src="https://img.icons8.com/color/50/000000/car-rental.png"/>
  </h2>


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
				

		    </tr>
		</thead>
		<tbody>
			
			<?php 
			     $allVoituresDisponible = $this->data['allVoituresDisponible'] ;

			     if(!empty($allVoituresDisponible)) : ?>
		        
			     	<?php foreach($allVoituresDisponible as $voitureDisponible): ?>
				    <tr>
		

						<td><?=$voitureDisponible->getImmatriculation()?></td>
						<td><?=$voitureDisponible->getMarque()->getNomMarque()?></td>
						<td><?=$voitureDisponible->getModele()->getNomModele()?></td>
						<td><?=$voitureDisponible->getCompteur()?></td>
						<td><?=$voitureDisponible->getSituation()?></td>
						<td><?=$voitureDisponible->getEtat()?></td>					
				    </tr>
			    	
		        	<?php endforeach; ?>
				<?php endif;?>

		</tbody>
    </table>

</div>
