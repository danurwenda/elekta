<?php namespace App\Models\Twitter;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Khofifah extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'twitterKhofifahIP';
	//protected $dates = ['published'];

}