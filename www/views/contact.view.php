<?php
$listContact = $contactManager->findAll();
?>
<div class="container">
<table id="myTable">
    <thead>
        <th>ID</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Modifier</th>
    </thead>
    <tbody>
        <?php foreach($listContact as $unContact): ?>
            <tr>
                <td><?= $unContact->getId() ?></td>
                <td><?= $unContact->getAdresse() ?></td>
                <td><?= $unContact->getNom() ?></td>
                <td>
                            <!-- <a href="/modifier_page"><i class="fas fa-edit"></i></a> --> 
                            <button data-modal-target="modal1" data-id="<?= $unContact->getId() ?>" class="myBtn" id="myBtn" href="#myBtn"><i class="fas fa-trash-alt"></i></button>
                            <a <?=$unContact->getId()?>><i class="fas fa-edit"></i></a>
                        </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<form>
  <fieldset>
    <p>Souhaitez vous activer la page contact sur le front</p>

    <input type="radio" id="active" name="front" value="active" checked>
    <label for="active">Activer</label>
    <input type="radio" id="inactive" name="front" value="inactive">
      <button type="submit">Valider</button>
    </div>
  </fieldset>
  <!-- <script>
  var myTable = $('#userTable').DataTable();
 
 $('#userTable').on( 'click', 'tbody tr', function () {
     myTable.row( this ).edit( {
         buttons: [
             { label: 'Cancel', fn: function () { this.close(); } },
             'Edit'
         ]
     } );
 } );
 </script> -->
</form>
</div>