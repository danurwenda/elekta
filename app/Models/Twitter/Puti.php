<?php namespace App\Models\Twitter;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Puti extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'twitterGunturPuti';
	//protected $dates = ['published'];

}