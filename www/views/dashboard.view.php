<div class="item item2">
            <div class="border">
                <h3>Statistiques visiteurs sur votre site (par millier de vue)</h3>    
            </div>
            <div>
                <canvas id="canvas"></canvas>
            </div>
            <br>
            <br>
            <button id="randomizeData">Randomize Data</button>
            <button id="addDataset">Add Dataset</button>
            <button id="removeDataset">Remove Dataset</button>
            <button id="addData">Add Data</button>
            <button id="removeData">Remove Data</button>
            <script src="/public/js/stats-html.js"></script>
        </div>
        
        <div class="item item3">
            <h3>Nombres de véhicules déposés</h3>
            <div class="details">
                <p>7</p>
            </div>
            <div class="img">
                <img src="/public/img/cars.png" alt="Voiture">
            </div>
        </div>
        
        <div class="item item4">
            <h3>Pièces détachées vendues</h3>
            <div class="details">
                <p>250</p>
            </div>
            <div class="img">
                <img src="/public/img/piece.png" alt="Pièce">
            </div>
        </div>
        
        <div class="item item5">
            <h3>Utilisateurs inscrits</h3>
            <div class="details">
                <p>21</p>
            </div>
            <div class="img">
                <img src="/public/img/user.png" alt="Utilisateur">
            </div>
        </div>
        
        <div class="item item6">
            <div class="border">
                <h3>Revenue du site</h3>
            </div>
            <canvas id="chartjs-4" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 770px;"></canvas>
            <script src="/public/js/revenue.js"></script>
        </div>
        
        
        <div class="item item7">
            <div class="border">
                <h3>Activités</h3>
            </div>
            <h4>Activités récentes effectuées</h4>
            <br>
            <ul>
                <li>
                    <p class="info">Juil 18/19, 11:55</p>
                    Ajout de la page contact
                </li>
                <br>
                <li>
                    <p class="info">Juil 13/19, 20:09</p>
                    Modification de la page d'inscription
                </li>
                <br>
                <li>
                    <p class="info">Juin 29/19, 08:47</p>
                    Création de l'utilisateur Technicien
                </li>
                <br>
                <li>
                    <p class="info">Juin 24/19, 14:30</p>
                    Modification du mot de passe
                </li>
            </ul>
        </div>

        <div class="item item8">
            <div class="border">
                <h3>Coup d'oeil</h3>
            </div>
            <ul>
                <li class="left"><i class="fas fa-file-alt"></i>4 pages</li>
                <br>
                <li class="left"><i class="fas fa-thumbtack"></i>35 topics</li>
                <br>
                <li class="left"><i class="fas fa-camera"></i>10 photos importées</li>
                <br>
                <li class="right"><i class="fas fa-comments"></i>2 forums</li>
                <br>
                <li class="right"><i class="fas fa-comment-dots"></i>13 commentaires</li>
            </ul>
        </div>

        <div class="item9">
            <div class="border">
                <h3>Utilisateurs inscrits récémment</h3>
            </div>
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Status</th>
                        <th>Inscription</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>43</td>
                        <td>JALLALI</td>
                        <td>Youcef</td>
                        <td>Client</td>
                        <td>17-01-2020</td>
                    </tr>
                    <tr>
                        <td>44</td>
                        <td>BOUABDELLAH</td>
                        <td>Marwane</td>
                        <td>Client</td>
                        <td>16-01-2020</td>
                    </tr>
                    <tr>
                        <td>45</td>
                        <td>DISPAGNE</td>
                        <td>Mel</td>
                        <td>Client</td>
                        <td>16-01-2020</td>
                    </tr>
                </tbody>
            </table>
        </div>