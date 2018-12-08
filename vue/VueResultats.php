<?php
require_once 'head.php';
Class VueResultats
{

    public function resultats($partieGagnee, $partiesGagneesJoueur, $partiesJoueesJoueur, $meilleursResultats, $ratios) {
        if($partieGagnee) {
            echo "<h1>Vous avez gagné !</h1>";
        } else if ($partieGagnee) {
            echo "<h1>Vous avez perdu..</h1>";
        } // si $partieGagnee == null on n'affiche pas
    ?>

    <h1>Vos statistiques</h1>
    <div class="resultatText">
    <?php
        if(empty($partiesGagneesJoueur) || empty($partiesJoueesJoueur)) {
            echo "<p>Vous n'avez pas encore joué.</p>";
        } else {
            echo "<p>Nombre de parties gagnées : $partiesGagneesJoueur</p>";
            echo "<p>Nombre de parties jouées : $partiesJoueesJoueur</p>";
        }
    ?>
    </div>

    <h1>Les meilleurs résultats</h1>
    <table class="resultat">
    <tr>
        <th>Place</th>
        <th>Pseudo</th>
        <th>Nombre de parties gagnées</th>
    </tr>
    <?php if (empty($meilleursResultats)) echo "Personne n'a encore joué.."; ?>
        <?php
        foreach ($meilleursResultats as $resultat){
            echo "<tr>";
            echo "<td>1</td>";
            echo "<td>".$resultat['pseudo']."</td>";
            echo "<td>".$resultat['partiesGagnee']."</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h1>Les meilleurs ratios</h1>
    <table class="resultat">
    <tr>
        <th>Place</th>
        <th>Pseudo</th>
        <th>Ration parties gagnées/parties jouées</th>
    </tr>
    <?php if (empty($meilleursResultats)) echo "Personne n'a encore joué.."; ?>
        <?php
        foreach ($ratios as $ratio){
            echo "<tr>";
            echo "<td>1</td>";
            echo "<td>".$ratio['pseudo']."</td>";
            echo "<td>".$ratio['ratio_victoire']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
        <div class="actions">
            <a href="index.php">Rejouer</a>
        </div>
    <?php
    }



}