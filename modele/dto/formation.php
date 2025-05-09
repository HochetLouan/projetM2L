<?php
require_once 'modele/trait/Hydrate.php';
class Formation{
    use Hydrate;
        private ?int $idForma;
        private ?String $descriptif;
        private ?int $duree;
        private ?String $intitule;
        private ?String $dateOuvertInscriptions;
        private ?String $dateClotureInscriptions;
        private ?int $effectifMax;
        
        public function __construct(?int $idForma, ?String $descriptif, ?int $duree, ?String $intitule, ?String $dateOuvertInscriptions, ?String $dateClotureInscriptions, ?int $effectifMax){
            $this->idForma = $idForma;
            $this->descriptif = $descriptif;
            $this->duree = $duree;
            $this->intitule = $intitule;
            $this->dateOuvertInscriptions = $dateOuvertInscriptions;
            $this->dateClotureInscriptions = $dateClotureInscriptions;
            $this->effectifMax = $effectifMax;
        }
        public function getIdForma(): ?int {
            return $this->idForma;
        }
    
        public function getDescriptif(): ?string {
            return $this->descriptif;
        }
    
        public function getDuree(): ?int {
            return $this->duree;
        }
    
        public function getIntitule(): ?string {
            return $this->intitule;
        }
    
        public function getDateOuvertInscriptions(): ?String {
            return $this->dateOuvertInscriptions;
        }
    
        public function getDateClotureInscriptions(): ?String {
            return $this->dateClotureInscriptions;
        }
    
        public function getEffectifMax(): ?int {
            return $this->effectifMax;
        }
    
        // Setters
        public function setIdForma(?int $idForma): void {
            $this->idForma = $idForma;
        }
    
        public function setDescriptif(?string $descriptif): void {
            $this->descriptif = $descriptif;
        }
        public function setDuree(?int $duree): void {
            if ($duree !== null && $duree < 0) {
                throw new InvalidArgumentException("La durée ne peut pas être négative.");
            }
            $this->duree = $duree;
        }
        public function setIntitule(?string $intitule): void {
            $this->intitule = $intitule;
        }
        public function setDateOuvertInscriptions(?String $dateOuvertInscriptions): void {
            $this->dateOuvertInscriptions = $dateOuvertInscriptions;
        }
        public function setDateClotureInscription(?String $dateClotureInscription): void {
            $this->dateClotureInscriptions = $dateClotureInscription;
        }
        public function setEffectifMax(?int $effectifMax): void {
            $this->effectifMax = $effectifMax;
        }
}