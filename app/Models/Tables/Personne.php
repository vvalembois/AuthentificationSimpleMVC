<?php


namespace Models\Tables;

use Helpers\DB\Entity;

class Personne extends Entity {
    public $nom;
    public $prenom;
    public $genre;
    public $num_et_rue;
    public $code_postal;
    public $ville;
    public $tel;
    public $email;
    public $ddn;

    /**
     * Personne constructor.
     * @param $nom
     * @param $prenom
     * @param $genre
     * @param $num_et_rue
     * @param $code_postal
     * @param $ville
     * @param $tel
     * @param $email
     * @param $ddn
     */
    public function __construct(
        $nom = "",
        $prenom = "",
        $genre = "",
        $num_et_rue = "",
        $code_postal = "",
        $ville = "",
        $tel = "",
        $email = "",
        $ddn = "",
        $id = false
    ) {
        parent::__construct($id);
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->genre = $genre;
        $this->num_et_rue = $num_et_rue;
        $this->code_postal = $code_postal;
        $this->ville = $ville;
        $this->tel = $tel;
        $this->email = $email;
        $this->ddn = $ddn;
    }

}