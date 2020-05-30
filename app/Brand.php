<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brands';

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
    protected $fillable = ['brand'];

    /**
     * Return all the records with order
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getAll()
    {
        $request = request();
        $queries = [];
        
        $brands = $this->select('id', 'brand');
        
        $brands->orderBy('brand', 'asc');
        $queries['order'] = 'asc';

        if ($request->has('order')) {
            if (in_array($request->get('order'), $this->order)) {
                $brands->reorder('brand', $request->get('order'));
                $queries['order'] = $request->get('order');
            }
        }

        return $brands->simplePaginate(20)->appends($queries);
    }

    public function getLists()
    {
        return $this->orderBy('brand')->pluck('brand', 'id');
    }

    public function device()
    {
        return $this->hasOne('App\Device');
    }
}
