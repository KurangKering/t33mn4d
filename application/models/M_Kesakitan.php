<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Kesakitan extends Eloquent
{
	protected $table = 'kesakitan';
	protected $primaryKey = 'kesakitan_id';
	public $timestamps = false;
	protected $appends = ["jumlah"];
	protected $fillable = [
		'kesakitan_bulan',
		'kesakitan_tahun',
		'kesakitan_puskesmas_id',
		'kesakitan_penyakit_id',
		'kesakitan_BL',
		'kesakitan_BP',
		'kesakitan_LL',
		'kesakitan_LP',
	];

	

	public function dataPuskesmas()
	{
		return $this->belongsTo(new M_Puskesmas(), 'kesakitan_puskesmas_id');
	}

	public function dataPenyakit()
	{
		return $this->belongsTo(new M_Penyakit(), 'kesakitan_penyakit_id');
	}

	public function getJumlahAttribute()
	{
		return $this->kesakitan_BL + $this->kesakitan_BP
		+ $this->kesakitan_LL + $this->kesakitan_LP;
	}
	

}