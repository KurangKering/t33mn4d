@extends('layouts.layout')
@section('css-export')

@endsection
@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Data Kesakitan</h3>
		</div>

		<div class="title_right">
			<div class="col-md-3 col-sm-5   form-group pull-right top_search">
				
				<div class="input-group">
					<button class="btn btn-outline-primary" id="btn-tambah" type="button">Tambah Data</button>
				</div>
			</div>
		</div>
	</div>


	<div class="col-md-12 col-sm-12 ">
		<div class="x_panel">

			<div class="x_content">
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box table-responsive">
							<table id="table-pasien" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										
										<th>ID</th>
										<th>Nama</th>
										<th>Jenis Kelamin</th>
										<th>Puskesmas</th>
										<th>Penyakit</th>
										<th>Tanggal </th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>


								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg"  role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-pasien">Tambah Pueskesmas</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<form>
						<input type="hidden" id="id" value="">
						
						


						<div class="row">
							<div class="col-md-6">

								<div class="form-group">
									<label for="message-text" class="col-form-label">Pasien Nama:</label>
									<select id="pasien" class="form-control">
										@foreach ($data['pasien'] as $k => $pasien)
										<option value="{{ $pasien->pasien_id }}">{{ $pasien->pasien_nama }}</option>
										@endforeach
									</select>
									<div class="error"></div>
								</div>
								
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="message-text" class="col-form-label">Penyakit:</label>
									<select id="penyakit" class="form-control">
										@foreach ($data['penyakit'] as $k => $penyakit)
										<option value="{{ $penyakit->penyakit_id }}">{{ $penyakit->penyakit_nama }}</option>
										@endforeach
									</select>
									<div class="error"></div>
								</div>
								<div class="form-group">
									<label for="message-text" class="col-form-label">Tanggal:</label>
									<input type="date" class="form-control" id="tanggal" value="{{ date('Y-m-d') }}" placeholder="">
									<div class="error"></div>
								</div>
							</div>
						</div>

					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btn-submit" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>s
@endsection
@section('js-export')

@endsection
@section('js-inline')
<script>
	$(function() {
		
		Highcharts.chart('container', {
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
				data: points
			}],
			subtitle: {
				text: 'Click points to drill down. Source: <a href="http://apps.who.int/gho/data/node.main.12?lang=en">WHO</a>.'
			},
			title: {
				text: 'Global Mortality Rate 2012, per 100 000 population'
			}
		});
	});
</script>
@endsection
