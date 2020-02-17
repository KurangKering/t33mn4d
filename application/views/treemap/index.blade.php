@extends('layouts.layout')
@section('css-export')

@endsection
@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Visualisasi Treemap</h3>
		</div>

		{{-- <div class="title_right">
			<div class="col-md-3 col-sm-5   form-group pull-right top_search">
				
				<div class="input-group">
					<button class="btn btn-outline-primary" id="btn-tambah" type="button">Tambah Data</button>
				</div>
			</div>
		</div> --}}
	</div>


	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-6 col-sm-12 ">
			<div class="x_panel">
				<div class="x_title">
					<h2>Filter Data</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Puskesmas 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select name="puskesmas" class="form-control">
									<option value="">Semua Puskesmas</option>
									@foreach($data['puskesmas'] as $puskesmas)
									<option value="{{ $puskesmas->puskesmas_id }}">{{ $puskesmas->puskesmas_nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Penyakit 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select name="penyakit" class="form-control">
									<option value="">Semua Penyakit</option>
									@foreach($data['penyakit'] as $penyakit)
									<option value="{{ $penyakit->penyakit_id }}">{{ $penyakit->penyakit_nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tahun 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select name="tahun" class="form-control">
									@foreach($data['tahun'] as $tahun)
									<option value="{{ $tahun }}">{{ $tahun }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Bulan 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select name="bulan" class="form-control">
									<option value="">Semua Bulan</option>
									@foreach($data['bulan'] as $k => $bulan)
									<option value="{{ $k }}">{{ $bulan }}</option>
									@endforeach
								</select>
							</div>
						</div>

					</form>

				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 ">
			<div class="x_panel">
				<div class="x_title">
					<h2>Urutan Tampilan Data</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div id="example1" class="list-group col">
						<div class="list-group-item urutan" data-value="0"><i class="fa fa-arrows handle"></i> Data Kabupaten</div>
						<div class="list-group-item urutan" data-value="1"><i class="fa fa-arrows handle"></i> Data Kecamatan</div>
						<div class="list-group-item urutan" data-value="2"><i class="fa fa-arrows handle"></i> Data Puskesmas</div>
						<div class="list-group-item urutan" data-value="3"><i class="fa fa-arrows handle"></i> Status Penyakit</div>
						<div class="list-group-item urutan" data-value="4"><i class="fa fa-arrows handle"></i> Penyakit</div>
						<div class="list-group-item urutan" data-value="5"><i class="fa fa-arrows handle"></i> Bulan</div>
					</div>

				</div>
			</div>
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">

				<div class="x_content">

					<figure class="highcharts-figure">

						<div id="container"></div>

					</figure>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection
@section('js-export')
<script src="{{ base_url("assets/templates/vendors/highcharts/highcharts.js") }}"></script>
<script src="{{ base_url("assets/templates/vendors/highcharts/modules/data.js") }}"></script>
{{-- <script src="{{ base_url("assets/templates/vendors/highcharts/modules/heatmap.js") }}"></script> --}}
<script src="{{ base_url("assets/templates/vendors/highcharts/modules/treemap.js") }}"></script>
<script src="{{ base_url("assets/templates/vendors/highcharts/modules/offline-exporting.js") }}"></script>
<script src="{{ base_url("assets/templates/vendors/highcharts/modules/accessibility.js") }}"></script>
<script src="{{ base_url("assets/templates/vendors/highcharts/modules/boost.js") }}"></script>
<script src="{{ base_url("assets/sortablejs-1.10.2/package/Sortable.min.js") }}"></script>
@endsection
@section('js-inline')
<script>
	var example1 = null;
	var urutan = [];

	var insHighchart = null;
	var points = null;
	var previousLink = [];
	var idnya = null;
	var $tahun = null;
	var $puskesmas = null;
	var $penyakit = null;
	var $bulan = null;
	var $urutan = [];
	$(function() {
		$tahun = $("select[name=tahun]");
		$puskesmas = $("select[name=puskesmas]");
		$penyakit = $("select[name='penyakit']");
		$bulan = $("select[name=bulan]");

		generateHighTreemap()
		.then(resp => {
			insHighchart = resp;
			insHighchart.showLoading();
			fetchData("").then(r =>
			{
				points = r;


				insHighchart.setTitle({text:''});
				insHighchart.series[0].setData(r);
				insHighchart.hideLoading();

			});

		});

		example1 = document.getElementById('example1');

		new Sortable(example1, {
			animation: 150,
			handle: ".handle",
			// ghostClass: 'blue-background-class',
			onEnd: function (evt) {
				var itemEl = evt.item;  
				evt.to;    
				evt.from;  
				evt.oldIndex;  
				evt.newIndex;  
				evt.oldDraggableIndex;
				evt.newDraggableIndex;
				evt.clone 
				evt.pullMode;  

				$urutan = [];
				$(example1).find('.urutan').each(function(i,e) {$urutan.push($(e).attr('data-value'))});


				updateData();

			},

		});


		$tahun.add($puskesmas).add($penyakit).add($bulan).change(function(event) {
			updateData();

		});


	});
	$("#btn-back").click(function(event) {
		if (previousLink.length <= 0) {
			return;
		}
		idnya = previousLink.pop();
		var dataSet = points.filter(function(ee) {
			return ee.parentt == idnya;
		});

		insHighchart.series[0].update({data:dataSet});
		insHighchart.hideLoading();
		if (dataSet.length > 0 ) {


		}
	});	





	function updateData() {
		var post =  {
			puskesmas: $puskesmas.val(),
			penyakit: $penyakit.val(),
			tahun: $tahun.val(),
			bulan: $bulan.val(),
			urutan: $urutan,
		};

		post = Object.keys(post).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(post[key])).join('&')

		insHighchart.showLoading();
		fetchData(post).then(r =>
		{
			points = r;

			insHighchart.series[0].setData(points);
			insHighchart.hideLoading();

		}
		);
	}

	

	function generateHighTreemap() {

		return new Promise((resolve, reject) => {
			var options = {
				series: [{
					type: 'treemap',
					layoutAlgorithm: 'squarified',
					allowDrillToNode: true,
					animationLimit: 1000,
					dataLabels: {
						enabled: false
					},
					levelIsConstant: false,
					levels: [{
						level: 1,
						dataLabels: {
							enabled: true
						},
						borderWidth: 3
					}],
				}],
				title: {
					text: ''
				},
			};
			const chart = Highcharts.chart('container', options);
			resolve(chart);
		});

	}


	async function fetchData(values) {
		var url = "{{ base_url('data-treemap/map?') }}"+values;
		const response = await fetch(url, {
			method: 'GET',
		});
		return await response.json();
	}


</script>
@endsection
