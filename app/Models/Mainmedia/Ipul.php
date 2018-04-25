<?php namespace App\Models\Mainmedia;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Ipul extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'galertipul';
	//protected $dates = ['published'];

}