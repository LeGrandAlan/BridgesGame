<?php

Class VueJeu{

    public function jeu(){


if(!isset($_SESSION['villes'])) {
    echo "erreur de grille de jeu"; //TODO: il faudra rediriger vers page d'erreur
}
?>
<style>
    h1 {
        text-align: center;
        margin: 40px 0;
    }
    table {
        border: 1px solid black;
        margin: auto;
        border-collapse: collapse;
    }
    th {
        width: 50px;
        height: 50px;
        padding: 0;

        font-weight: bold;
    }
    th a {
        display: flex;
        flex-flow: column;
        justify-content: center;
        width: 100%;
        height: 100%;
        background-color: lightgray;
        border-radius: 50%;
        text-decoration: none;
        color: black;
    }
    th a#selected {
        background-color: green;
    }
    th a:hover {
        background-color: gray;
    }
    th a.blocked {
        background-color: red;
    }
    th a.validated {
        background-color: blue;
    }
    .actions {
        text-align: center;
        margin-bottom: 60px;
    }
    .actions a {
        padding: 5px;
        background-color: lightgray;
        border: 1px solid black;
        text-decoration: none;
        color: #000;
    }
    div.horizontal {
        width: 100%;
        height: 3px;
        background-color: grey;
        margin-bottom: 2px;
    }
    div.vertical {
        width: 3px;
        height: 100%;
        background-color: grey;
        margin-right: 2px;
        display: inline-block;
    }
</style>

<h1>Jeu d'Hashiwokakero (Bridges Game)</h1>
<div class="actions">
    <a href="index.php">Reinitialiser</a>
    <a href="">Abandonner</a>
    <a href="">Annuler le coup prédécent</a>
</div>
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