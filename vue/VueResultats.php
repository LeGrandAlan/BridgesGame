<?php
require_once 'head.php';

/**
 * Class VueResultats
 */
Class VueResultats
{

    /**
     * Vue qui affiche les résultats
     * @param $partieGagnee bool vrai si la partie précédente est gagnées, faux si perdue
     * @param $partiesGagneesJoueur int nombre de parties gagnées par le joueur actuellement connecté
     * @param $partiesJoueesJoueur int nombre de parties jouées par le joueur actuellement connecté
     * @param $meilleursResultats array tableau contenant les 3 meilleurs joueurs en fonction de leur nombre de victoire
     * @param $ratios array tableau contenant les 3 meilleurs joueurs en fonction de leur ratio (parties gagnées/parties jouées)
     */
    public function resultats($partieGagnee, $partiesGagneesJoueur, $partiesJoueesJoueur, $meilleursResultats, $ratios) {
        if(isset($partieGagnee)){
            if($partieGagnee) {
                echo "<h1>Vous avez gagné !</h1>";
            } else if (!$partieGagnee) {
                echo "<h1>Vous avez perdu..</h1>";
            }
        }
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
            $i = 1;
            foreach ($meilleursResultats as $resultat){
                echo "<tr>";
                echo "<td>$i</td>";
                echo "<td>".$resultat['pseudo']."</td>";
                echo "<td>".$resultat['partiesGagnee']."</td>";
                echo "</tr>";
                ++$i;
            }
            ?>
        </table>

        <h1>Les meilleurs ratios</h1>
        <table class="resultat">
            <tr>
                <th>Place</th>
                <th>Pseudo</th>
                <th>Ratio parties gagnées/parties jouées</th>
            </tr>
            <?php if (empty($meilleursResultats)) echo "Personne n'a encore joué.."; ?>
            <?php
            $i = 1;
            foreach ($ratios as $ratio){
                echo "<tr>";
                echo "<td>$i</td>";
                echo "<td>".$ratio['pseudo']."</td>";
                echo "<td>".$ratio['ratio_victoire']."</td>";
                echo "</tr>";
                ++$i;
            }
            ?>
        </table>
        <div class="actions">
            <a href="index.php">Rejouer</a>
        </div>
        <?php
    }



}