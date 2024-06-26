<?php


namespace App\Services;

use App\Models\Abonnement;
use App\Models\AbonnementType;
use App\Models\Pass;
use App\Models\Place;
use App\Models\Transactions;
use App\Models\User;
use App\Models\VisitesDone;

class AbonnementServices{

    //constructor
    
    
    /// this sevice will hold the methods and function to act on abonnement


    /// create an abonnement
    public function newAbonnement(User $user, AbonnementType $abonnementType, Transactions $transaction, bool $afterLast = false, int $mois = 1) : Abonnement{
        /// create a new abonnement for the user fascade according to the abonnement type and the transaction.

        $fascade = $user->fascadeImmo;

        /// 1. check the last abonnement
        /// 2. if afterLast => true, start day = end day of last abonement +1 day
        /// 3. if afterLast => false, start day = today

        $actual_abonnement = $fascade->latestAbonnement();
        if ($afterLast) {
            $start = $actual_abonnement->end_date;
        }else{
            $start = today();
        }

        $timeline = '+ '.$mois.' month';

        $abonnement = Abonnement::create([
            'start_date' => $start,
            'end_date' => date('Y-m-d', strtotime($timeline, $start->toDate()->getTimestamp())),
            'facade_id' => $fascade->id,
            'transaction_id' => $transaction->id,
            'type' => $abonnementType->type,
            'type_abonnement_id' => $abonnementType->id,
        ]);
        return $abonnement;
    }

    /// create free abonnement
    /// create a free abonnement for one month if no abonnement present
    public function defaultAbonnement(User $user) : Abonnement{
        /// create a new abonnement for the user fascade 
        $fascade = $user->fascadeImmo;

        $transaction =( new TransactionServices())->freeTrannsaction();
        $ab = AbonnementType::where('title', 'Gratuit')->first();

        $abonnement = Abonnement::create([
            'start_date' => today(),
            'end_date' => date('Y-m-d', strtotime(' + 1 month')),
            'facade_id' => $fascade->id,
            'transaction_id' => $transaction->id,
            'type' => $ab->type,
            'type_abonnement_id' => $ab->id,
        ]);
        return $abonnement;
    }

    /// calculate abonnement return on visite
    public function gotVisited($visite_done_id){
        $visite_done = VisitesDone::find($visite_done_id);
        $pass = $visite_done->pass;
        $pass_type = $pass->pass_type;
        $place = $visite_done->place;

        $f_ab = AbonnementType::where('price', 0)->first();

        $fascade = $place->fascadeImmo;
        $abonnement = Abonnement::where('facade_id', $fascade->id)->whereNot('type_abonnement_id', $f_ab->id)->whereDate('end_date', '>=', $visite_done->created_at)->whereDate('start_date', '<=', $visite_done->created_at)
        ->first();
        if ($abonnement) {
            $type = $abonnement->abonnement_type;
    
            // calculate user part
            $p = (int)$pass_type->price;
            $visitePrice = $p / $pass_type->nb_visite;
            $dem_part = ($visitePrice/100) * $type->pourcentage_demarcheur;
    
            // update user data and save
            $fascade->balance = floatval($fascade->balance) + $dem_part;
            $fascade->save();
        }

    }

}