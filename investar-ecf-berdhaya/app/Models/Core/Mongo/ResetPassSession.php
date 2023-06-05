<?php
namespace App\Models\Core\Mongo;
use App\Casts\MongoUTC;
use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class ResetPassSession extends Eloquent {

    protected $connection = 'mongousr';
    protected $collection = 'reset_sessions';
    protected $guarded = ['id','_id'];

    protected $casts = [
        'created_at'=>MongoUTC::class,
        'updated_at'=>MongoUTC::class,
        'createdAt'=>MongoUTC::class,
        'updatedAt'=> MongoUTC::class,
        'createdDate'=>MongoUTC::class,
        'lastUpdate'=> MongoUTC::class,
        'startDate'=>MongoUTC::class,
        'endDate'=> MongoUTC::class,
        'upTs'=>'double'
    ];

    public function getID($entity) {
        $seq = DB::collection('seqs')->findOneAndUpdate(
            ['_id' => $entity],
            ['$inc' => ['seq' => 1]],
            ['seq'=>1],
            [
                'new' => true,
                'upsert' => true
            ]
        );

        if($seq){
            return $seq['seq'];
        }else{
            if($this->setInitialValue($entity,1)){
                return 1;
            }
        }
    }


    public function getNewId($entity)
    {
        $seq = DB::connection('mongousr')
            ->collection($this->collection)->raw();

        $new_id = $seq->findOneAndUpdate(
            ['_id'=>$entity],
            ['$inc'=>['seq'=>1]],
            [
                'new' => true,
                'upsert'=>true
            ]
        );

        return intval($this->getLastId($entity));
    }

    public function getLastId($entity)
    {
        $last_id = $this->find($entity);

        $last_id = $last_id['seq'];

        return $last_id;
    }

    public function setInitialValue($entity,$initial = 0)
    {
        if($this->find($entity)){
            return false;
        }else{

            // $initial = new \MongoInt32($initial);

            return $this->insert(array('_id'=>$entity,'seq'=>$initial), array('upsert'=>1));
        }
    }
}

