<?php
class UtilisateurDAO{
    public static function verification($unUtilisateur){
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("select idUser , nom , prenom, login, typeUser from UTILISATEUR where login = :login and mdp = :mdp");

        $unLogin = $unUtilisateur->getLogin();
        $unMdp = $unUtilisateur->getMdp();
        $requetePrepa->bindParam(":login" , $unLogin);
        $requetePrepa->bindParam(":mdp" , $unMdp);

        $requetePrepa->execute();
        $result = $requetePrepa->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public static function getUtilisateurById($id){
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT idUser, nom, prenom, login, mdp, statut, typeUser FROM utilisateur where idUser = :id");
        $requetePrepa->bindParam(":id", $id);
        $requetePrepa->execute();
        $result = $requetePrepa->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

       
}
