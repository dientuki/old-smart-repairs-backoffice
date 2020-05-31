<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'devices';

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
    protected $fillable = ['tradename', 'technical_name', 'url', 'device_type_id', 'brand_id'];

    /**
     * Return all the records with order
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getAll()
    {
        $request = request();
        $queries = [];
        
        $devices = $this->select('id', 'tradename', 'technical_name', 'url', 'device_type_id', 'brand_id');
        
        $devices->orderBy('tradename', 'asc');
        $queries['order'] = 'asc';

        if ($request->has('order')) {
            if (in_array($request->get('order'), $this->order)) {
                $devices->reorder('tradename', $request->get('order'));
                $queries['order'] = $request->get('order');
            }
        }

        return $devices->simplePaginate(20)->appends($queries);
    }

    /**
     * Relationship with device table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deviceType()
    {
        return $this->belongsTo('App\DeviceType');
    }

    /**
     * Relationship with device table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}
