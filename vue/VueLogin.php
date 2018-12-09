<?php
require_once 'head.php';

/**
 * Class Vuelogin
 */
Class Vuelogin{

    /**
     * Affiche la vue du formulaire de connection
     */
    public function login(){

        ?>

        <html>
        <body>
        <br/>
        <br/>
        <form method="post" action="index.php" id="connection">
            <input type="text" name="pseudo"/>
            <input type="password" name="motdepasse"/>
            </br>
            <input type="submit" name="seconnecter" value="connection"/>
        </form>
        </body>
        </html>

        <?php

    }
}

?>
