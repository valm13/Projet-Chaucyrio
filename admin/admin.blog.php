<?php
   // On inclue les classes nécessaires
   
   require_once ('../util/Require.php');
   
   // Redirection si l'utilisateur n'est pas admin
   
   if ((!isset($_SESSION['membre'])) || ($_SESSION['membre']->role() != 1))
       {
       header("Location: ../index.php");
       }
   
   // Pour la BDD
   
   $manager = new ChaussureManager(true);
   
   if (isset($_SESSION['membre']))
       {
       if ($_SESSION['membre']->role() == 1 && !empty($_POST))
           {
            // print_r($_POST);
            if($_POST['categorie'] == 'validation'){
                // Alors on recupère l'action
   
           $incre = $_POST['var_incre'];
           $values = array(
               'id_article' => $_POST['id_article'],
               'action' => $_POST[$incre]   // value du name qui est à $incre (c'est pas le bouton de validation)
           );
           
           if ($values['action'] == 'Valider') $manager->validerArticle($values['id_article'], $_SESSION['membre']->role());
             else
           if ($values['action'] == 'Invalider') $manager->desactiverArticle($values['id_article'], $_SESSION['membre']->role());
           }

           else if($_POST['categorie'] == 'suppression'){
                // Alors on recupère l'action
   
           $incre = $_POST['var_incre'];
           $values = array(
               'id_article' => $_POST['id_article'],
               'action' => $_POST[$incre]   // value du name qui est à $incre (c'est pas le bouton de validation)
           );
           
           if ($values['action'] == 'Supprimer') $manager->supprimerArticle($values['id_article'], $_SESSION['membre']->role());
            }
           
       }
   }
   
   ?>
<!DOCTYPE html>
<html>
   <head>
      <!--Google Icons Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
      <!--Importation de materialize.css-->
      <link type="text/css" rel="stylesheet" href="../css/materialize/sass/materialize.css" media="screen,projection" />
      <!--Informe le navigateur que le site est optimisé pour mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta charset="utf-8" />
      <link rel="icon" type="image/png" href="img/favicon.png" sizes="128x128" />
      <link rel="stylesheet" type="text/css" href="../css/style.css" />
      <link rel="stylesheet" type="text/css" href="../css/blog.css" />
      <title>Académie Chaucyrienne > Panel d'administration</title>
   </head>
   <body>
      <!--Navbar-->
      <?php include('include/admin.nav.php'); ?>
      <!--Main-->
      <main>
         <h1 class="center align">Administration du Blog</h1>
         <br>
         <div class="row center-align">
         <!-- Ajout d'une catégorie -->
         <div class="row">
         <div class="col s10 offset-s1 center-align">
         <div class="card-panel">
            <!-- Titre de la partie -->
            <h3 class="sous_titre">Gestion de validation</h3>
            <!-- On peut soit valider, soit l'invalider. (boutons radio) -->
            <div class="row">
               <div class="col s8 offset-s2">
                  <ul class="collapsible" data-collapsible="accordion">
                     <?php
                        $incre = 1;
                        $toutArticles = $manager->listeAllArticle();
                        // On parcourt la liste des items
                        foreach ($toutArticles as $key => $value)
                        {
                        ?>
                     <!-- Nouvelle ligne d'article -->
                     <li>
                        <div class="collapsible-header">
                           <i class="collapsible-chevron material-icons colored"'>expand_more</i>
                           <p 
                              <?php
                                 if($value['valide'])
                                 {
                                     echo 'class="valide"';
                                 }
                                 else{
                                     echo 'class="invalide"';
                                 }?>
                              >
                              <?php echo $value['sujet'];?>
                           </p>
                        </div>
                        <div class="collapsible-body">
                           <article <?php echo 'id="article-'. $value['id_article'] .'"';?>>
                              <div class="row element">
                                 <div class="card blue-grey darken-1">
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
                                             <span class="card-title">Validation de l'article :</span>
                                             <div class="comments-bar-container" id="comments">
                                                <form action="admin.blog.php" method="post">
                                                   <!-- <form action="http://btssio.bonaparte.free.fr/testforms.php" method="post"> -->
                                                   <?php if(!$value['valide']){ ?>
                                                   <p class="center-align">
                                                      <input class="with-gap" name=<?php echo '"'.$incre.'"';?> type="radio" id=<?php echo '"validate-'.$incre.'"';?> value="Valider" checked>
                                                      <label for=<?php echo '"validate-'.$incre.'"';?>>Valider</label>
                                                   </p>
                                                   <?php } ?>
                                                   <?php if($value['valide']){ ?>
                                                   <p class="center-align">
                                                      <input class="with-gap" name=<?php echo '"'.$incre.'"';?> type="radio" id=<?php echo '"unvalidate-'.$incre.'"';?> value="Invalider" checked>
                                                      <label for=<?php echo '"unvalidate-'.$incre.'"';?>>Invalider</label>
                                                   </p>
                                                   <?php } ?>
                                                   <input type="hidden" name="id_article" value=<?php echo '"'.$value['id_article'].'"';?>/>
                                                   <input type="hidden" name="var_incre" value=<?php echo '"'.$incre.'"';?>/>
                                                   <input type="hidden" name="categorie" value="validation"/>
                                                   <br>
                                                   <button class="btn waves-effect waves-light" type="submit" name="action">Envoyer<i class="material-icons right">send</i></button>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                           </article>
                           </div>
                     </li>
                     <?php
                        $incre++;
                        }
                        ?>
                  </ul>
                  </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="row center-align">
         <!-- Ajout d'une catégorie -->
         <div class="row">
         <div class="col s10 offset-s1 center-align">
         <div class="card-panel">
            <!-- Titre de la partie -->
            <h3 class="sous_titre">Gestion de suppression / Bannissement Ip</h3>
            <!-- On peut supprimer l'article et/ou banir l'auteur -->
            <div class="row">
               <div class="col s8 offset-s2">
                  <ul class="collapsible" data-collapsible="accordion">
                     <?php
                        $incre = 1;
                        $toutArticles = $manager->listeAllArticle();
                        // On parcourt la liste des items
                        foreach ($toutArticles as $key => $value)
                        {
                        ?>
                     <!-- Nouvelle ligne d'article -->
                     <li>
                        <div class="collapsible-header">
                           <i class="collapsible-chevron material-icons colored"'>expand_more</i>
                           <p 
                              <?php
                                 if($value['valide'])
                                 {
                                     echo 'class="valide"';
                                 }
                                 else{
                                     echo 'class="invalide"';
                                 }?>
                              >
                              <?php echo $value['sujet'];?>
                           </p>
                        </div>
                        <div class="collapsible-body">
                           <article <?php echo 'id="article-'. $value['id_article'] .'"';?>>
                              <div class="row element">
                                 <div class="card blue-grey darken-1">
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
                                             <span class="card-title">Validation de l'article :</span>
                                             <div class="comments-bar-container" id="comments">
                                                <form action="admin.blog.php" method="post">
                                                   <!-- <form action="http://btssio.bonaparte.free.fr/testforms.php" method="post"> -->
                                                   <p class="center-align">
                                                      <input class="with-gap" name=<?php echo '"'.$incre.'"';?> type="radio" id=<?php echo '"supprimer-'.$incre.'"';?> value="Supprimer" checked>
                                                      <label for=<?php echo '"supprimer-'.$incre.'"';?>>Supprimer</label>
                                                   </p>
                                                   
                                                   <input type="hidden" name="id_article" value=<?php echo '"'.$value['id_article'].'"';?>/>
                                                   <input type="hidden" name="var_incre" value=<?php echo '"'.$incre.'"';?>/>
                                                   <input type="hidden" name="categorie" value="suppression"/>
                                                   <br>
                                                   <button class="btn waves-effect waves-light" type="submit" name="action">Envoyer<i class="material-icons right">send</i></button>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                           </article>
                           </div>
                     </li>
                     <?php
                        $incre++;
                        }
                        ?>
                  </ul>
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
      <!--Footer-->
      <?php include('../include/footer.php'); ?>
      <!--Importation de JQuery avant materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="../css/materialize/js/materialize.min.js"></script>
      <!-- Événements du collapsible -->
      <script type="text/javascript" src="../js/collapsible.js"></script>
   </body>
</html>