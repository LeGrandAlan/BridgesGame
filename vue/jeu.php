<?php

Class VueJeu{

    public function jeu(){


if(!isset($_SESSION['villes'])) {
    echo "erreur de grille de jeu"; //TODO: il faudra rediriger vers page d'erreur
}

require_once 'head.php';
?>


<h1>Jeu d'Hashiwokakero (Bridges Game)</h1>
<div class="actions">
    <a href="index.php">Reinitialiser</a>
    <a href="index.php?abandonner">Abandonner</a>
    <a href="index.php?annulercoup">Annuler le coup prédécent</a>
</div>
        <div class="erreur"><?php if (isset($_SESSION['erreur'])){ echo $_SESSION['erreur'];} ?></div>
<table id="grille">
<?php
unset($_SESSION['erreur']);
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
            } else if ($villes->getVille($x, $y)->getNombrePonts() == $villes->getVille($x, $y)->getNombrePontsMax()) {
                //si la case est "bonne" car autant de ponts que sa capacité
                echo "<th><a class='validated' href='index.php?x=". $x ."&y=". $y ."'>" . $villes->getVille($x, $y)->getNombrePontsMax() . "</a></th>";
            } else if ($villes->getVille($x, $y)->getNombrePonts() > $villes->getVille($x, $y)->getNombrePontsMax()) {
                //si la case est "bloquée" car trop de ponts pour sa capacité
                echo "<th><a class='blocked' href='index.php?x=". $x ."&y=". $y ."'>" . $villes->getVille($x, $y)->getNombrePontsMax() . "</a></th>";
            } else {
                echo "<th><a href='index.php?x=". $x ."&y=". $y ."'>" . $villes->getVille($x, $y)->getNombrePontsMax() . "</a></th>";
            }
        } else {
            if(isset($matricePonts[$x][$y])){
                switch ($matricePonts[$x][$y]) {
                    case 'h1':
                        echo "<th><div class='horizontal'></div></th>";
                        break;
                    case 'h2':
                        echo "<th><div class='horizontal'></div><div class='horizontal'></div></th>";
                        break;
                    case 'v1':
                        echo "<th><div class='vertical'></div></th>";
                        break;
                    case 'v2':
                        echo "<th><div class='vertical'></div><div class='vertical'></div></th>";
                        break;
                }
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