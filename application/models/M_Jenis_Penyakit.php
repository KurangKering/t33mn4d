<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Jenis_Penyakit extends Eloquent
{
	protected $table = 'jenis_penyakit';
	protected $primaryKey = 'jenis_penyakit_id';
	public $timestamps = false;
	protected $fillable = [
		'jenis_penyakit_nama',
		'jenis_penyakit_kode',
	];

	public function dataPenyakit()
	{
		return $this->hasMany(new M_Penyakit(), 'penyakit_jenis_penyakit_id','jenis_penyakit_id');
	}

}