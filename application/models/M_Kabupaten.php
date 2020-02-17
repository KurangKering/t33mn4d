<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Kabupaten extends Eloquent
{
	protected $table = 'kabupaten';
	protected $primaryKey = 'kabupaten_id';
	public $timestamps = false;
	protected $fillable = [
		'kabupaten_nama',
	];

	public function dataKecamatan()
	{
		return $this->hasMany(new M_Kecamatan(),'kecamatan_kabupaten_id','kabupaten_id');
	}


}