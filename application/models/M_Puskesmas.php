<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Puskesmas extends Eloquent
{
	protected $table = 'puskesmas';
	protected $primaryKey = 'puskesmas_id';
	public $timestamps = false;
	protected $fillable = [
		'puskesmas_nama',
		'puskesmas_kecamatan_id',
	];
	public function dataKecamatan()
	{
		return $this->belongsTo(new M_Kecamatan(), 'puskesmas_kecamatan_id');
	}

	
}