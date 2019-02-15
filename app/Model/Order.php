<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model{

    protected $fillable = ['id', 'amount' , 'outlet_id'];	// fields that can be mass assigned
    protected $hidden = [ 'created_at', 'updated_at'];	//	array of fields that are to be ignored i.e. not pulled from the database
    protected $table = 'order';

    /* Relationship Methods */
    public function outlet() {
        return $this->belongsTo('App\Model\Outlet');
    }
    /* Relationship Methods */

}
