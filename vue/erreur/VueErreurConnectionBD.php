<?php

require_once PATH_VUE.'/head.php';

Class VueErreurConnectionBD {

    public function afficher() {
        ?>

        <h1>Erreur de connection à la base de donnée</h1>

        <div class="actions">
            <a href="index.php">Revenir à la page de connection</a>
        </div>

        <p style="text-align: center">
            Si vous restez sur cette page c'est qu'il y a une erreur de configuration des fichiers de connection à la base de donnée
            ou que la base de donnée n'est pas accecible.
        </p>

        <?php

    }

}