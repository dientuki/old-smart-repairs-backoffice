<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'device_types';

    /**
     * The values acepted to order.
     *
     * @var array
     */
    protected $order = array('asc', 'desc');

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['device_type'];

    /**
     * Return all the records with order
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getAll()
    {
        $request = request();
        $queries = [];
        
        $deviceTypes = $this->select('id', 'device_type');
        
        $deviceTypes->orderBy('device_type', 'asc');
        $queries['order'] = 'asc';

        if ($request->has('order')) {
            if (in_array($request->get('order'), $this->order)) {
                $deviceTypes->reorder('device_type', $request->get('order'));
                $queries['order'] = $request->get('order');
            }
        }

        return $deviceTypes->simplePaginate(20)->appends($queries);
    }

    public function getLists()
    {
        return $this->orderBy('device_type')->pluck('device_type', 'id');
    }      

    public function device()
    {
        return $this->hasOne('App\Device');
    }    
}
