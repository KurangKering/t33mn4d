@extends('layouts.layout')
@section('css-export')

@endsection
@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Data Pasien</h3>
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
										<th>
											 ID
										</th>
										<th>Nama</th>
										<th>Jenis Kelamin</th>
										<th>Nama KK</th>
										<th>Alamat</th>
										<th>Puskesmas</th>
										<th>TTL</th>
										<th>Usia</th>
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
				<h5 class="modal-title" id="modal-title-pasien">Tambah Pueskesmas</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<form>
						<input type="hidden" id="id" value="">
						
						<div class="form-group">
							<label for="message-text" class="col-form-label">Puskesmas:</label>
							<select id="puskesmas" class="form-control">
								@foreach ($data['puskesmas'] as $puskesmas)
								<option value="{{ $puskesmas->puskesmas_id }}">{{ $puskesmas->puskesmas_nama }}</option>
								@endforeach
							</select>
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Nama Pasien:</label>
							<input type="text"  id="nama" class="form-control"></input>
							<div class="error"></div>

						</div>


						<div class="form-group">
							<label for="message-text" class="col-form-label">Jenis Kelamin:</label>
							<select  id="jk" class="form-control">
								@foreach (hJK() as $k => $jk)
								<option value="{{ $k }}">{{ $jk }}</option>
								@endforeach
							</select>
							<div class="error"></div>

						</div>

						<div class="form-group">
							<label for="message-text" class="col-form-label">Nama KK:</label>
							<input type="text"  id="nama_kk" class="form-control"></input>
							<div class="error"></div>

						</div>

						<div class="form-group">
							<label for="message-text" class="col-form-label">Alamat:</label>
							<textarea  id="alamat" class="form-control"></textarea>
							<div class="error"></div>

						</div>

						<div class="form-group">
							<label for="message-text" class="col-form-label">Tanggal Lahir:</label>
							<input type="date"  id="tanggal_lahir" class="form-control"></input>
							<div class="error"></div>

						</div>

						<div class="form-group">
							<label for="message-text" class="col-form-label">Tempat Lahir:</label>
							<input type="text"  id="tempat_lahir" class="form-control"></input>
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
	let $tablePasien = null;
	let $modalDetail = null;
	let $btnTambah = null;
	let $btnSubmit = null;
	let $nama = null;
	let $jk = null;
	let $nama_kk = null;
	let $alamat = null;
	let $puskesmas = null;
	let $tanggal_lahir = null;
	let $tempat_lahir = null;
	let $id = null;
	$(function() {
		$modalDetail = $("#modalDetail");
		$btnTambah = $("#btn-tambah");
		$btnSubmit = $("#btn-submit");
		$nama = $("#nama");
		$jk = $("#jk");
		$nama_kk = $("#nama_kk");
		$alamat = $("#alamat");
		$puskesmas = $("#puskesmas");
		$tanggal_lahir = $("#tanggal_lahir");
		$tempat_lahir = $("#tempat_lahir");
		$id = $("#id");

		$tablePasien = $('#table-pasien').DataTable({ 
			"bAutoWidth": false ,
			"processing": true, 
			"serverSide": true, 
			"order": [], 
			"ajax": {
				"url": '<?php echo base_url('data-pasien/jsonDataPasien'); ?>',
				"type": "POST",


			},
			"columns": [
			{"data": "pasien_id"},
			{"data": "pasien_nama"},
			{"data": "jk"},
			{"data": "pasien_nama_kk"},
			{"data": "pasien_alamat"},
			{"data": "puskesmas_nama"},
			{"data": "ttl"},
			{"data": "usia"},
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
			$("#modal-title-pasien").text("Tambah Pasien");
			$modalDetail.modal("show");
		})

		$btnSubmit.click(function(e) {
			formData = {
				nama: $nama.val(),
				jk: $jk.val(),
				nama_kk: $nama_kk.val(),
				alamat: $alamat.val(),
				puskesmas: $puskesmas.val(),
				tanggal_lahir: $tanggal_lahir.val(),
				tempat_lahir: $tempat_lahir.val(),
				id: $id.val(),
			};
			data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
			var url = "";
			if (formData.id) {
				url = '{{ base_url('data-pasien/update') }}';
			} else {
				url = '{{ base_url('data-pasien/store') }}'
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
					$tablePasien.ajax.reload();

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
		axios.post("{{ base_url("data-pasien/getDataPasien") }}", data)
		.then((res) => {

			data = res.data;
			$nama.val(data.pasien_nama);
			$jk.val(data.pasien_jk);
			$nama_kk.val(data.pasien_nama_kk);
			$alamat.val(data.pasien_alamat);
			$puskesmas.val(data.pasien_puskesmas_id);
			$tanggal_lahir.val(data.pasien_tanggal_lahir);
			$tempat_lahir.val(data.pasien_tempat_lahir);
			$id.val(data.pasien_id);
			$("#modal-title-pasien").text("Ubah Data Pasien");

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
				axios.post("{{ base_url("data-pasien/delete") }}", data)
				.then((res) => {
					Swal.fire({
						title: 'Deleted!',
						text: 'Your file has been deleted.',
						icon: 'success',
						timer: 500,
						showConfirmButton: false,

					})
					.then(() => {
						$tablePasien.ajax.reload();
					})
				});

				
			}
		});
	}




	function clearData() {
		$id.val("");
		$nama.val("");
		$jk.val("");
		$nama_kk.val("");
		$alamat.val("");
		$tanggal_lahir.val("");
		$tempat_lahir.val("");
		$jk.prop('selectedIndex',0);
		$puskesmas.prop('selectedIndex',0);
		
	}
	function clearError() {
		$(".error").html("");
		$(".is-invalid").removeClass('is-invalid');
	}

</script>
@endsection
