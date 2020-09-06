<?php
// Gère les dépendances de la page
require_once('util/Require.php');




// Si l'utilisateur est déja connecté
if (isset($_SESSION['membre']) && $_SESSION['membre']->role() >= 0)
{
	// Redirection vers la page membre
	header('Location: membre.php');
}

/*
*	FORMULAIRE [POST] - Inscription
*/

// Valeurs nécessaires à la validation du formulaire
$obligatoires = array('email', 'email_confirm', 'mot_de_passe', 'mot_de_passe_confirm', 'nom', 'prenom', 'pays');

// Liste des paramètres du formulaire
$formulaire = array(
	'email' => '',
	'email_confirm' => '',

	'mot_de_passe' => '',
	'mot_de_passe_confirm' => '',

	'nom' => '',
	'prenom' => '',
	'date_naissance' => '',

	'pays' => '',
	'ville' => '',
	'numero_telephone' => ''
);


// Booléens de vérification du formulaire
$formulaire_valide = false;		// Formulaire complet et valide
$formulaire_envoye = true;		// Données reçues en POST

$email_deja_utilise = false;	// Indication d'action {true : e-mail déjà utilisé, false : e-mail libre}

$email_valide = false;			// E-mail conforme
$mdp_valide = false;			// Mot de passe conforme
$phone_valide = false;			// Numéro de téléphone conforme


// Vérification des données POST
if (!empty($_POST))
{
	// On vérifie que toutes les valeurs attendues soient bien reçues
    foreach ($formulaire as $key => $value)
    {
        // Si la clef n'est pas retrouvée
        if (!isset($_POST[$key]) || $_POST[$key] == '')
        {
        	// Si la valeur est obligatoire
        	if(in_array($key, $obligatoires))
        	{
	            // On signale que le formulaire n'est pas complet
	            $formulaire_envoye = false;
	        }
	        // Si elle peut être null
	        else
	        {
	        	$formulaire[$key] = '';
	        }
        }
        else
        {
            // On récupère la valeur
            $formulaire[$key] = $_POST[$key];
        }
    }


    // Si le formulaire est complet
    if ($formulaire_envoye)
    {
    	/*
        *   TODO : REGEX (téléphone et email)
        */


       	// On vérifie l'email
		if (strcmp($formulaire['email'], $formulaire['email_confirm']) == 0)
		{
			$email_valide = true;
		}
       	
        
		// On vérifie le mot de passe
		if (strcmp($formulaire['mot_de_passe'], $formulaire['mot_de_passe_confirm']) == 0)
		{
			$mdp_valide = true;
		}


        // On vérifie le numéro de téléphone
		if (preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $formulaire['numero_telephone']))
		{
			// On découpe le numéro pour la BDD
			//$meta_carac = array("-", ".", " ");
			//$formulaire['numero_telephone'] = str_replace($meta_carac, "", $formulaire['numero_telephone']);
			//$formulaire['numero_telephone'] = chunk_split($formulaire['numero_telephone'], 2, " ");

			// Téléphone valide
			$phone_valide = true;
		}


		// Si tous les champs sont valides, on procède aux dernières vérifications
		if ($email_valide && $mdp_valide)
		{
			$man = new ChaussureManager(TRUE);                                          // Connexion à la BDD
	        $email_deja_utilise = $man->email_deja_utilise($formulaire['email']);		// Vérification de la non-présence de l'e-mail


			// Si l'e-mail n'est pas déjà utilisé par un autre membre
			if (!$email_deja_utilise)
			{
				// On rajoute la date d'inscription
				$formulaire['date_inscription'] = date('Y-m-d', time());
				// On met en minuscule l'e-mail
				$formulaire['email'] = strtolower($formulaire['email']);
	            // On convertit en format date
				$formulaire['date_naissance'] = ($formulaire['date_naissance']=='' ? null : date('Y-m-d', strtotime($formulaire['date_naissance'])));
	        	// On encode le mot de passe
	        	$formulaire['mot_de_passe'] = sha1($formulaire['mot_de_passe']);


	        	// On crée le membre
	        	$nouveau_membre = new Membre($formulaire);
	            // On ajoute le membre dans la BDD
	            $man->ajoute_membre($nouveau_membre->toArray());


	           	// On valide le formulaire
	           	$formulaire_valide = true;
			}
			// Si l'e-mail est déjà utilisé
			else
			{
				$formulaire_valide = false;
			}
		}
		// Si les champs ne sont pas valides
		else
		{
			$formulaire_valide = false;
		}
    }
    // Si le formulaire n'est pas complet
    else
    {
    	$formulaire_valide = false;
    	$formulaire_envoye = false;
    }
}
// Si le formulaire n'a pas été transmis
else {
	$formulaire_valide = false;
	$formulaire_envoye = false;
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
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/inscription.css" />

		<!-- Titre de la page -->
		<title>Académie Chaucyrienne > Inscription</title>
	</head>

	<body>
		<!--Header/Navbar-->
		<?php include('include/nav.php'); ?>


		<!--Main-->
		<main>
			<!-- Titre du contenu -->
			<h1 class="center-align">Formulaire d'inscription</h1>


			<?php
			// Si le formulaire n'est pas valide
			if(!$formulaire_valide)
			{
				?>

				<div class="row">
					<!-- Formulaire d'inscription -->
					<form action="inscription.php" method="post">
						<!-- Vérification mail et mot de passe (retour formulaire) -->

						<?php
						// Si le formulaire est complet
						if($formulaire_envoye)
						{
							// Si les e-mails ne correspondent pas
							if(!$email_valide)
							{
								echo '<div class="row center-align"><span class="verification_champ">Les e-mails ne correspondent pas</span></div>';
							}
							// Si l'e-mail est déjà utilisé
							else if($email_deja_utilise)
							{
								echo '<div class="row center-align"><span class="verification_champ">E-mail déjà utilisé</span></div>';
							}



							// Si les mots de passe ne correspondent pas
							if(!$mdp_valide)
							{
								echo '<div class="row center-align"><span class="verification_champ">Les mots de passe ne correspondent pas</span></div>';
							}
						}

						?>

						<!-- Nom et prénom -->
						<div class="row">
							<!-- Icône -->
							<div class="input-field col s1 offset-s2 center-align"><i class="material-icons prefix">account_circle</i></div>


							<!-- Champ "Prénom" -->
							<div class="input-field col s3">
								<input id="prenom" type="text" class="validate" name="prenom" <?php echo "value='".$formulaire['prenom']."'"; ?> required /><label for="prenom">Prénom</label>
							</div>

							<!-- Champ "Nom" -->
							<div class="input-field col s3">
								<input id="nom" type="text" class="validate" name="nom" <?php echo "value='".$formulaire['nom']."'"; ?> required /><label for="nom">Nom</label>
							</div>
						</div>


						<!-- Pays et ville -->
						<div class = "row">
							<!-- Icône -->
							<div class="input-field col s1 offset-s2 center-align"><i class="material-icons prefix">location_city</i></div>


							<!-- Champ "Pays" -->
							<div class="input-field col s3">
								<select name="pays">
									<option value = "" disabled>Choisissez votre pays</option>

									<?php
									// Affiche la liste des pays (et re-sélectionne lors d'une erreur formulaire)
									$liste_pays = array("France", "Suisse", "Belgique", "Québec", "Autre");

									foreach($liste_pays as $value)
									{
										echo '<option value="' . $value . '" ' . (($value == $formulaire['pays'] ? 'selected' : '')) .'>' . $value . '</option>';
									}
									?>
								</select>

								<label for="pays">Pays</label>               
							</div>

							<!-- Champ "Ville" (facultatif) -->
							<div class="input-field col s3">
								<input id="ville" type="text" class="validate" name="ville" <?php echo "value='".$formulaire['ville']."'"; ?> /><label for="ville">Ville</label>
							</div>
						</div>


						<!-- Date de naissance -->
						<div class="row">
							<!-- Icône -->
							<div class="input-field col s1  offset-s2 center-align"><i class="material-icons prefix">date_range</i></div>


							<!-- Champ "Date de naissance" -->
							<div class="input-field col s3">
								<input type="date" class="datepicker" name="date_naissance" <?php echo "value='".$formulaire['date_naissance']."'"; ?> /><label for="date_naissance">Date de naissance</label>
							</div>
						</div>


						<!-- Numéro de téléphone (facultatif) -->
						<div class="row">
							<!-- Icône -->
							<div class="input-field col s1  offset-s2 center-align"><i class="material-icons prefix">contact_phone</i></div>


							<!-- Numéro de téléphone -->
							<div class="input-field col s3">
								<input id="phone" type="text" class="validate tooltipped" name= "numero_telephone" pattern="0[1-9]([-. ]?[0-9]{2}){4}" data-position="right" data-delay="50" data-tooltip="Exemple : 0602030405" <?php echo "value='".$formulaire['numero_telephone']."'"; ?>/>
								<label for="numero_telephone">Numéro de téléphone portable</label>
							</div>
						</div>


						<!-- Mot de passe -->
						<div class="row">
							<!-- Icône -->
							<div class="input-field col s1  offset-s2 center-align"><i class="material-icons prefix">vpn_key</i></div>


							<!-- Champ "Mot de passe" -->
							<div class="input-field col s3">
								<input id="password" type="password" class="validate" name="mot_de_passe" required /><label for="password" data-error="Les mots de passe ne correspondent pas">Mot de passe</label>
							</div>

							<!-- Champ de vérification -->
							<div class="input-field col s3">
								<input id="password_confirm" type="password" class="validate" name="mot_de_passe_confirm" required /><label for="mot_de_passe_confirm">Confirmation du mot de passe</label>
							</div>
						</div>


						<!-- E-mail -->
						<div class="row">
							<!-- Icône -->
							<div class="input-field col s1  offset-s2 center-align"><i class="material-icons prefix">email</i></div>


							<!-- Champ "E-mail" -->
							<div class="input-field col s3">
								<input id="email" type="email" class="validate" name="email" <?php echo "value='".$formulaire['email']."'"; ?> required /><label for="email" data-error="Les e-mails ne correspondent pas">E-mail</label>
							</div>

							<!-- Champ de vérification -->
							<div class="input-field col s3">
								<input id="email" type="email" class="validate" name="email_confirm" required /><label for="email">Confirmation de l'e-mail</label>
							</div>
						</div>


						<!-- Boutons -->
						<div class="row">
							<!-- Boutons de formulaire -->
							<div class="center-align">
								<!--Bouton à desactiver par défaut via JS (DEV)-->
								<!-- Bouton d'envoi -->
								<button class="btn waves-effect waves-light" type="submit" name="action">S'inscrire<i class="material-icons right">send</i></button>

								<!-- Bouton "Effacer" -->
								<button class="btn waves-effect waves-light" type="reset" name="action">Effacer<i class="material-icons right">backspace</i></button>
							</div>

							<!-- Bouton de connexion -->
							<div class="">
								<!-- Bouton "Je n'ai pas de compte" -->
								<p class="center-align">
									<a href="connexion.php">Je possède déjà un compte</a>
								</p>
							</div>
						</div>
					</form>
				</div>

				<?php
			}
			// Si le formulaire est bien reçu et valide
			else
			{ 
				?>

				<div class="row">
					<div class="col s4 offset-s4 center-align">
						<!-- Panneau de confirmation d'inscription -->
						<div class="card blue-grey darken-1">
							<!-- Contenu de la carte -->
							<div class="card-content white-text brown lighten-1">
								<!-- Titre de la carte -->
								<span class="card-title">Confirmation du compte</span>

								<p>
									<br />
									Sois le bienvenu sur le site de l'Académie Chaucyrienne, <?php echo '<i>'.$formulaire['prenom'].'</i>'; ?> !
									<br />

									<br />
									Un e-mail de confirmation a bien été envoyé à l'adresse suivante :
									<br />
									<?php echo '<i>'.$formulaire['email'].'</i>'; ?>
									<br />

									<br />
									La connexion sera possible une fois le compte validé.
								</p>
							</div>

							<div class="divider brown darken-3"></div>

							<!-- Actions de la carte -->
							<div class="card-action center-align brown lighten-1">
								<!-- Bouton vers la page de connexion -->
								<form action="connexion.php" method="post">
									<button type="submit" class="btn waves-effect waves-light action-carte" name="auto_email" value=<?php echo $formulaire['email']; ?>>
										Se connecter<i class="material-icons right">verified_user</i>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>

				<?php
			}

			?>
		</main>


		<!--Footer-->
		<?php include('include/footer.php'); ?>


		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>

		
		<!-- Scripts -->
		<!-- Gestion du DatePicker -->
		<script type="text/javascript" src="js/inscription.js"></script>
		<!-- Gestion du bouton d'envoi -->
        <script type="text/javascript" src="js/form.js"></script>
	</body>
</html>