<?php

class FormationDAO{
    public static function listeFormation(){
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM FORMATION;");
        $requetePrepa->execute();
        $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste)){
            foreach($liste as $formation){
                $uneFormation = new Formation(null,null,null,null, null, null, null);
                $uneFormation->hydrate($formation);
            }
        }
        return $liste;
    }

    public static function inscrire($formation, $user){
        $requetePrepa = DBConnex::getInstance()->prepare("INSERT INTO INSCRIPTION VALUES(?, ?,?);");#
        $etat = "demandé";
        $requetePrepa->bindParam(1, $formation);
        $requetePrepa->bindParam(2, $user);
        $requetePrepa->bindParam(3, $etat);
        $requetePrepa->execute();
    }
    public static function desinscrire($formation, $user){
        var_dump($formation);
        $requetePrepa = DBConnex::getInstance()->prepare("DELETE FROM INSCRIPTION WHERE idForma=? AND idUser=?;");#
        $requetePrepa->bindParam(1, $formation);
        $requetePrepa->bindParam(2, $user);
        $requetePrepa->execute();
    }


    public static function addFormation($formation){
        $requetePrepa = DBConnex::getInstance()->prepare("INSERT INTO FORMAION VALUES(?,?,?,?,?,?);");
        $requetePrepa->bindParam(1, $formation->getDescriptif());
        $requetePrepa->bindParam(2, $formation->getDuree());
        $requetePrepa->bindParam(3, $formation->getIntitule());
        $requetePrepa->bindParam(4, $formation->getDateOuvertInscriptions());
        $requetePrepa->bindParam(5, $formation->getDateClotureInscriptions());
        $requetePrepa->bindParam(6, $formation->getEffectifMax());
        $requetePrepa->execute();
    }
    public static function deleteFormation($id){
        $requetePrepa = DBConnex::getInstance()->prepare("DELETE FROM FORMATION WHERE idForma=?;");
        $requetePrepa->bindParam(1, $id);
        $requetePrepa->execute();
    }

    public static function deleteAllInscrForma($id){
        $requetePrepa = DBConnex::getInstance()->prepare("DELETE  from inscription where idForma = :idForma;");
        $requetePrepa->bindParam(":idForma", $id);
        $requetePrepa->execute();
    }
    public static function estInscrit($idUser, $idForma){
        $result = null;
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM INSCRIPTION WHERE idForma=? AND idUser=?");
        $requetePrepa->bindParam(1, $idForma);
        $requetePrepa->bindParam(2, $idUser);
        $requetePrepa->execute();
        $result = $requetePrepa->fetch();
        return $result;
    }

    public static function getDemandesByForma($idForma){
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT idForma, idUser, etatDemande from inscription WHERE idForma = :idForma");
        $requetePrepa->bindParam(":idForma", $idForma);
        $requetePrepa->execute();
        $result = $requetePrepa->fetchAll();
        return $result;
    }

    public static function accepterDemande($idForma, $idUser){
        $requetePrepa = DBConnex::getInstance()->prepare("UPDATE inscription set etatdemande = 'accepté' where idForma = :idForma and idUser = :idUser");
        $requetePrepa->bindParam(":idForma", $idForma);
        $requetePrepa->bindParam(":idUser", $idUser);
        $requetePrepa->execute();
    }

    public static function refuserDemande($idForma, $idUser){
        $requetePrepa = DBConnex::getInstance()->prepare("UPDATE inscription set etatdemande = 'refusé' where idForma = :idForma and idUser = :idUser");
        $requetePrepa->bindParam(":idForma", $idForma);
        $requetePrepa->bindParam(":idUser", $idUser);
        $requetePrepa->execute();
    }

    public static function getFormationById($idForma){
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT idForma, descriptif, duree, intitule from formation where idForma = :idForma");
        $requetePrepa->bindParam(":idForma", $idForma);
        $requetePrepa->execute();
        $result = $requetePrepa->fetchAll();
        return $result;
    }
}