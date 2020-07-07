<?php
$listContact = $contactManager->findAll();
$data = $listContact;
?>
<div class="container">
<table id="userTable">
    <thead>
        <th>ID</th>
        <th>Nom</th>
        <th>Adresse</th>
    </thead>
    <tbody>
        <?php foreach($data as $unContact): ?>
            <tr>
                <td><?= $unContact->getId() ?></td>
                <td><?= var_dump($unContact->getNom()) ?></td>
                <td><?= $unContact->getAdresse() ?></td>
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
</form>
</div>
