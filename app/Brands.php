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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    static function getAll() {
        $request = request();
        $queries = [];
        
        $brands = Brands::select('id', 'brand');
        
        if ($request->has('order')) {
          $brands->orderBy('id', $request->get('order'));
          $queries['order'] = $request->get('order');
        } else {
          $brands->orderBy('id', 'desc');
          $queries['order'] = 'desc';
        }  
  
        return $brands->simplePaginate(20)->appends($queries);      
      }    
}
