@extends('layouts.layout')
@section('css-export')

@endsection
@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Data ICD 10</h3>
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
							<table id="table-penyakit" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>
											Kode
										</th>
										<th>Jenis Penyakit</th>
										<th>Kelompok Utama Penyakit</th>
										<th>Golongan Sebab Sakit</th>
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
				<h5 class="modal-title" id="modal-title-penyakit">Tambah Penyakit</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<form>
						<input type="hidden" id="id" value="">
						<div class="form-group">
							<label for="kode" class="col-form-label">Kode</label>
							<input type="text" class="form-control" id="kode">
							<div class="error"></div>
						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Kelompok Utama Penyakit</label>
							<select  id="kelompok" class="form-control">
								@foreach ($data['kelompok'] as $kelompok)
								<option value="{{ $kelompok->kelompok_penyakit_id }}">{{ $kelompok->kelompok_penyakit_nama }}</option>
								@endforeach
							</select>
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Golongan Sebab Sakit</label>
							<input type="text"  id="nama" class="form-control"></input>
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Menular/Tidak</label>
							<select  id="menular" class="form-control">
								<option value="1">Tidak</option>
								<option value="2">Menular</option>
							</select>
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
	let $tablePenyakit = null;
	let $modalDetail = null;
	let $btnTambah = null;
	let $btnSubmit = null;
	let $kode = null;
	let $kelompok = null;
	let $nama = null;
	let $menular = null;
	let $id = null;
	$(function() {
		$modalDetail = $("#modalDetail");
		$btnTambah = $("#btn-tambah");
		$btnSubmit = $("#btn-submit");
		$kode = $("#kode");
		$kelompok = $("#kelompok");
		$nama = $("#nama");
		$menular = $("#menular");
		$id = $("#id");

		
		$tablePenyakit = $('#table-penyakit').DataTable({ 
			"bAutoWidth": false ,
			"processing": true, 
			"serverSide": true, 
			"order": [], 
			"ajax": {
				"url": '<?php echo base_url('data-penyakit/jsonDataPenyakit'); ?>',
				"type": "POST",


			},
			"columns": [
			{"data": "penyakit_kode"},
			{"data": "penyakit_status"},
			{"data": "kelompok_penyakit_nama"},
			{"data": "penyakit_nama"},
			{"data": "action"},
			],
			'columnDefs': [
			
			{
				"targets": 3,
				"className": "text-center",
				"searchable" : false,
				"orderable" : false,
				"width" : "20%",

			}],
			


		});
		$btnTambah.click(function() {
			clearData();
			clearError();
			$("#modal-title-penyakit").text("Tambah Penyakit");
			$modalDetail.modal("show");
		})

		$btnSubmit.click(function(e) {
			formData = {
				kode: $kode.val(),
				kelompok: $kelompok.val(),
				nama: $nama.val(),
				menular: $menular.val(),
				id: $id.val(),
			};
			data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
			var url = "";
			if (formData.id) {
				url = '{{ base_url('data-penyakit/update') }}';
			} else {
				url = '{{ base_url('data-penyakit/store') }}'
			}
			axios.post(url, data)
			.then(res => {
				data = res.data;
				clearError();
				console.log(data);
				if (data.success == 0) {
					$.each(data.messages, function(key, value) {

						$('#'+key).addClass('is-invalid');
						$('#'+key).parent('.form-group').find('.error').html(value);
					});
				} else if (data.success == 1){
					$modalDetail.modal('hide');
					$tablePenyakit.ajax.reload();

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
		axios.post("{{ base_url("data-penyakit/getDataPenyakit") }}", data)
		.then((res) => {

			data = res.data;
			$kode.val(data.penyakit_kode);
			$kelompok.val(data.penyakit_kelompok_penyakit_id);
			$nama.val(data.penyakit_nama);
			$menular.val(data.penyakit_status);
			$id.val(data.penyakit_id);
			$("#modal-title-penyakit").text("Ubah Data Penyakit");

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
				axios.post("{{ base_url("data-penyakit/delete") }}", data)
				.then((res) => {
					Swal.fire({
						title: 'Deleted!',
						text: 'Your file has been deleted.',
						icon: 'success',
						timer: 500,
						showConfirmButton: false,

					})
					.then(() => {
						$tablePenyakit.ajax.reload();
					})
				});

				
			}
		});
	}




	function clearData() {
		$id.val("");
		$kode.val("");
		$kelompok.prop('selectedIndex',0);
		$nama.val("");
		$menular.prop('selectedIndex',0);
		
	}
	function clearError() {
		$(".error").html("");
		$(".is-invalid").removeClass('is-invalid');
	}

</script>
@endsection
