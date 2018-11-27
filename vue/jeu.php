<?php

Class VueJeu{

    public function jeu(){


if(!isset($_SESSION['villes'])) {
    echo "erreur de grille de jeu"; //TODO: il faudra rediriger vers page d'erreur
}
?>
<style>
    th {
        border: 1px solid black;
    }
    th {
        width: 50px;
        height: 50px;

        font-weight: bold;
    }
    th a {
        display: flex;
        flex-flow: column;
        justify-content: center;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: black;
    }
    th a#selected {
        background-color: green;
    }
    th a.blocked {
        background-color: red;
    }
</style>
<table>
<?php
$villes = unserialize($_SESSION['villes']);
$ponts = unserialize($_SESSION['ponts']);
$matricePonts = $ponts->matricePonts();
for ($y = 0; $y < 7; $y++){
    echo "<tr>";
    for ($x = 0; $x < 7; $x++){
        if ($villes->existe($x, $y)){
            if(isset($_SESSION['selectionne']) &&
                $_SESSION['selectionne']['x'] == $x && $_SESSION['selectionne']['y'] == $y) {
                echo "<th><a id='selected' href='index.php?x=". $x ."&y=". $y ."'>" . $villes->getVille($x, $y)->getNombrePontsMax() . "</a></th>";
            } else if ($villes->getVille($x, $y)->getNombrePonts() > $villes->getVille($x, $y)->getNombrePontsMax()) {
                //si la case est "bloquée" car trop de ponts pour sa capacité
                echo "<th><a class='blocked' href='index.php?x=". $x ."&y=". $y ."'>" . $villes->getVille($x, $y)->getNombrePontsMax() . "</a></th>";
            } else {
                echo "<th><a href='index.php?x=". $x ."&y=". $y ."'>" . $villes->getVille($x, $y)->getNombrePontsMax() . "</a></th>";
            }
        } else {
            if(isset($matricePonts[$x][$y])){
                echo "<th>". $matricePonts[$x][$y] ."</th>";
            } else {
                echo "<th></th>";
            }
        }
        //var_dump($villes->getVille($x, $y));
        /*if ($_SESSION['villes']->getVille($x, $y) != null) {
            echo "qqch";
            /*if(!is_array($_SESSION['villes'][$x][$y])){
                echo "<th>". $_SESSION['villes'][$x][$y] ."</th>";
            } else if ($_SESSION['villes'][$x][$y]['estSelectionne']){
                // Si la ville est selectionnée, on l'indique au joueur
                echo "<th><a id='selected' href='index.php?x=". $x ."&y=". $y ."'>" . $_SESSION['villes'][$x][$y]['nbPontsMax'] . "</a></th>";
            } else if($_SESSION['villes'][$x][$y]['nbPontsActuels'] >= $_SESSION['villes'][$x][$y]['nbPontsMax']) {
                // Si la ville a son max de ponts, on l'indique
                echo "<th><a class='blocked' href='index.php?x=". $x ."&y=". $y ."'>" . $_SESSION['villes'][$x][$y]['nbPontsMax'] . "</a></th>";
            } else {
                // Si la ville n'est ni selectionnée, ni max de ponts, on l'affiche juste
                echo "<th><a href='index.php?x=". $x ."&y=". $y ."'>" . $_SESSION['villes'][$x][$y]['nbPontsMax'] . "</a></th>";
            }*/
        /*} else {
            echo "rien";
            /*if(isset($_SESSION['ponts'][$x][$y])){
                echo "<th>pont</th>";
            } else {
                echo "<th></th>";
            }*/
        //}
    }
    echo "</tr>";
}
?>
</table>

<?php

}

}

?>