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
    $formationActive = $lesFormations->chercheFormation($_SESSION['menuFormation']);
    $_SESSION['formationActive'] = $lesFormations->chercheFormation($_SESSION['menuFormation']);
    $menuFormation = new Menu('menuFormation');
    foreach($listeFormations as $formation){
        $idForma = $formation['idForma'];
        $menuFormation->ajouterComposant($menuFormation->creerItemLien($idForma, $formation['intitule'] ));
    }
    $menuFormation = $menuFormation->creerMenu($formationActive, 'menuFormation');
    $inscrit = FormationDAO::estInscrit($_SESSION['identification']['idUser'], $_SESSION['formationActive']['idForma']);
    $formFormation = new Formulaire('post', 'index.php', 'formFormation', 'formFormation');
    
    if($_SESSION['menuFormation']!="0"){
        $formFormation ->ajouterComposantLigne($formFormation->creerLabelClass("Description : ", "tab"));
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel($formationActive['descriptif']));
        $formFormation ->ajouterComposantTab();
        $formFormation ->ajouterComposantLigne($formFormation->creerLabelClass("Durée : ", "tab"));
        $formFormation ->ajouterComposantLigne($formFormation->creerLabel($formationActive['duree']. "h"));
        $formFormation ->ajouterComposantTab();
        if(!empty($inscrit)){
            $formFormation ->ajouterComposantLigne($formFormation->creerLabelClass("Etat de votre demande :", "tab"));
            $formFormation ->ajouterComposantLigne($formFormation->creerLabel($inscrit['etatDemande']));
            $formFormation ->ajouterComposantTab();
            $formFormation ->ajouterComposantLigne($formFormation->creerInputSubmit("submitAnnulerDemande", "submitAnnulerDemande", "Annuler la demande"));
            $formFormation ->ajouterComposantTab();
        }else{
            $formFormation ->ajouterComposantLigne($formFormation->creerInputSubmit("submitInscrire", "submitInscrire", "S&#39;inscrire"));
            $formFormation ->ajouterComposantTab();
        }
    }

    $formFormation->creerFormulaire();

    

    require_once 'vue/vueFormations.php';
?>