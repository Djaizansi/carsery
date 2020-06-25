<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>home-grid</title>
    <link rel="stylesheet" type="text/css" href="file:///Users/nesrine/Downloads/fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="../public/css/template2.css">
     <!-- Navbar déroulante pour mobile et tablette -->
   <script src="js/menu.js"></script>
   <script src="js/dropdown-btn.js"></script>
   
   
  
   
    
</head>

<body >
    <header class="header">
    <!--La nav blanche -->
    <div class="nav" >
        
        <div class = "logo"> 
           <img src="../home-grid/images/logo.png" alt="">
        </div>
        <div class ="search"> 
            <input label = "car-search" placeholder="Rechercher un produit... " class="fas fa-search" style="width: 20em" type = "text" class = "search-input">
           <button> <i class="fas fa-search"></i> </button> 
        </div>
        <div class = "ph-number">
                <i class="fas fa-phone-alt"> 01.45.09.34.56</i> 
        </div>
        <div class = "connect">
                <i class="fas fa-user"><a href="#" style="color: black">  Me connecter</a></i>
        </div>
        <div>
                <i class="fas fa-shopping-cart"> <a href="#" style="color: black">Mon panier</a></i>
        </div>
    </div>    

     <!--La nav grise -->
      <div class="navbar">
        <div><a href="#">Pieces auto</a></div> 
        <div><a href="#">Voitures</a></div>
        <div><a href="#">Devis</a></div>
        <div>
          Forum
        </div>
         <div><a href="#">Articles</a></div>
          <div>|</div>
          <div><a href="#">Aide</a></div>
           <div><a href="contact.php">Contacter</a></div>
          </div>

    </header>

        <main class="container">

            <div class="item item1">
                <div> TROUVER VOS PIECES AUTO </div> 
                <div> <hr size="3" color="orange"></div>
                <div> Rechercher par pièce </div>
                 <div class ="search">
                       <input label = "car-search" placeholder="En i..."   type = "text" class = "search-input">
                      
                </div>
                <div><hr class="hr"> </div> 
                <div>En sélectionnant mon véhicule</div>
                <div class="list">
                  <select class="option">
                    <option>Choisissez une marque</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                    <option>Option 4</option>
                    <option>Option 5</option>
                  </select>

                  <select class="option">
                     <option>Choisissez un modèle</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                     <option>Option 4</option>
                     <option>Option 5</option> 
                   </select>  

                   <select class="option">
                     <option>Choisissez une motorisation</option>
                     <option>Option 2</option>
                     <option>Option 3</option>
                     <option>Option 4</option>
                     <option>Option 5</option>
                   </select>
                </div>

                <button id="btn_option">Ok</button>
 
            </div>

       <!-- Carousel voitures -->

         <div class="item item2">
         <section class="carousel">
          <ul class="carousel-items">
              <li class="carousel-item">
                  <div class="card">
                      <img src="../home-grid/images/offresmercedeskroely-.jpg"/>
                      <div class="card-content">
                      </div>
                  </div>
              </li>
                   <li class="carousel-item">
                  <div class="card">
                      <img src="../home-grid/images/voiture.jpg" />
                      <div class="card-content">
                      </div> 
                  </div>
              </li>
            </li>
            <li class="carousel-item">
           <div class="card">
               <img src="../home-grid/images/agencement-concession.jpg" />
               <div class="card-content">
               </div>
           </div>
       </li>
      </li>
      <li class="carousel-item">
     <div class="card">
         <img src="../home-grid/images/car.png" />
         <div class="card-content">
         </div>
     </div>
      </li>
      <li class="carousel-item">
            <div class="card">
                <img src="https://placeimg.com/572/322/animals" />
                <div class="card-content">
                </div>
            </div>
             </li>
             <li class="carousel-item">
                  <div class="card">
                      <img src="https://placeimg.com/572/322/animals" />
                      <div class="card-content">
                      </div>
                  </div>
                   </li>
           
          </ul>
          </section>
  
            </div>

            <div class="item item3"><h2 style="margin-top: 1.5em;">Nos marques de voitures</h2></div>

            <!-- Carousel marques voitures  -->
            <div class="item item4">
                  <section class="carousel2">
                        <ul class="carousel2-items">
                            <li class="carousel2-item">
                                <div class="card">
                                    <img src="../home-grid/images/citroen.jpg" />
                                    <div class="card-content">
                                    </div>
                                </div>
                            </li>
                                 <li class="carousel2-item">
                                <div class="card">
                                    <img src="../home-grid/images/audi.jpg" />
                                    <div class="card-content">
                                    </div>
                                </div>
                            </li>
                          </li>
                          <li class="carousel2-item">
                         <div class="card">
                             <img src="../home-grid/images/Toyota.jpg" />
                             <div class="card-content">
                             </div>
                         </div>
                     </li>
                    </li>
                    <li class="carousel2-item">
                   <div class="card">
                       <img src="../home-grid/images/ford.jpg" />
                       <div class="card-content">
                       </div>
                   </div> 
                    </li>
                    <li class="carousel2-item">
                          <div class="card">
                              <img src="../home-grid/images/mercedes.jpg" />
                              <div class="card-content">
                              </div>
                          </div>
                           </li>
                           <li class="carousel2-item">
                                <div class="card">
                                    <img src="../home-grid/images/Alfa-Romeo.png" />
                                    <div class="card-content">
                                    </div>
                                </div>
                                 </li>
                         
                        </ul>
                        </section>
            </div>

            <div class="item item5"><h2 style="margin-top: 1.5em;" >Nos pièeces détachées auto</h2> </div>
        </main>
        
        <section class="article">

           <div class="box box1"> <div classe="omar"> <img src="../home-grid/images/frein.jpg" > <p>FRAINAGE</p>   </div>
                <div> <hr size="5" color="orange"></div>
                <div><a href="#">Pieces auto</a></div>
                <div><a href="#">Voitures</a></div>
                <div><a href="#">Devis</a></div>
                <div><a href="#">Forum</a></div>
                <div><a href="#">Articles</a></div>
                <div class="dropdown">
                        <button onclick="myFunction()" class="dropbtn"> Voir plus</button>
                        <div id="myDropdown" class="dropdown-content">
                          <a href="#home">pneu</a>
                          <a href="#about">volant</a>
                          <a href="#contact">cuisse</a>
                        </div>
                      </div>
            </div>
            <div class="box box2 "> FILTRATION - HUILE - VIDANGE
                    <div> <hr size="5" color="orange"></div>
                    <div><a href="#">Pieces auto</a></div>
                    <div><a href="#">Voitures</a></div>
                    <div><a href="#">Devis</a></div>
                    <div><a href="#">Forum</a></div>
                    <div><a href="#">Articles</a></div>
                    <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"> Voir plus</button>
                            <div id="myDropdown" class="dropdown-content">
                              <a href="#home">pneu</a>
                              <a href="#about">volant</a>
                              <a href="#contact">cuisse</a>
                            </div>
                          </div>
            </div>
            <div class="box box3">SUSPENTION-DIRECTION
                    <div> <hr size="5" color="orange"></div>
                    <div><a href="#">Pieces auto</a></div>
                    <div><a href="#">Voitures</a></div>
                    <div><a href="#">Devis</a></div>
                    <div><a href="#">Forum</a></div>
                    <div><a href="#">Articles</a></div>
                    <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"> Voir plus</button>
                            <div id="myDropdown" class="dropdown-content">
                              <a href="#home">pneu</a>
                              <a href="#about">volant</a>
                              <a href="#contact">cuisse</a>
                            </div>
                          </div>
            </div>
            <div class="box box4">COMPARTIMENT MOTEUR
                    <div> <hr size="5" color="orange"></div>
                    <div><a href="#">Pieces auto</a></div>
                    <div><a href="#">Voitures</a></div>
                    <div><a href="#">Devis</a></div>
                    <div><a href="#">Forum</a></div>
                    <div><a href="#">Articles</a></div>
                    <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"> Voir plus</button>
                            <div id="myDropdown" class="dropdown-content">
                              <a href="#home">pneu</a>
                              <a href="#about">volant</a>
                              <a href="#contact">cuisse</a>
                            </div>
                          </div>
            </div>
            <div class="box box5">EQUIPEMENT EXTERIEUR
                    <div> <hr size="5" color="orange"></div>
                    <div><a href="#">Pieces auto</a></div>
                    <div><a href="#">Voitures</a></div>
                    <div><a href="#">Devis</a></div>
                    <div><a href="#">Forum</a></div>
                    <div><a href="#">Articles</a></div>
                    <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"> Voir plus</button>
                            <div id="myDropdown" class="dropdown-content">
                              <a href="#home">pneu</a>
                              <a href="#about">volant</a>
                              <a href="#contact">cuisse</a>
                            </div>
                          </div>
            </div>
            <div class="box box6">PIECES D'ECHAPPEMENT
                    <div> <hr size="5" color="orange"></div>
                    <div><a href="#">Pieces auto</a></div>
                    <div><a href="#">Voitures</a></div>
                    <div><a href="#">Devis</a></div>
                    <div><a href="#">Forum</a></div>
                    <div><a href="#">Articles</a></div>
                    <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"> Voir plus</button>
                            <div id="myDropdown" class="dropdown-content">
                              <a href="#home">pneu</a>
                              <a href="#about">volant</a>
                              <a href="#contact">cuisse</a>
                            </div>
                          </div>
            </div>
            <div class="box box7">REFROIDISSEMENT MOTEUR
                    <div> <hr size="5" color="orange"></div>
                    <div><a href="#">Pieces auto</a></div>
                    <div><a href="#">Voitures</a></div>
                    <div><a href="#">Devis</a></div>
                    <div><a href="#">Forum</a></div>
                    <div><a href="#">Articles</a></div>
                    <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"> Voir plus</button>
                            <div id="myDropdown" class="dropdown-content">
                              <a href="#home">pneu</a>
                              <a href="#about">volant</a>
                              <a href="#contact">cuisse</a>
                            </div>
                          </div>
            </div>
            <div class="box box8">EMBRAYAGES-TRANSMISSION
                    <div> <hr size="5" color="orange"></div>
                    <div><a href="#">Pieces auto</a></div>
                    <div><a href="#">Voitures</a></div>
                    <div><a href="#">Devis</a></div>
                    <div><a href="#">Forum</a></div>
                    <div><a href="#">Articles</a></div>
                    <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"> Voir plus </button>
                            <div id="myDropdown" class="dropdown-content">
                              <a href="#home">pneu</a>
                              <a href="#about">volant</a>
                              <a href="#contact">cuisse</a>
                            </div>
                          </div>
            </div>
          
        </section>
        
        <footer class="footer">
            <div class="newsletter">
                <label id="nws" for="email"> NEWSLETTER </label>
                <input type="email" name="email" id="email" required  >
                <button id="ok">Ok</button>
                <div id="res"> RÉSEAUX SOCIAUX </div>
            </div> 

                <section class="infos">
                   
                </section>
        </footer>

</body>
</html>