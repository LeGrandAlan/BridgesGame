<?php

Class VueResultats
{
    public function resultats($partieGagnee, $partiesGagneesJoueur, $partiesJoueesJoueur, $meilleursResultats, $ratios) {
        if($partieGagnee) {
            echo "Vous avez gagné !<br>";
        } else if ($partieGagnee) {
            echo "Vous avez perdu..<br>";
        } // si $partieGagnee == null on n'affiche pas
    ?>

    <h1>Vos statistiques</h1>
    <?php
        if(empty($partiesGagneesJoueur) || empty($partiesJoueesJoueur)) {
            echo "<p>Vous n'avez pas encore joué.</p>";
        } else {
            echo "<p>Nombre de parties gagnées : $partiesGagneesJoueur</p>";
            echo "<p>Nombre de parties jouées : $partiesJoueesJoueur</p>";
        }
    ?>

    <h1>Les meilleurs résultats</h1>
    <?php if (empty($meilleursResultats)) echo "Personne n'a encore joué.."; ?>
    <ol>
        <?php
        foreach ($meilleursResultats as $resultat){
            echo '<li>'. $resultat["pseudo"] .' : '. $resultat["partiesGagnee"] .'</li>';
        }
        ?>
    </ol>

    <h1>Les meilleurs ratios</h1>
    <?php if (empty($meilleursResultats)) echo "Personne n'a encore joué.."; ?>
    <ol>
        <?php
        foreach ($ratios as $ratio){
            echo '<li>'. $ratio["pseudo"] .' : '. $ratio["ratio_victoire"] .'</li>';
        }
        ?>
    </ol>

    <?php
    }



}