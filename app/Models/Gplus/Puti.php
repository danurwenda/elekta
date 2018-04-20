<?php namespace App\Models\Gplus;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Puti extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'gplusputi';
	//protected $dates = ['published'];

}