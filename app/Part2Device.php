<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part2Device extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'part2device';

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
    protected $fillable = ['part_id', 'device_id'];

    /**
     * Return all the parts from a device
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getAll($device)
    {
        return $this->select('id', 'part_id', 'device_id')
                ->where('device_id', $device)->get();
    }
}
