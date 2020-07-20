<div class="main-overview">

    <div class="overviewcard">
        <p>Véhicules déposés</p>

        <div class="overviewcard__icon">
            <p class="info"><?php echo $numberOfVoiture; ?></p>
        </div>

        <div class="overviewcard__info">
            <img src="./public/img/cars.png" alt="cars">
        </div>

    </div>

    <div class="overviewcard">
        <p>Pièces</p>

        <div class="overviewcard__icon">
            <p class="info"><?php echo $numberOfPiece; ?></p>
        </div>

        <div class="overviewcard__info">
            <img src="./public/img/piece.png" alt="piece">
        </div>
    </div>

    <div class="overviewcard">
        <p>Utilisateurs inscrits</p>

        <div class="overviewcard__icon">
            <p class="info"><?php echo $numberOfUser; ?></p>
        </div>
        <div class="overviewcard__info">
            <img src="./public/img/user.png" alt="user">
        </div>
    </div>
</div>

<div class="main-cards">
    <div class="card">
        Nombres de pages et de shortcodes.

        <div class="visitor">
            <canvas id="chartjs-1" height="240"></canvas>
        </div>

        <script>
            var val3 = "<?php echo $numberOfPage; ?>"
            var val4 = "<?php echo $numberOfShortcode; ?>"
            new Chart(document.getElementById("chartjs-1"), {
                type: "bar",
                data: {
                    labels: ["Pages", "Shortcode"],
                    datasets: [{
                        label: "My First Dataset",
                        data: [val3, val4],
                        fill: false,
                        backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)"],
                        borderColor: ["rgb(255, 99, 132)", "rgb(255, 159, 64)"],
                        borderWidth: 1,
                    }, ],
                },
                options: {
                    legend: {
                        display: false,
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                },
            });
        </script>
    </div>

    <div class="card">
        <p>Nouveautés</p>

        <ul class="check-list">
            <li>Ajout du français</li>
            <li>Nouvelle template</li>
            <li>Nouveaux thèmes</li>
            <li>Ajout du forum</li>
        </ul>
    </div>


    <div class="card">
        <div class="money">
            <canvas id="chartjs-4" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 470px;"></canvas>
            <script>
                var val1 = "<?php echo $numberOfPiece; ?>";
                var val2 = "<?php echo $numberOfVoiture; ?>";

                new Chart(document.getElementById("chartjs-4"), {
                    type: "doughnut",
                    data: {
                        labels: ["Pièce(s) disponible(s)", "Véhicule(s) disponible(s)"],
                        datasets: [{
                            label: "My First Dataset",
                            data: [val1, val2],
                            backgroundColor: ["rgb(54, 162, 235)", "rgb(255, 205, 86)"],
                        }, ],
                    },
                });
            </script>
        </div>
    </div>
</div>

<div class="main-footer">
    Liste des utilisateurs
    <div class="user_list">
        <table id="myTable" class="display">
            <thead>
                <th>Id</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Email</th>
                <th>Role</th>
            </thead>
            <tbody>
                <?php foreach ($foundAll as $unUser) : ?>
                    <tr>
                        <td><?= $unUser->getId() ?></td>
                        <td><?= $unUser->getLastname() ?></td>
                        <td><?= $unUser->getFirstname() ?></td>
                        <td><?= $unUser->getEmail() ?></td>
                        <td><?= $unUser->getStatus() ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>