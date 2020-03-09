@extends('layouts.layout')
@section('css-export')

@endsection
@section('css-inline')
<style>
	#container {
		min-height: 800px;
	}
</style>
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
							<label class="col-form-label col-md-3 col-sm-3 label-align" >Kabupaten 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select id="kabupaten" name="kabupaten" class="form-control">
									<option value="">Semua Kabupaten</option>
									@foreach($data['kabupaten'] as $kabupaten)
									<option value="{{ $kabupaten->kabupaten_id }}">{{ $kabupaten->kabupaten_nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" >Kecamatan 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select id="kecamatan" name="kecamatan" class="form-control">
									<option value="">Semua Kecamatan</option>
									@foreach($data['kecamatan'] as $kecamatan)
									<option value="{{ $kecamatan->kecamatan_id }}" data-chained="{{ $kecamatan->kecamatan_kabupaten_id }}">{{ $kecamatan->kecamatan_nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" >Puskesmas 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select id="puskesmas" name="puskesmas" class="form-control">
									<option value="">Semua Puskesmas</option>
									@foreach($data['puskesmas'] as $puskesmas)
									<option value="{{ $puskesmas->puskesmas_id }}" data-chained="{{ $puskesmas->puskesmas_kecamatan_id }}">{{ $puskesmas->puskesmas_nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" >status 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select id="status" name="status" class="form-control">
									<option value="">Semua status</option>
									@foreach($data['status'] as $ks => $vs)
									<option value="{{ $ks }}">{{ $vs }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" >Penyakit 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select id="penyakit" name="penyakit" class="form-control">
									<option value="">Semua Penyakit</option>
									@foreach($data['penyakit'] as $penyakit)
									<option value="{{ $penyakit->penyakit_id }}" data-chained="{{ $penyakit->penyakit_status }}">{{ $penyakit->penyakit_nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" >Tahun 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select id="tahun" name="tahun" class="form-control">
									@foreach($data['tahun'] as $tahun)
									<option value="{{ $tahun }}">{{ $tahun }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" >Bulan 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select id="bulan" name="bulan" class="form-control">
									<option value="">Semua Bulan</option>
									@foreach($data['bulan'] as $k => $bulan)
									<option 
									@if ($k == date('n'))
									selected
									@endif

									value="{{ $k }}">{{ $bulan }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" >Penyakit Terbanyak 
							</label>
							<div class="col-md-9 col-sm-9 ">
								<select id="terbanyak" name="terbanyak" class="form-control">
									<option value="">Semua Penyakit</option>
									@foreach(range(1,10) as $range)
									<option 
									

									value="{{ $range }}">{{ "{$range} Besar" }}</option>
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
					<div class="dashboard-widget-content">

						<ul class="list-unstyled timeline widget list-group col" id="example1">
							<li class="urutan" data-value="0">
								<div class="block">
									<div class="block_content">
										<h2 class="title">
											<a>Data Kabupaten</a>
										</h2>
									</div>
								</div>
							</li>
							<li class="urutan" data-value="1">
								<div class="block">
									<div class="block_content">
										<h2 class="title">
											<a>Data Kecamatan</a>
										</h2>
									</div>
								</div>
							</li>
							<li class="urutan" data-value="2">
								<div class="block">
									<div class="block_content">
										<h2 class="title">
											<a>Data Puskesmas</a>
										</h2>
									</div>
								</div>
							</li>
							<li class="urutan" data-value="3">
								<div class="block">
									<div class="block_content">
										<h2 class="title">
											<a>Status Penyakit</a>
										</h2>
									</div>
								</div>
							</li>
							<li class="urutan" data-value="4">
								<div class="block">
									<div class="block_content">
										<h2 class="title">
											<a>Penyakit</a>
										</h2>
									</div>
								</div>
							</li>
							<li class="urutan" data-value="5">
								<div class="block">
									<div class="block_content">
										<h2 class="title">
											<a>Bulan</a>
										</h2>
									</div>
								</div>
							</li>
						</ul>
					</div>

					{{-- <div id="example1" class="list-group col">
						<div class="list-group-item urutan" data-value="0"><i class="fa fa-arrows handle"></i> Data Kabupaten</div>
						<div class="list-group-item urutan" data-value="1"><i class="fa fa-arrows handle"></i> Data Kecamatan</div>
						<div class="list-group-item urutan" data-value="2"><i class="fa fa-arrows handle"></i> Data Puskesmas</div>
						<div class="list-group-item urutan" data-value="3"><i class="fa fa-arrows handle"></i> Status Penyakit</div>
						<div class="list-group-item urutan" data-value="4"><i class="fa fa-arrows handle"></i> Penyakit</div>
						<div class="list-group-item urutan" data-value="5"><i class="fa fa-arrows handle"></i> Bulan</div>
					</div> --}}

				</div>
			</div>
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<ul class="nav navbar-right panel_toolbox">

						<button type="button" class="btn btn-primary" id="btn-print">Print Me</button>
						<a style="" class="btn-md btn " id="btn-back" href="javascript:void(0);"><i class="fa fa-backward fa-1x"></i></a>
					</li>

				</li>
			</ul>
			<div class="clearfix"></div>
		</div>

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
<script src="{{ base_url('assets/jsPDF-1.3.2/dist/jspdf.min.js') }}"></script>
<script src="{{ base_url('assets/jsPDF-1.3.2/plugins/from_html.js') }}"></script>
<script src="{{ base_url('assets/jsPDF-1.3.2/plugins/split_text_to_size.js') }}"></script>
<script src="{{ base_url('assets/jsPDF-1.3.2/plugins/standard_fonts_metrics.js') }}"></script>

@endsection
@section('js-inline')
<script>
	var example1 = null;

	var insHighchart = null;
	var points = null;
	var isitable = null;
	var previousLink = [];
	var idnya = null;
	var $kabupaten = null;
	var $kecamatan = null;
	var $puskesmas = null;
	var $status = null;
	var $penyakit = null;
	var $tahun = null;
	var $bulan = null;
	var $terbanyak = null;
	var $urutan = [];
	let $tableHaji = null;
	let isRequesting = false;
	let sortable = null;
	let postData = null;
	let $btnPrint = null;

	$(function() {
		$kabupaten = $("select[name=kabupaten]");
		$kecamatan = $("select[name=kecamatan]");
		$puskesmas = $("select[name=puskesmas]");
		$status = $("select[name=status]");
		$penyakit = $("select[name=penyakit]");
		$tahun = $("select[name=tahun]");
		$bulan = $("select[name=bulan]");
		$terbanyak = $("select[name=terbanyak]");
		$btnPrint = $("#btn-print");

		$(example1).find('.urutan').each(function(i,e) {$urutan.push($(e).attr('data-value'))});

		$("#kecamatan").chained("#kabupaten");
		$("#puskesmas").chained("#kecamatan");
		$("#penyakit").chained("#status");


		$tableHaji = $('#table-haji').DataTable({ 
			"lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
			"bAutoWidth": false ,
			scrollX:        true,
			scrollCollapse: true,
			"order": [], 
			"columns": [
			{ "data": "haji_nomor_porsi" },
			{ "data": "haji_tahun" },
			{ "data": "haji_nama" },
			{ "data": "haji_usia" },
			{ "data": "jenis_kelamin" },
			{ "data": "status_jemaah" },
			{ "data": "haji_regu_id" },
			{ "data": "haji_rombongan_id" },
			{ "data": "haji_kloter_id" },
			{ "data": "nama_kota" },
			{ "data": "nama_provinsi" },
			],

		});

		generateHighTreemap()
		.then(resp => {
			insHighchart = resp;
			insHighchart.showLoading();
			fetchData("").then(r =>
			{
				isitable = r.table;
				points = r.data;

				$tableHaji.clear();
				$tableHaji.rows.add(isitable);
				$tableHaji.draw();

				dataSet = points.filter(function($el) {
					return $el.parentt == "";
				});

				insHighchart.setTitle({text:'Data Penyakit'});
				insHighchart.setSubtitle({text:r.subtitle});
				insHighchart.series[0].setData(dataSet, true);
				insHighchart.hideLoading();

			});

		});

		example1 = document.getElementById('example1');

		sortable = new Sortable(example1, {
			animation: 150,
			ghostClass: 'blue-background-class',



			onEnd: function(evt) {

				previousLink = [];
				$urutan = [];
				$(example1).find('.urutan').each(function(i,e) {$urutan.push($(e).attr('data-value'))});


				updateData(insHighchart);
			}

		});

		// $('select').each(function() {
		// 	$(this).data('lastSelected', $(this).find('option:selected'));
		// });
		// var lastSel = $bulan.find("option:selected");

		$('select').each(function(index, el) {
			// var lastSel = $(el).find("option:selected");
			$(el).change(function(ech) {
				// if(isRequesting)
				// {
				// 	lastSel.prop("selected", true);
				// 	return;
				// }
				// 
				// if ($("penyakit").val() != "") {
				// 	$("#terbanyak").prop('selectedIndex',0);
				// } if ($("penyakit").val() != "") {
				// 	$("#terbanyak").prop('selectedIndex',0);
				// } 
				

				if ($(el).attr('id') == 'penyakit') {
					if ($(el).val() != "") {
						$("#terbanyak").prop('selectedIndex',0);
					}
				} else if ($(el).attr('id') == 'terbanyak') {
					if ($(el).val() != "") {
						$("#penyakit").prop('selectedIndex',0);
					}
				}
				previousLink = [];

				updateData(insHighchart);

			});

			// $(el).click(function(ecl) {
			// 	lastSel = $(el).find("option:selected");
			// });


			
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

		$("#btn-print").click(printReport);


	});

	function printReport() {

		var kabupaten = $kabupaten.val();
		var kecamatan = $kecamatan.val();
		var puskesmas = $puskesmas.val();
		var status = $status.val();
		var penyakit = $penyakit.val();
		var tahun = $tahun.val();
		var bulan = $bulan.val();
		var terbanyak = $terbanyak.val();

		var urutan =  checkSequential($urutan);
		


		post = {
			kabupaten,
			kecamatan,
			puskesmas,
			status,
			penyakit,
			tahun,
			bulan,
			terbanyak,
		};


		post = Object.keys(post).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(post[key])).join('&');
		
		postData = post;

		axios.post("{{ base_url('data-treemap/report') }}", postData)
		.then((res) => {
			let data = res.data;


			if (data.success == 0) {

			} else {
				let doc = new jsPDF();          

				let source = data.source;
				doc.fromHTML(
					source,
					15,
					15,
					{
						'width': 180,
					});

				var blob = doc.output("blob");
				window.open(URL.createObjectURL(blob));
			}
		})
	}
	function checkSequential(arr) {
		seq =  arr.every((num, i) => i === arr.length - 1 || num < arr[i + 1]);
		if (seq) {
			return "sama";
		} else {
			return arr;
		}
	}

	function updateData(chart) {

		var kabupaten = $kabupaten.val();
		var kecamatan = $kecamatan.val();
		var puskesmas = $puskesmas.val();
		var status = $status.val();
		var penyakit = $penyakit.val();
		var tahun = $tahun.val();
		var bulan = $bulan.val();
		var terbanyak = $terbanyak.val();

		var urutan =  checkSequential($urutan);
		


		post = {
			kabupaten,
			kecamatan,
			puskesmas,
			status,
			penyakit,
			tahun,
			bulan,
			terbanyak,
			urutan,
		};


		post = Object.keys(post).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(post[key])).join('&');
		
		postData = post;

		chart.showLoading();
		fetchData(post).then(r =>
		{
			points = r.data;
			isitable = r.table;
			$tableHaji.clear();
			$tableHaji.rows.add(isitable);
			$tableHaji.draw();
			dataSet = points.filter(function($el) {
				return $el.parentt == "";
			});
			chart.setSubtitle({text:r.subtitle});
			chart.series[0].setData(dataSet);
			chart.hideLoading();

		}
		);
	}

	function generateHighTreemap() {

		return new Promise((resolve, reject) => {
			var options = {
				series: [{
					type: 'treemap',
					alternateStartingDirection: true,
					layoutAlgorithm: 'squarified',
					allowDrillToNode: true,
					animation:true,
					dataLabels: {
						enabled: true,
						style: {
							fontSize: "14px",
							textOutline: false,


						}
					},
					hover: {
						color:'red'
					},
					borderWidth: 3,
					borderColor: "white",

					data:[],
					point: {
						
						events: {
							click: function(e) {
								id = this.id;
								parentt = this.parentt;
								var dataSet = points.filter(function(ee) {
									return ee.parentt == this.id;
								});

								if (dataSet.length > 0 ) {
									previousLink.push(this.parentt);

									insHighchart.series[0].setData(dataSet, true);
									insHighchart.hideLoading();

								}

								// if (this.status == 4) {
								// 	$("#content-peserta").html(this.description);
								// 	$("#modalDetail").modal('show');
								// }


							},
							// mouseOver: function() {
							// 	originalColor = this.color;
							// 	originalBorderColor = this.borderColor;

							// 	this.update({
							// 		color: 'white',
							// 		borderColor: 'black',
							// 	});
							// },
							// mouseOut: function() {
							// 	this.update({
							// 		color: originalColor,
							// 		borderColor: originalBorderColor
							// 	});
							// }
						}
					},

				}],

				plotOptions: {
					treemap: {
						states: {
							hover: {
								borderColor: "#6c757d",
								borderWidth: 2,

								
								// lineWidthPlus: 10
							}
						}
					}
				},
				tooltip: {
					style: {
						fontSize: "16px",
						'z-index': '9999',
					},
					useHTML: true,
					borderRadius: 1,
					hideDelay:"0",
					backgroundColor: "#FFFFFF",

					borderColor: '#AAA',
					formatter: function () {
						// if (this.point.status == 4) {
						// 	return "Click For Detail";
						// } else
						return this.point.description+' ';

					}
				},

				title: {
					text: 'Treemap Penyakit'
				},


			};
			const chart = Highcharts.chart('container', options);
			resolve(chart);
		});

	}


	async function fetchData(values) {
		if (isRequesting == false) {
			disEnElement('disable');
			
			isRequesting = true;
		} 
		var url = "{{ base_url('data-treemap/map?') }}"+values;
		const response = await fetch(url, {
			method: 'GET',
		});
		isRequesting = false;
		disEnElement('enable');
		return await response.json();
	}


	function disEnElement(opsi) {
		if (opsi == 'disable') {
			sortable.option('sort', false);
			$('select').each(function(index, el) {
				$(this).attr('disabled', true);
				
			});
			$("#btn-print").attr('disabled', true);


		} else if(opsi == 'enable') {
			sortable.option('sort', true);
			$('select').each(function(index, el) {
				$(this).attr('disabled', false);
				
			});
			$("#btn-print").attr('disabled', false);

			
		}
	}

	
</script>
@endsection
