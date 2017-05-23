<?php

namespace App\Http\Controllers\Enseignant;

use App\EnseignantDansUE;
use App\EnseignantDansUEExterne;
use App\Photos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class EnseignantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function show(){

        $userA = \Auth::user();
        $respoDI = $userA->estResponsableDI();
        $respoUE = $userA->estResponsableUE();
        $respoForm = $userA->estResponsableForm();
        $tmp = null;

        //recuperation des enseignements de l'utilisateur
        $enseignantDansUEs = $userA->enseignantDansUEs;

        //recuperation des enseignements externe de l'utilisateur
        $enseignantDansUEsExterne = $userA->enseignantDansUEsExterne;


        $photoUrl =  Photos::where('id_utilisateur', $userA->id)->first();


        if ($photoUrl != null){
            $url = $photoUrl->adresse;
            $tmp = explode("images", $url);
        }



        return view('mesEnseignements')->with('userA', $userA)
                                            ->with('enseignantDansUEs', $enseignantDansUEs)
                                            ->with('enseignantDansUEsExterne', $enseignantDansUEsExterne)
                                            ->with('photoUrl', $tmp[1])
                                            ->with('respoDI', $respoDI)
                                            ->with('respoUE', $respoUE)
                                            ->with('respoForm', $respoForm);

    }


    public function updateUE(Request $request){

        $validator = Validator::make($request->all(), [
            'id_utilisateur' => 'bail|required',
            'id_ue' => 'required',
            'cm_volume_affecte' => 'required',
            'td_nb_groupes' => 'required',
            'td_heures_par_groupe' => 'required',
            'tp_nb_groupes' => 'required',
            'tp_heures_par_groupe' => 'required',
            'ei_nb_groupes' => 'required',
            'ei_heures_par_groupe' => 'required',
        ]);


        if (!$validator->fails()) {

            $id_utilisateur = $request->input('id_utilisateur');
            $id_ue = $request->input('id_ue');
            $cm_volume_affecte = $request->input('cm_volume_affecte');
            $td_nb_groupes = $request->input('td_nb_groupes');
            $td_heures_par_groupe = $request->input('td_heures_par_groupe');
            $tp_nb_groupes = $request->input('tp_nb_groupes');
            $tp_heures_par_groupe = $request->input('tp_heures_par_groupe');
            $ei_nb_groupes = $request->input('ei_nb_groupes');
            $ei_heures_par_groupe = $request->input('ei_heures_par_groupe');

            EnseignantDansUE::where('id_utilisateur', $id_utilisateur)
                            ->where('id_ue', $id_ue)
                            ->update(['cm_nb_heures' => $cm_volume_affecte, 'td_nb_groupes' => $td_nb_groupes,
                                'td_heures_par_groupe' => $td_heures_par_groupe, 'tp_nb_groupes' => $tp_nb_groupes,
                                'tp_heures_par_groupe' => $tp_heures_par_groupe, 'ei_nb_groupes' => $ei_nb_groupes,
                                    'ei_heures_par_groupe' => $ei_heures_par_groupe]);

            //TODO : message sur la vue
            return redirect('mesEnseignements')->with('message', 'L\'UE a bien été modifié');
        }else{
            //TODO : mieux afficher messages d'erreurs
            return redirect('mesEnseignements')->withErrors($validator);
        }
    }

    public function updateUEExterne(Request $request){

        $validator = Validator::make($request->all(), [
            'id_utilisateur' => 'bail|required',
            'id_ue_externe' => 'required',
            'nom' => 'required|max:256',
            'description' => 'required',
            'nom_formation' => 'required|max:100',
            'cm_volume_affecte' => 'required',
            'td_nb_groupes' => 'required',
            'td_heures_par_groupe' => 'required',
            'tp_nb_groupes' => 'required',
            'tp_heures_par_groupe' => 'required',
            'ei_nb_groupes' => 'required',
            'ei_heures_par_groupe' => 'required',
        ]);


        if (!$validator->fails()) {

            $id_utilisateur = $request->input('id_utilisateur');
            $id_ue_externe = $request->input('id_ue_externe');
            $nom = $request->input('nom');
            $description = $request->input('description');
            $nom_formation = $request->input('nom_formation');
            $cm_volume_affecte = $request->input('cm_volume_affecte');
            $td_nb_groupes = $request->input('td_nb_groupes');
            $td_heures_par_groupe = $request->input('td_heures_par_groupe');
            $tp_nb_groupes = $request->input('tp_nb_groupes');
            $tp_heures_par_groupe = $request->input('tp_heures_par_groupe');
            $ei_nb_groupes = $request->input('ei_nb_groupes');
            $ei_heures_par_groupe = $request->input('ei_heures_par_groupe');

            EnseignantDansUEExterne::where('id_utilisateur', $id_utilisateur)
                                ->where('id', $id_ue_externe)
                                ->update(['nom' => $nom, 'description' => $description, 'nom_formation' => $nom_formation,
                                    'cm_nb_heures' => $cm_volume_affecte, 'td_nb_groupes' => $td_nb_groupes,
                                    'td_heures_par_groupe' => $td_heures_par_groupe, 'tp_nb_groupes' => $tp_nb_groupes,
                                    'tp_heures_par_groupe' => $tp_heures_par_groupe, 'ei_nb_groupes' => $ei_nb_groupes,
                                    'ei_heures_par_groupe' => $ei_heures_par_groupe]);
            //TODO : message sur la vue
            return redirect('mesEnseignements')->with('message', 'L\'UE externe a bien été modifié');
        }else{
            //TODO : mieux afficher messages d'erreurs
            return redirect('mesEnseignements')->withErrors($validator);
        }
    }

    public function ajouterUEExterne(Request $request){

        $validator = Validator::make($request->all(), [
            'id_utilisateur' => 'bail|required',
            'nom' => 'required|max:256',
            'description' => 'required',
            'nom_formation' => 'required|max:100',
            'cm_volume_affecte' => 'required',
            'td_nb_groupes' => 'required',
            'td_heures_par_groupe' => 'required',
            'tp_nb_groupes' => 'required',
            'tp_heures_par_groupe' => 'required',
            'ei_nb_groupes' => 'required',
            'ei_heures_par_groupe' => 'required',
        ]);


        if (!$validator->fails()) {

            $id_utilisateur = $request->input('id_utilisateur');
            $nom = $request->input('nom');
            $description = $request->input('description');
            $nom_formation = $request->input('nom_formation');
            $cm_volume_affecte = $request->input('cm_volume_affecte');
            $td_nb_groupes = $request->input('td_nb_groupes');
            $td_heures_par_groupe = $request->input('td_heures_par_groupe');
            $tp_nb_groupes = $request->input('tp_nb_groupes');
            $tp_heures_par_groupe = $request->input('tp_heures_par_groupe');
            $ei_nb_groupes = $request->input('ei_nb_groupes');
            $ei_heures_par_groupe = $request->input('ei_heures_par_groupe');

            EnseignantDansUEExterne::insert(['nom' => $nom, 'description' => $description, 'nom_formation' => $nom_formation,
                                'cm_nb_heures' => $cm_volume_affecte, 'td_nb_groupes' => $td_nb_groupes,
                                'td_heures_par_groupe' => $td_heures_par_groupe, 'tp_nb_groupes' => $tp_nb_groupes,
                                'tp_heures_par_groupe' => $tp_heures_par_groupe, 'ei_nb_groupes' => $ei_nb_groupes,
                                'ei_heures_par_groupe' => $ei_heures_par_groupe, 'id_utilisateur' => $id_utilisateur,
                                'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
            //TODO : message sur la vue
            return redirect('mesEnseignements')->with('message', 'L\'UE externe a bien été ajouté');
        }else{
            //TODO : mieux afficher messages d'erreurs
            return redirect('mesEnseignements')->withErrors($validator);
        }
    }
}
