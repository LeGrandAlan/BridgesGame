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
        <h1>Page de connection</h1>

        <p style="text-align: center"><?php if (isset($_SESSION['erreur'])) echo $_SESSION['erreur']; ?></p>

        <form method="post" action="index.php" id="connection">

            <table>
                <tr>
                    <td><label for="pseudo">Pseudo : </label></td>
                    <td><input type="text" id="pseudo" name="pseudo" required/></td>
                </tr>
                <tr>
                    <td><label for="motdepasse">Mot de passe : </label></td>
                    <td><input type="password" id="motdepasse" name="motdepasse" required/></td>
                </tr>
                <tr>
                    <td colspan=2><input style="margin-top: 10px;" type="submit" name="seconnecter" value="Connection"/></td>
                </tr>
            </table>
        </form>
        </br>
        <div class="actions">
            <a href="index.php?inscription">Inscription</a>
        </div>
        </body>
        </html>

        <?php
        if (isset($_SESSION['erreur'])) {
            unset($_SESSION['erreur']);
        }
    }
}

?>
