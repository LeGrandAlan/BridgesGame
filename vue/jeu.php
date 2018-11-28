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
    }
    echo "</tr>";
}
?>
</table>

<?php

}

}

?>