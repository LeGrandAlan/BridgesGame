<?php

Class VueResultats
{
    public function resultats($partieGagnee, $resultatJoueur, $meilleursResultats) {
        if($partieGagnee) {
            echo "Vous avez gagné !<br>";
        } else {
            echo "Vous avez perdu..<br>";
        }
    ?>

    <h1>Vos statistiques</h1>
    <p>Nombre de parties gagnées : <?php echo $resultatJoueur; ?></p>

    <h1>Les meilleurs résultats</h1>
    <ul>
        <?php
        foreach ($meilleursResultats as $resultat){
            echo '<li>'. $resultat["pseudo"] .' : '. $resultat["partieGagnee"] .'</li>';
        }
        ?>
    </ul>

    <?php
    }
}