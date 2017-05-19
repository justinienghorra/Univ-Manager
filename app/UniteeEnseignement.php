<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UniteeEnseignement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unitee_enseignements';


    /**
     * Retourne le responsable de l'ue
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function responsable() {
        return $this->hasOne('App\ResponsableUniteeEnseignement', 'id_ue');
    }

    /**

     * Retourne faux si l'UE n'a pas de responsable
     *
     * @return bool
     */
    public function hasResponsable() {
        return $this->responsable != null;
    }

    public function enseignants() {
        return $this->hasMany('App\EnseignantDansUE', 'id_ue');
    }

    public function getCMNbHeuresAffectees() {
        $nbHeures = 0;
        foreach ($this->enseignants as $enseignant) {
            $nbHeures += $enseignant->cm_nb_heures;
        }
        return $nbHeures;
    }
}
