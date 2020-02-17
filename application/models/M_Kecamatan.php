<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Kecamatan extends Eloquent
{
	protected $table = 'kecamatan';
	protected $primaryKey = 'kecamatan_id';
	public $timestamps = false;
	protected $fillable = [
		'kecamatan_nama',
		'kecamatan_kabupaten_id'
	];

	public function dataKabupaten()
	{
		return $this->belongsTo(new M_Kabupaten(),'kecamatan_kabupaten_id');
	}

	public function dataPuskesmas()
	{
		return $this->hasMany(new M_Puskesmas(),'puskesmas_kecamatan_id', 'kecamatan_id');
	}

}