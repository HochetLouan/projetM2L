<?php
require_once 'lib/dispatcher.php';
if(isset($_GET['m2lMP'])){
	$_SESSION['m2lMP']= $_GET['m2lMP'];
}
else
{
	if(!isset($_SESSION['m2lMP'])){
		$_SESSION['m2lMP']="accueil";
	}
}

//Tester la connexion 
$messageErreurConnexion = '';
if(isset($_POST['submitConnex'])){

	$unUtilisateur = new Utilisateur($_POST['login'], $_POST['mdp']);
	$_SESSION['identification'] = UtilisateurDAO::verification($unUtilisateur);
	if($_SESSION['identification']){
		$_SESSION['m2lMP']="accueil";
	}
	else{
		$messageErreurConnexion = "login ou mot de passe incorrect";
	}
}
if(isset($_POST['submitAnnuler'])){
	$_SESSION['m2lMP']="formationsModif";
}
if(isset($_POST["submitValiderCreation"])){
	$intitule = $_POST['Nom'];
	$descriptif = $_POST['description'];
	$duree = $_POST['duree'];
	$effectif = $_POST['effectif'];
	$dateO = $_POST['dateO'];
	$dateF = $_POST['dateF'];
	$Formation = new Formation(null, $descriptif, $duree, $intitule, $dateO, $dateF, $effectif);
	FormationDAO::addFormation($formation);
}
if(isset($_POST['submitInscrire'])){
	var_dump($_POST['submitInscrire']);
	$formationActive = $_SESSION['formationActive']['idForma'];
	$user = $_SESSION['identification']['idUser'];
	FormationDAO::inscrire($formationActive, $user);
}
if(isset($_POST['submitAnnulerDemande'])){
	$formationActive = $_SESSION['formationActive']['idForma'];
	$user = $_SESSION['identification']['idUser'];
	FormationDAO::desinscrire($formationActive, $user);
}

if(isset($_POST['submitAccepter'])){
	$idUser = array_key_first($_POST['submitAccepter']);
	$idForma = array_key_first($_POST['submitAccepter'][$idUser]);
	FormationDAO::accepterDemande($idForma, $idUser);
}

if(isset($_POST['submitRefuser'])){
	$idUser = array_key_first($_POST['submitRefuser']);
	$idForma = array_key_first($_POST['submitRefuser'][$idUser]);
	FormationDAO::refuserDemande($idForma, $idUser);
}

if(isset($_POST['submitSupprimer'])){
	$idForma =  array_key_first($_POST['submitSupprimer']);
	FormationDAO::deleteFormation($idForma);
	FormationDAO::deleteAllInscrForma($idForma);
	$_SESSION['menuFormation'] = 0;
	$_SESSION['m2lMP']="formationsModif";
}


$m2lMP = new Menu("m2lMP");
if(!isset($_SESSION['identification']) || !$_SESSION['identification']){
	$m2lMP->ajouterComposant($m2lMP->creerItemLien("accueil", "Accueil"));
	$m2lMP->ajouterComposant($m2lMP->creerItemLien("services", "Services"));
	$m2lMP->ajouterComposant($m2lMP->creerItemLien("locaux", "Locaux"));
	$m2lMP->ajouterComposant($m2lMP->creerItemLien("ligues", "Ligues"));
	$m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se connecter"));
}else{
	if($_SESSION['identification']['typeUser'] == "Formateur"){
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("accueil", "Accueil"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("services", "Services"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("locaux", "Locaux"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("ligues", "Ligues"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("formationsModif", "Formations"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se deconnecter"));
	}
	elseif($_SESSION['identification']['typeUser'] == "secretaire"){
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("accueil", "Accueil"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("services", "Services"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("locaux", "Locaux"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("ligues", "Ligues"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se deconnecter"));
	}
	elseif($_SESSION['identification']['typeUser'] == "responsable"){
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("accueil", "Accueil"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("services", "Services"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("locaux", "Locaux"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("ligues", "Ligues"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("salariés", "salariés"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se deconnecter"));
	}
	elseif($_SESSION['identification']['typeUser'] == "salarié"){
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("accueil", "Accueil"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("services", "Services"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("locaux", "Locaux"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("ligues", "Ligues"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("formations", "Formations"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("mesinfos", "Mes infos"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se deconnecter"));
	}
	elseif($_SESSION['identification']['typeUser'] == "benevole"){
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("accueil", "Accueil"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("services", "Services"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("locaux", "Locaux"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("ligues", "Ligues"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("formations", "Formations"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("mesinfos", "Mes infos"));
		$m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se deconnecter"));
	}
}
$menuPrincipalM2L = $m2lMP->creerMenu($_SESSION['m2lMP'],'m2lMP');


include_once Dispatcher::dispatch($_SESSION['m2lMP']);




 