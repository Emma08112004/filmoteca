<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmoteca</title>
    <link rel="stylesheet" href="style.css"> 
<body>

<header>
    <h1>Filmoteca</h1>
    <h3>Bienvenue sur ce site internet énonçant toute la liste de films que nous proposons à la demande</h3>
    
    <nav>
        <a href="listefilms.html">Liste Films</a>
<a href="avis.html">Avis</a>

        
    </nav>
 



</body>
<h4>- FILMS TENDANCE -</h4>
<body>

    <div class="carrousel">
        <div class="slides">
            <div class="slide active">
                <img src="images/smile.jpeg" alt="Image 1">
            </div>
            <div class="slide">
                <img src="images/amourouf.webp" alt="Image 2">
            </div>
            <div class="slide">
                <img src="images/venom.jpg" alt="Image 3">
            </div>
            <div class="slide">
                <img src="images/gladiator2.webp" alt="Image 3">
            </div>
        </div>
        <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="next" onclick="changeSlide(1)">&#10095;</button>
    </div>
    
    <script src="script.js"></script>

   
    </body>



   
</html>
</header>
<footer> <nav>
    <br><a href="#home">Accueil</a>
    <a href="#about">À propos</a>
    <a href="#contact">Contact</a><br>
</nav></footer>

<?php
require_once 'Router.php';
$router = new Router();
$router->route();
?>
