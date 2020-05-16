
	<table 
		class="table table-bordered"
		class="<?= $data["configDatatable"]["class"]??'' ?>" 
		id="<?= $data["configDatatable"]["id"]??'' ?>"
		width="<?= $data["configDatatable"]["width"]??'' ?>"
		cellspacing="<?= $data["configDatatable"]["cellspacing"]??'' ?>"
		class="display compact cell-border">

		<thead>
        
			<tr>
			
				<?php if(!empty($data["dataTable"]['nameColumnsDatatable'])) : ?>
						
					<?php foreach($data["dataTable"]['nameColumnsDatatable'] as $key => $value) : ?>
							
						<th><?=$value?></th>
						
					<?php endforeach; ?>
							
				<?php endif;?>		
			
			    
            </tr>
			
        </thead>
        
		<tfoot>

			<tr>
			
				<?php if(!empty($data["dataTable"]['nameColumnsDatatable'])) : ?>
						
					<?php foreach($data["dataTable"]['nameColumnsDatatable'] as $key => $value) : ?>
							
						<th><?=$value?></th>
						
					<?php endforeach; ?>
							
				<?php endif;?>	

            </tr>
			
        </tfoot>
                  
	    <tbody>
		
		<?php foreach ($data['dataTable']['rows'] as $rows) : ?>

	    	<tr>

	    		<?php foreach ($rows as $key => $value) : ?>

	    			<td><?=$value?></td>

	    		<?php endforeach;?>
		
           </tr>

       		<?php endforeach;?>
		
		</tbody>
		
	</table>