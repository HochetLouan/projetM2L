<?php
    require_once 'lib/dispatcher.php';
    $listeFormations = FormationDAO::listeFormation();
    $lesFormations = new Formations(($listeFormations));
    if(isset($_GET['menuFormation'])){
    	$_SESSION['menuFormation']= $_GET['menuFormation'];
    }
    else
    {
    	if(!isset($_SESSION['menuFormation'])or $_SESSION['menuFormation'] == ""){
    		$_SESSION['menuFormation']="0";
    	}
    }
    $formationActive = FormationDAO::getFormationById($_SESSION['menuFormation']);
    var_dump($formationActive[0]);
    $menuFormation = new Menu('menuFormation');
    foreach($listeFormations as $formation){
        $idForma = $formation['idForma'];
        $menuFormation->ajouterComposant($menuFormation->creerItemLien($idForma, $formation['intitule'] ));
    }
    if($formation['idForma'] != "-1"){
        $menuFormation = $menuFormation->creerMenu($formationActive, 'menuFormation');
    }
    $formFormation = new Formulaire('post', 'index.php', 'formFormation', 'formFormation');
    if(isset($_POST['submitAjouter'])){
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel("nom de la formation :"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputTexte("inputNom", "nom", "", 0, '', 0));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel("dercription de la formation :"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputTexte("inputDescription", "description", "", 0, '', 0));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel("durée de la formation en heure :"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputTexte("inputDuree", "duree", "", 0, '', 0));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel("effectif max de la formation :"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputTexte("inputEffectif", "effectif", "", 0, '', 0));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel("date d'ouverture des inscriptions :"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputTexte("inputDateO", "dateO", "", 0, '', 0));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel("date de cloture des inscriptions :"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputTexte("inputDateF", "dateF", "", 0, '', 0));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerInputSubmit("submitAnnuler", "submitAnnuler", "Annuler"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputSubmit("submitValiderCreation", "submitValiderCreation", "Valider"));
        $formFormation ->ajouterComposantTab();
    }elseif($_SESSION['menuFormation']!="0"){
        $formFormation ->ajouterComposantLigne($formFormation->creerLabelClass("Description : ", "tab"));
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel($formationActive[0][1]));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerLabelClass("Durée : ", "tab"));
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel($formationActive[0][2]. "h"));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerInputSubmit("submitAjouter", "submitAjouter", "Ajouter"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputSubmit("submitSupprimer[".$formationActive[0][0]."]", "submitSupprimer", "Supprimer"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputSubmit("submitModifier", "submitModifier", "Modifier"));
        $formFormation ->ajouterComposantTab();
    }else{
        $formFormation ->ajouterComposantLigne($formFormation->creerLabelClass("Selectionnez une formation", "tab"));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerInputSubmit("submitAjouter", "submitAjouter", "Ajouter"));
        $formFormation ->ajouterComposantLigne($formFormation->creerInputSubmit("submitSupprimer", "submitSupprimer", "Supprimer"));
        $formFormation ->ajouterComposantTab();
    }
    $formFormation->creerFormulaire();
    if($formationActive != null){
        $formDemandes = new Formulaire('post', 'index.php', 'formDemandes', 'formDemandes');
        $demandes = FormationDAO::getDemandesByForma($formationActive[0][0]);
        if($demandes != null){
            $formDemandes->ajouterComposantLigne($formDemandes->creerLabel("demandes : "));
            $formDemandes ->ajouterComposantTab();
            foreach($demandes as $demande){
                if ($demande['etatDemande'] == 'demandé'){
                    $user = UtilisateurDAO::getUtilisateurById($demande['idUser']);
                    $formDemandes->ajouterComposantLigne($formDemandes->creerLabel($user['nom']." ".$user['prenom']));
                    $formDemandes ->ajouterComposantTab();
                    $formDemandes->ajouterComposantLigne($formDemandes->creerInputSubmit("submitAccepter[".$demande['idUser']."][".$demande['idForma']."]", 'submitAccepter', "Accepter"));
                    $formDemandes->ajouterComposantLigne($formDemandes->creerInputSubmit("submitRefuser[".$demande['idUser']."][".$demande['idForma']."]", 'submitRefuser', "Refuser"));
                    $formDemandes ->ajouterComposantTab();
                }
            }
        }
    
    
    $formDemandes->creerFormulaire();
    }
    require_once 'vue/vueFormationsModif.php';
?>