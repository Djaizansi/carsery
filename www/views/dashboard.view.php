    <div class="main-overview">

        <div class="overviewcard">
            <p>Véhicules déposés</p>

            <div class="overviewcard__icon">
                <p class="info">344</p>
            </div>

            <div class="overviewcard__info">
                <img src="./public/img/cars.png" alt="cars">
            </div>
            
        </div>

        <div class="overviewcard">
            <p>Pièces vendues</p>

            <div class="overviewcard__icon">
                <p class="info">212</p>
            </div>

            <div class="overviewcard__info">
                <img src="./public/img/piece.png" alt="piece">
            </div>
        </div>

        <div class="overviewcard">
            <p>Utilisateurs inscrits</p>

            <div class="overviewcard__icon">
                <p class="info">976</p>
            </div>
            <div class="overviewcard__info">
                <img src="./public/img/user.png" alt="user">
            </div>
        </div>
    </div>

    <div class="main-cards">
        <div class="card">
            Nombre de visiteurs sur votre site (par millier de vue)

            <div class="visitor">
                <canvas id="canvas" height="240"></canvas>
            </div>

        <script src="./public/js/visitor.js"></script>
        </div>

        <div class="card">
            Activité récente
            <table>
                <thead>
                    <th>Date de l'activité</th>
                    <th>Ajout ou modification</th>
                </thead>

                <tr>
                    <td>Juin 24/19, 14:30</td>
                    <td>Ajout de la page contact</td>
                </tr>

                <tr>
                    <td>Juil 13/19, 20:09</td>
                    <td>Modification de la page d'inscription</td>
                </tr>

                <tr>
                    <td>Juin 29/19, 08:47</td>
                    <td>Création de l'utilisateur Technicien</td>
                </tr>

                <tr>
                    <td>Juin 24/19, 14:30</td>
                    <td>Modification du mot de passe</td>
                </tr>
            </table>
        </div>


        <div class="card">
            Statistiques
            <div class="money">
                <canvas id="chartjs-4" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 470px;"></canvas>
                <script src="./public/js/money.js"></script>
            </div>
        </div>
    </div>

    <div class="main-footer">
        Liste des utilisateurs
        <div class="user_list">
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
    </div>