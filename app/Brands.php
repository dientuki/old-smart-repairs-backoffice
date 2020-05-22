<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
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
     * @var string
     */
    protected $order = array('asc', 'desc');

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
}
