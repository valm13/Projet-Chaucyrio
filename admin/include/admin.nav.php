<!-- Header -->
<header id="admin-header">
    <!--Navbar-->
    <nav id="admin-nav">
        <div class="nav-wrapper">
            <!-- Logo -->
            <a href="admin.index.php" id="navbar-logo" class="brand-logo">Panel d'Administration</a>


            <!-- Liens -->
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <!-- Liens habituels -->
                <?php
                $navbar_items = array
                (
                    'admin.index.php' => 'Accueil',
                    'admin.blog.php' => 'Blog',
                    'admin.dictionnaire.php' => 'Dictionnaire',
                    'admin.boutique.php' => 'Boutique',
                    'admin.tchat.php' => 'T\'chat',
                    'admin.contact.php' => 'Contact'
                );

                // Affiche les liens et ajoute la classe "active" pour la page courante
                foreach ($navbar_items as $key => $value)
                {
                    echo '<li' . (basename($_SERVER['SCRIPT_NAME']) == $key ? ' class="active">' : '>') . '<a href="' . $key . '">' . $value . '</a></li>';
                }

                // Retour au site
                echo '<li' . (basename($_SERVER['SCRIPT_NAME']) == 'index.php' ? ' class="active">' : '>') .'<a href="../index.php"><i class="material-icons">exit_to_app</i></a></li>';
                // Déconnexion
                echo '<li' . (basename($_SERVER['SCRIPT_NAME']) == 'deconnexion.php' ? ' class="active">' : '>') .'<a href="../deconnexion.php"><i class="material-icons">power_settings_new</i></a></li>';
                ?>
            </ul>
        </div>
    </nav>
</header>