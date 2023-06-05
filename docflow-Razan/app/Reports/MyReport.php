<?php


namespace App\Reports;


use App\Models\Core\Mongo\User;
use App\Models\Obj\App;
use koolreport\export\Exportable;

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship, Exportable;
    function settings()
    {
        return array(
            "dataSources"=>array(
                "elo"=>array(
                    "class"=>'\koolreport\laravel\Eloquent', // This is important
                )
            )
        );
    }

    function setup()
    {
        $this->src('elo')->query(
            User::orderBy('name', 'asc')
        )->pipe($this->dataStore('users'));
    }

}
