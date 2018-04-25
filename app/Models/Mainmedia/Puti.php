<?php namespace App\Models\Mainmedia;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Puti extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'galertputi';
	//protected $dates = ['published'];

}