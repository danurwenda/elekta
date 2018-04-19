<?php namespace App\Models\Twitter;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Emil extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'twitterEmilDardak';
	//protected $dates = ['published'];

}