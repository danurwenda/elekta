<?php namespace App\Models\Gplus;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Emil extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'gplusemil';
	//protected $dates = ['published'];

}