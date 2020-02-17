<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Kesakitan extends Eloquent
{
	protected $table = 'kesakitan';
	protected $primaryKey = 'kesakitan_id';
	public $timestamps = false;
	protected $appends = ["bulan", "tahun"];
	protected $fillable = [
		'kesakitan_penyakit_id',
		'kesakitan_pasien_id',
		'kesakitan_tanggal',
		'kesakitan_status',
		'kesakitan_tindakan',
	];

	protected $dates = [
		'kesakitan_tanggal'
	];

	public function dataPenyakit()
	{
		return $this->belongsTo(new M_Penyakit(), 'kesakitan_penyakit_id');
	}

	
	public function dataPasien()
	{
		return $this->belongsTo(new M_Pasien(), 'kesakitan_pasien_id');
	}

	public function getBulanAttribute()
	{
		return $this->kesakitan_tanggal->month;
	}

	public function getTahunAttribute()
	{
		return $this->kesakitan_tanggal->year;
	}

}