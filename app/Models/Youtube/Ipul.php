<?php namespace App\Models\Youtube;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Ipul extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'youtubegusipul';
	//protected $dates = ['published'];

}