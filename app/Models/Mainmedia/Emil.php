<?php namespace App\Models\Mainmedia;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Emil extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'galertemil';
	//protected $dates = ['published'];

}