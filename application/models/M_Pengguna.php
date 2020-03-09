<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Pengguna extends Eloquent
{
	protected $table = 'pengguna';
	protected $primaryKey = 'pengguna_id';
	public $timestamps = false;
	protected $fillable = [
		'pengguna_username',
		'pengguna_password',
		'pengguna_akses',
	];


}