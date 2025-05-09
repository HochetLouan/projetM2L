<?php
class Utilisateur{
	private ?int $idUser;
    private ?string $nom;
    private ?string $prenom;
    private ?string $login;
	private ?string $mdp;
	private ?string $typeUser;
    private ?int $idClub;
    private ?int $idLigue;
    private ?int $idFonction;

    public function __construct(?string $pLogin, ?string $pMdp){
        $this->login = $pLogin;
		$this->mdp = $pMdp;
    }

	public function getIdUser(): int{
		return $this->idUser;
	}

	public function getNom(): string {
		return $this->nom;
	}

	public function setNom(int $nom): void {
		$this->nom = $nom;
	}

	public function getLogin(): string {
		return $this->login;
	}

	public function setLogin(string $login): void {
		$this->login = $login;
	}

	public function getMdp(): string {
		return $this->mdp;
	}

	public function setMdp(string $mdp): void {
		$this->mdp = $mdp;
	}

	public function getTypeUser(): string {
		return $this->typeUser;
	}

	public function setTypeUser(string $typeUser): void {
		$this->typeUser = $typeUser;
	}
}