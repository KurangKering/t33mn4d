<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Penyakit extends Eloquent
{
	protected $table = 'penyakit';
	protected $primaryKey = 'penyakit_id';
	public $timestamps = false;
	protected $fillable = [
		'penyakit_kode',
		'penyakit_nama',
		'penyakit_status',
		'penyakit_kelompok_penyakit_id',
	];

	public function dataKelompokPenyakit()
	{
		return $this->belongsTo(new M_Kelompok_Penyakit(), 'penyakit_kelompok_penyakit_id');
	}

}