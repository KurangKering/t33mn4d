<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Pasien extends Eloquent
{
	protected $table = 'pasien';
	protected $primaryKey = 'pasien_id';
	public $timestamps = false;
	protected $fillable = [
		'pasien_nama',
		'pasien_jk',
		'pasien_nama_kk',
		'pasien_alamat',
		'pasien_tanggal_lahir',
		'pasien_tempat_lahir',
		'pasien_puskesmas_id',
	];

	public function dataKesakitan()
	{
		return $this->hasMany(new M_Kesakitan(), 'kesakitan_pasien_id','pasien_id');
	}

	public function dataPuskesmas()
	{
		return $this->belongsTo(new M_Puskesmas(), 'pasien_puskesmas_id');
	}

	

}