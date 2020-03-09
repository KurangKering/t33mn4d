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
							<table id="table-kesakitan" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										
										<th>ID</th>
										<th>Bulan</th>
										<th>Tahun</th>
										<th>Puskesmas</th>
										<th>Penyakit</th>
										<th>BL </th>
										<th>BP </th>
										<th>LL </th>
										<th>LP </th>
										<th>Jumlah</th>
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
	<div class="modal-dialog"  role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-kesakitan">Tambah Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<p class="mt-3 text-danger" id="global-error"></p>
					<form>
						<input type="hidden" id="id" value="">
						
						<div class="form-group">
							<label for="message-text" class="col-form-label">Bulan:</label>
							<select  id="bulan" class="form-control">
								@foreach ($data['bulan'] as $k => $bulan)
								<option value="{{ $k }}">{{ $bulan }}</option>
								@endforeach
							</select>
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Tahun:</label>
							<input type="text" class="form-control" id="tahun">
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Puskesmas:</label>
							<select  id="puskesmas" class="form-control">
								@foreach ($data['puskesmas'] as $puskesmas)
								<option value="{{ $puskesmas->puskesmas_id }}">{{ $puskesmas->puskesmas_nama }}</option>
								@endforeach
							</select>
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Penyakit:</label>
							<select  id="penyakit" class="form-control">
								@foreach ($data['penyakit'] as $penyakit)
								<option value="{{ $penyakit->penyakit_id }}">{{ $penyakit->penyakit_nama }}</option>
								@endforeach
							</select>
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">BL:</label>
							<input type="text"  id="BL" class="form-control"></input>
							
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">BP:</label>
							<input type="text"  id="BP" class="form-control"></input>
							
							<div class="error"></div>

						</div>

						<div class="form-group">
							<label for="message-text" class="col-form-label">LL:</label>
							<input type="text"  id="LL" class="form-control"></input>
							
							<div class="error"></div>

						</div>

						<div class="form-group">
							<label for="message-text" class="col-form-label">LP:</label>
							<input type="text"  id="LP" class="form-control"></input>
							
							<div class="error"></div>

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
</div>
@endsection
@section('js-export')
@endsection
@section('js-inline')
<script>
	let $tableKesakitan = null;
	let $modalDetail = null;
	let $btnTambah = null;
	let $btnSubmit = null;
	let $bulan = null;
	let $tahun = null;
	let $puskesmas = null;
	let $penyakit = null;
	let $BL = null;
	let $BP = null;
	let $LL = null;
	let $LP = null;
	let $id = null;
	$(function() {
		$modalDetail = $("#modalDetail");
		$btnTambah = $("#btn-tambah");
		$btnSubmit = $("#btn-submit");
		$bulan = $("#bulan");
		$tahun = $("#tahun");
		$puskesmas = $("#puskesmas");
		$penyakit = $("#penyakit");
		$BL = $("#BL");
		$BP = $("#BP");
		$LL = $("#LL");
		$LP = $("#LP");

		$id = $("#id");

		$tableKesakitan = $('#table-kesakitan').DataTable({ 
			"bAutoWidth": false ,
			"processing": true, 
			"serverSide": true, 
			"order": [], 
			"ajax": {
				"url": '<?php echo base_url('data-kesakitan/jsonDataKesakitan'); ?>',
				"type": "POST",
				

			},
			"columns": [
			{"data": "kesakitan_id"},
			{"data": "kesakitan_bulan"},
			{"data": "kesakitan_tahun"},
			{"data": "puskesmas_nama"},
			{"data": "penyakit_nama"},
			{"data": "kesakitan_BL"},
			{"data": "kesakitan_BP"},
			{"data": "kesakitan_LL"},
			{"data": "kesakitan_LP"},
			{"data": "jumlah"},
			{"data": "action"},
			],
			'columnDefs': [
			{
				"targets": 0,
				"orderable" : false,
			},
			{
				"targets": 3,
				"className": "text-center",
				"searchable" : false,
				"orderable" : false,
				"width" : "20%",

			}],
			rowCallback: function(row, data, iDisplayIndex) {

				var index = iDisplayIndex + 1;
				$('td:eq(0)', row).html(index);
			},


		});

		$btnTambah.click(function() {
			clearData();
			clearError();
			$("#modal-title-kesakitan").text("Tambah Data Kesakitan");
			$modalDetail.modal("show");
		})

		$btnSubmit.click(function(e) {
			formData = {
				bulan: $bulan.val(),
				tahun: $tahun.val(),
				puskesmas: $puskesmas.val(),
				penyakit: $penyakit.val(),
				BL: $BL.val(),
				BP: $BP.val(),
				LL: $LL.val(),
				LP: $LP.val(),
				id: $id.val(),
			};
			data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
			var url = "";
			if (formData.id) {
				url = '{{ base_url('data-kesakitan/update') }}';
			} else {
				url = '{{ base_url('data-kesakitan/store') }}'
			}
			axios.post(url, data)
			.then(res => {
				data = res.data;
				clearError();
				if (data.success == 0) {
					if (typeof data.messages === 'object') {
						$.each(data.messages, function(key, value) {

							$('#'+key).addClass('is-invalid');
							$('#'+key).parent('.form-group').find('.error').html(value);

						});
					} else {
						$('#global-error').html(data.messages);
					}
				} else if (data.success == 1){
					$modalDetail.modal('hide');
					$tableKesakitan.ajax.reload();

				}
				
				

			})
			.catch(err => {

			});
		});

	});


	function showModal(id,opsi) {
		if (opsi == 1) {
			showEdit(id);
		} else if(opsi == 2) {
			showDelete(id);
		}
	}

	function showEdit(id) {
		let formData = {
			id: id,
		};
		clearError();
		clearData();
		data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
		axios.post("{{ base_url("data-kesakitan/getDataKesakitan") }}", data)
		.then((res) => {

			data = res.data;
			$bulan.val(data.kesakitan_bulan);
			$tahun.val(data.kesakitan_tahun);
			$puskesmas.val(data.kesakitan_puskesmas_id);
			$penyakit.val(data.kesakitan_penyakit_id);
			$BL.val(data.kesakitan_BL);
			$BP.val(data.kesakitan_BP);
			$LL.val(data.kesakitan_LL);
			$LP.val(data.kesakitan_LP);
			$id.val(data.kesakitan_id);
			$("#modal-title-kesakitan").text("Ubah Data Kesakitan");

			$modalDetail.modal("show");
		})
	}

	function showDelete(id) {
		Swal.fire({
			title: 'Delete Data',
			text: "Yakin akan menghapus data ini ?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Hapus!'
		}).then((result) => {
			if (result.value) {
				let formData = {
					id: id,
				};
				data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
				axios.post("{{ base_url("data-kesakitan/delete") }}", data)
				.then((res) => {
					Swal.fire({
						title: 'Deleted!',
						text: 'Your file has been deleted.',
						icon: 'success',
						timer: 500,
						showConfirmButton: false,

					})
					.then(() => {
						$tableKesakitan.ajax.reload();
					})
				});

				
			}
		});
	}




	function clearData() {
		$bulan.prop('selectedIndex',0);
		$tahun.val('');
		$puskesmas.prop('selectedIndex',0);
		$penyakit.prop('selectedIndex',0);
		$BL.val('');
		$BP.val('');
		$LL.val('');
		$LP.val('');
		$id.val('');		
	}
	function clearError() {
		$('#global-error').html("");
		$(".error").html("");
		$(".is-invalid").removeClass('is-invalid');
	}



</script>
@endsection
