<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Kelompok_Penyakit extends Eloquent
{
	protected $table = 'kelompok_penyakit';
	protected $primaryKey = 'kelompok_penyakit_id';
	public $timestamps = false;
	protected $fillable = [
		'kelompok_penyakit_kode',
		'kelompok_penyakit_nama',
	];

	public function dataPenyakit()
	{
		return $this->hasMany(new M_Penyakit(), 'penyakit_kelompok_penyakit_id', 'kelompok_penyakit_id');
	}

}