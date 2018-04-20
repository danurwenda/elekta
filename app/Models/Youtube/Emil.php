<?php namespace App\Models\Youtube;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Emil extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'youtubeemil';
	//protected $dates = ['published'];

}