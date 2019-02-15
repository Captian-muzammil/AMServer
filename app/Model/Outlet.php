<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: Muzammil
 * Date: 16/02/2019
 * Time: 12:01 AM
 */


class Outlet extends Model{

    protected $fillable = ['id', 'name' ];	// fields that can be mass assigned
    protected $hidden = [ 'created_at', 'updated_at'];	//	array of fields that are to be ignored i.e. not pulled from the database
    protected $table = 'outlet';
}
