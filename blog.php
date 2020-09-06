<?php
// On inclue les classes nécessaires
require_once('util/Require.php');

//  Pour avoir la date en français
date_default_timezone_set('Europe/Paris');
// --- La setlocale() fonctionnne pour strftime mais pas pour DateTime->format()
setlocale(LC_TIME, 'fr_FR.utf8','fra');// OK
                                       
// Pour la BDD
 $manager = new ChaussureManager(true);

/*
* Systeme du Blog
*/
if(isset($_SESSION['membre']) && !empty($_POST['texte'])){

    $values3 = array(
    'id_membre' => $_SESSION['membre']->id(),
    'texte' => nl2br($_POST['texte']), // nl2br pour avoir les sauts de ligne
    'id_article' => $_POST['id_article']);

    $manager->ajouteCommentaire($values3);
}


?>
<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize/sass/materialize.css" media="screen,projection" />
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Encodage et favicon -->
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="img/favicon.png" sizes="128x128" />
        <!-- Feuilles de style -->
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link type="text/css" rel="stylesheet" href="css/blog.css" />
        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Blog communautaire</title>
    </head>
    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>
        <!--Main-->
        <main>
            <?php if (!empty($_SESSION['membre']) && $_SESSION['membre']->role() != -1){ ?>
            <div class="row">
                <div class="col s12">
                    <a href="new_article.php" id="new_post"><button class="btn waves-effect waves-light" type="submit" name="action" style="height:70px;width:170px;">Poster un article<i class="material-icons right"></i></button></a>
                </div>
            </div>
            <?php }?>
             <h1 class="center align">Blog</h1>
            
            <?php
            if (empty($_SESSION['membre']) || $_SESSION['membre']->role() == -1){
            ?>
            <div class="row">
                <div class="col s8 offset-s2 center-align">
                    <div class="card-panel col s12 center-align">
                        <div class="card-content light black-text">
                            <span class="card-title center-align">
                                <h3>
                                <i class="material-icons medium">warning</i>
                                <span class="paddock">Attention</span>
                                <i class="material-icons medium">warning</i>
                                </h3>
                            </span>
                            <div class="valign-wrapper">
                                <p class=" center-block">Si vous souhaitez poster des articles ou bien en commenter, veuillez vous connecter !</p>
                                <a href="connexion.php"><i class="material-icons medium">group_add</i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            <div class="row">
                <div class="col s8 offset-s2">
                    <ul class="collapsible" data-collapsible="accordion">
                        
                        <?php
                        $toutArticles = $manager->listeArticleValide();
                        // On parcourt la liste des items
                        foreach ($toutArticles as $key => $value)
                        {
                        ?>
                        
                        <!-- Nouvelle ligne d'article -->
                        <li>
                            <div class="collapsible-header"><i class="collapsible-chevron material-icons">expand_more</i><?php echo $value['sujet'];?></div>
                            <div class="collapsible-body">
                                <article <?php echo 'id="article-'. $value['id_article'] .'"';?>>
                                    <div class="row element">
                                        <div class="card article-blog">
                                            <div class="card-content white-text">
                                                <div class="row">
                                                    <div class="col s6">
                                                        <span class="card-title"><?php echo $value['sujet'];?></span>
                                                        <p class="wordwrap">
                                                            <?php echo $value['texte'];?>
                                                        </p>
                                                        <div id="header" class="article-header center-align">
                                                            <br>
                                                            <p>Par</p>
                                                            <span id="author" class="pseudo"><?php if (isset($value['nom']) && isset($value['prenom'])){
                                                                echo $value['prenom'].' '. ucfirst(substr($value['nom'],0,1)). '.';
                                                            }
                                                            else{
                                                                echo 'Un utilisateur inconnu';
                                                            }?></span>
                                                            <p class="date">
                                                                
                                                                <time datetime=<?php echo '"'.$value['date'].'"';?>>
                                                                <?php echo strftime("%A %d %B %Y",strtotime($value['date']));?>
                                                                </time>
                                                                à
                                                                <date><?php echo $value['horaire'];?></date>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col s6">
                                                        <span class="card-title">Commentaires :</span>
                                                        <div class="comments-bar-container" id="comments">
                                                            <ul id="liste_comment">
                                                                <?php 
                                                                $toutCommentaires = $manager->listeComentaire($value['id_article']);
                                                                // On parcourt la liste des commentaires
                                                                foreach ($toutCommentaires as $key2 => $value2)
                                                                {
                                                                ?>
                                                                <li <?php echo 'id="comment-'. $value2['id_commentaire'] .'"';?>>
                                                                    <div id="header" class="comment-header">
                                                                        <cite id="cite">
                                                                        <!-- Je ferai le pseudo plus tard -->
                                                                        <span id="author" class="pseudo"><?php if (isset($value2['nom']) && isset($value2['prenom'])){
                                                                echo $value2['prenom'].' '. ucfirst(substr($value2['nom'],0,1)). '.';
                                                            }
                                                            else{
                                                                echo 'Un utilisateur inconnu';
                                                            }?></span>
                                                                        <p class="date">
                                                                            
                                                                            <time datetime=<?php echo '"'.$value2['date'].'"';?>>
                                                                            <?php echo strftime("%A %d %B %Y",strtotime($value2['date']));?>
                                                                            </time>
                                                                            à
                                                                            <date><?php echo $value2['horaire'];?></date>
                                                                        </p>
                                                                        </cite>
                                                                    </div>
                                                                    <div id="comment-body" class="comment-body">
                                                                        <div id="comment-message" class="comment-message">
                                                                            <p class="wordwrap"><?php echo $value2['texte'];?></p>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <br>
                                                                <?php }?>
                                                                
                                                            </ul>
                                                            
                                                            <?php if (!empty($_SESSION['membre']) && $_SESSION['membre']->role() != -1){ ?>
                                                            <!-- On affiche le formulaire que si l'internaute est connecté -->
                                                            <form action="blog.php" method="post">
                                                                 <!-- <form action="http://btssio.bonaparte.free.fr/testforms.php" method="post"> -->
                                                                <!-- Le for permet de mettre le curseur là où il y a l'id -->
                                                                <label for="champ">Votre commentaire :</label>
                                                                <textarea id="champ" name="texte" rows="10" cols="30" style="width:90%; height:100px"></textarea>
                                                                <input type="hidden" name="id_article" value=<?php echo '"'.$value['id_article'].'"';?>/>
                                                                <br>
                                                                <button class="btn waves-effect waves-light" type="submit" name="action">Envoyer<i class="material-icons right">send</i></button>
                                                            </form>
                                                            <?php } ?>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </article>
                                    </div>
                                </li>
                                <?php
                                }
                                ?>
                                
                            </ul>
                        </div>
                    </div>
                    
    </main>
    <!--Footer-->
    <?php include('include/footer.php'); ?>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>

    <!-- Événements du collapsible -->
    <script type="text/javascript" src="js/collapsible.js"></script>

</body>
</html>