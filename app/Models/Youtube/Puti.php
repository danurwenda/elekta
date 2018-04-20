<?php namespace App\Models\Youtube;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Puti extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'youtubeputi';
	//protected $dates = ['published'];

}