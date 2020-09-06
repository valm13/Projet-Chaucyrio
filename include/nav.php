<!-- Header -->
<header>
    <!--Navbar-->
    <nav>
        <div class="nav-wrapper">
            <!-- Logo centré -->
            <a href="index.php" id="navbar-logo" class="brand-logo center">Académie Chaucyrienne</a>


            <!-- Liens sur la gauche -->
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <!-- Liens habituels -->
                <?php
                $navbar_items = array
                (
                    'index.php' => '<i class="material-icons left">home</i>Accueil',
                    'blog.php' => '<i class="material-icons left">subject</i>Blog',
                    'dictionnaire.php' => '<i class="material-icons left">book</i>Dictionnaire',
                    'boutique.php' => '<i class="material-icons left">shopping_cart</i>Boutique'
                );

                // Affiche les liens et ajoute la classe "active" pour la page courante
                foreach ($navbar_items as $key => $value)
                {
                    echo '<li' . (basename($_SERVER['SCRIPT_NAME']) == $key ? ' class="active">' : '>') . '<a href="' . $key . '">' . $value . '</a></li>';
                }
                ?>
            </ul>


            <!-- Liens sur la droite -->
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <!-- Liens habituels -->
                <?php
                $navbar_items = array
                (
                    'tchat.php' => '<i class="material-icons left">comment</i>T\'chat',
                    'contact.php' => '<i class="material-icons left">contact_mail</i>Contact'
                );

                // Affiche les liens et ajoute la classe "active" pour la page courante
                foreach ($navbar_items as $key => $value)
                {
                    echo '<li' . (basename($_SERVER['SCRIPT_NAME']) == $key ? ' class="active">' : '>') . '<a href="' . $key . '">' . $value . '</a></li>';
                }
                ?>


                <!-- Liens conditionnels -->
                <?php
                // Si l'utilisateur est connecté
                if(isset($_SESSION['membre']) && $_SESSION['membre']->role() >= 0)
                {
                    // Si c'est un administrateur
                    if($_SESSION['membre']->role() == 1)
                    {
                        // Panel d'administration
                        echo '<li' . (basename($_SERVER['SCRIPT_NAME']) == 'admin.index.php' ? ' class="active">' : '>') .'<a href="admin/admin.index.php"><i class="material-icons left">build</i>Administration</a></li>';
                    }

                    // Options
                    echo '<li' . (basename($_SERVER['SCRIPT_NAME']) == 'membre.php' ? ' class="active">' : '>') .'<a href="membre.php" class="tooltipped" data-position="bottom" data-delay="0" data-tooltip="Mon profil"><i class="material-icons">assignment_ind</i></a></li>';
                    // Déconnexion
                    echo '<li' . (basename($_SERVER['SCRIPT_NAME']) == 'deconnexion.php' ? ' class="active">' : '>') .'<a href="deconnexion.php"><i class="material-icons">power_settings_new</i></a></li>';
                }
                // Si l'utilisateur n'est pas connecté
                else
                {
                    echo '<li' . (basename($_SERVER['SCRIPT_NAME']) == 'connexion.php' ? ' class="active">' : '>') .'<a href="connexion.php"><i class="material-icons left">vpn_key</i>Connexion</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>