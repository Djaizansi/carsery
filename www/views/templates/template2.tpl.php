<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Template 2 -home page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../public/css/template2.css">
    <!-- Navbar déroulante pour mobile et tablette -->
    <script src="js/menu.js"></script>
   <script src="../public/js/dropdown-btn.js"></script>
    
</head>


<body >
    <header class="header">
    <!--La nav blanche -->
    <div class="nav" >
        
        <div class = "logo"> 
           <img src="../public/img/logo.png" alt="">
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
            <a href="#">Forum</a></div>
        </div>
         <div><a href="#">Articles</a></div>
          <div>|</div>
          <div><a href="#">Aide</a></div>
           <div><a href="contact.php">Contacter</a></div>
          </div>

    </header>

        <main class="container">
            
        </main>

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