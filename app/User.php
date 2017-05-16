<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'email', 'password', 'prenom', 'adresse', 'civilite', 'attente_validation', 'id_statut',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Retourne vrai si l'utilisateur est responsable DI
     *
     * @return boolean
     */
    public function estResponsableDI() {
        $res = ResponsableDepInfo::where('id_utilisateur', $this->id)->count();
        return $res > 0;
    }

    /**
     * Retourne vrai si l'utilisateur est responsable de la Formation $nom_formation
     *
     * @return boolean
     */
    public function estResponsableFormation($nom_formation) {
        $id_formation = Formation::where('nom', '=', $nom_formation)->first();


        if(is_null($id_formation)){
            return false;
        }

        $id_formation = $id_formation->id;

        $res = ResponsableFormation::where('id_utilisateur', '=', $this->id)->where('id_formation', '=', $id_formation)->count();

        return $res > 0;
    }

    /**
     * Retourne le statut
     *
     * @return string
     */
    public function statut() {
        return Statut::where('id', $this->id_statut)->first()->statut;
    }

    public function updateEmail($email){
        User::where('id', $this->id)->update(['email' => $email]);
    }

    public function updatePassword($password){
        User::where('id', $this->id)->update(['password' => $password]);
    }
}
