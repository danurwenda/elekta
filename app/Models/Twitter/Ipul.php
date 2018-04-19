<?php namespace App\Models\Twitter;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Ipul extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'twittergusipul4';
	//protected $dates = ['published'];

}