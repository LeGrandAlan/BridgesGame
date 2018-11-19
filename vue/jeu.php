<?php
session_start();
$_SESSION['villes'][0][0]="3";
$_SESSION['villes'][0][6]="2";
$_SESSION['villes'][3][0]="6";
$_SESSION['villes'][3][5]="2";
$_SESSION['villes'][5][1]="1";
$_SESSION['villes'][5][6]="2";
$_SESSION['villes'][6][0]="2";
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
</style>
<table>
<?php

for ($x = 0; $x < 7; $x++){
    echo "<tr>";
    for ($y = 0; $y < 7; $y++){
        if (isset($_SESSION['villes'][$x][$y])) {
            echo "<th><a href='index.php?x=". $x ."&y=". $y ."'>" . $_SESSION['villes'][$x][$y] . "</a></th>";
        } else {
            echo "<th></th>";
        }
    }
    echo "</tr>";
}
?>
</table>