<?php
namespace App\Helpers\App;

use App\Models\Core\Mongo\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Central\Hrm\Recruitment\Applicant;

class HrmUtil {

    public static function getApplicant(){
        $applicant = Applicant::get();

        return $applicant;
    }

    public static function getPersonnel(){
        
        $auth = Auth::user();
        
        if(isset($auth->statusEmployee) && !is_null($auth->statusEmployee) && $auth->statusEmployee != '' && $auth->statusEmployee != 'not-applicable') {

            $personel = User::where('name', $auth->name)->get();

        } else {

            $personel = User::get();
        }

        return $personel;
    }
}