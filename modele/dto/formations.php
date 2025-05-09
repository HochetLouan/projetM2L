<?php
class Formations{
	private array $formation ;

	public function __construct($array){
		if (is_array($array)) {
			$this->formation = $array;
		}
	}

	public function getFormations(){
		return $this->formation;
	}

	public function chercheFormation(int $unIdForma): ?array {
        foreach ($this->formation as $formation) {
            if ($formation['idForma'] === $unIdForma) {
                return $formation;
            }
        }
        return null; // Retourne null si aucune formation n'est trouvée
    }
}