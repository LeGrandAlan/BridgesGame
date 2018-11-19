<?php

Class VueJeu{

    public function jeu(){


//                         [nombrePontsMax, nombrePontsActuel, estSelectionne]
$_SESSION['villes'][0][0]=[3, 0, 0];
$_SESSION['villes'][0][6]=[2, 0, 0];
$_SESSION['villes'][3][0]=[6, 0, 0];
$_SESSION['villes'][3][5]=[2, 2, 0];
$_SESSION['villes'][5][1]=[1, 0, 0];
$_SESSION['villes'][5][6]=[2, 0, 1];
$_SESSION['villes'][6][0]=[2, 0, 0];
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
for ($x = 0; $x < 7; $x++){
    echo "<tr>";
    for ($y = 0; $y < 7; $y++){
        if (isset($_SESSION['villes'][$x][$y])) {
            if ($_SESSION['villes'][$x][$y][2]){
                // Si la ville est selectionnée, on l'indique au joueur
                echo "<th><a id='selected' href='index.php?x=". $x ."&y=". $y ."'>" . $_SESSION['villes'][$x][$y][0] . "</a></th>";
            } else if($_SESSION['villes'][$x][$y][1]) {
                // Si la ville a son max de ponts, on l'indique
                echo "<th><a class='blocked' href='index.php?x=". $x ."&y=". $y ."'>" . $_SESSION['villes'][$x][$y][0] . "</a></th>";
            } else {
                // Si la ville n'est ni selectionnée, ni max de ponts, on l'affiche juste
                echo "<th><a href='index.php?x=". $x ."&y=". $y ."'>" . $_SESSION['villes'][$x][$y][0] . "</a></th>";
            }
        } else {
            echo "<th></th>";
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