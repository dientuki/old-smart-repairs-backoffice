<?php

namespace App;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Part extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parts';

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
    protected $fillable = ['name', 'code'];

    /**
     * Return all the records with order
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getAll()
    {
        $request = request();
        $queries = [];
        
        $names = $this->select('id', 'name', 'code');
        
        $names->orderBy('name', 'asc');
        $queries['order'] = 'asc';

        if ($request->has('order')) {
            if (in_array($request->get('order'), $this->order)) {
                $names->reorder('name', $request->get('order'));
                $queries['order'] = $request->get('order');
            }
        }

        return $names->simplePaginate(20)->appends($queries);
    }

    /**
     * Return all the records with order to use in combo
     *
     * @return \Illuminate\Support\Collection
     */
    public function getLists()
    {
        return $this->orderBy('name')->pluck('name', 'id');
    }  
}
