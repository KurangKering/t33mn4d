@extends('layouts.layout')
@section('css-export')

@endsection
@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Data Puskesmas</h3>
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
							<table id="table-puskesmas" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>
											#
										</th>
										<th>Kecamatan</th>
										<th>Puskesmas</th>
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
				<h5 class="modal-title" id="modal-title-puskesmas">Tambah Pueskesmas</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<form>
						<input type="hidden" id="id" value="">
						
						<div class="form-group">
							<label for="message-text" class="col-form-label">Kecamatan:</label>
							<select  id="kecamatan" class="form-control">
								@foreach ($data['kecamatan'] as $kecamatan)
								<option value="{{ $kecamatan->kecamatan_id }}">{{ $kecamatan->kecamatan_nama }}</option>
								@endforeach
							</select>
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Nama Puskesmas:</label>
							<input type="text"  id="nama" class="form-control"></input>
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
	let $tablePuskesmas = null;
	let $modalDetail = null;
	let $btnTambah = null;
	let $btnSubmit = null;
	let $nama = null;
	let $kecamatan = null;
	let $id = null;
	$(function() {
		$modalDetail = $("#modalDetail");
		$btnTambah = $("#btn-tambah");
		$btnSubmit = $("#btn-submit");
		$nama = $("#nama");
		$kecamatan = $("#kecamatan");
		$id = $("#id");

		$tablePuskesmas = $('#table-puskesmas').DataTable({ 
			"bAutoWidth": false ,
			"processing": true, 
			"serverSide": true, 
			"order": [], 
			"ajax": {
				"url": '<?php echo base_url('data-puskesmas/jsonDataPuskesmas'); ?>',
				"type": "POST",
				

			},
			"columns": [
			{"data": "nomor"},
			{"data": "kecamatan_nama"},
			{"data": "puskesmas_nama"},
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
			$("#modal-title-puskesmas").text("Tambah Puskesmas");
			$modalDetail.modal("show");
		})

		$btnSubmit.click(function(e) {
			formData = {
				nama: $nama.val(),
				kecamatan: $kecamatan.val(),
				id: $id.val(),
			};
			data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
			var url = "";
			if (formData.id) {
				url = '{{ base_url('data-puskesmas/update') }}';
			} else {
				url = '{{ base_url('data-puskesmas/store') }}'
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
					$tablePuskesmas.ajax.reload();

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
		axios.post("{{ base_url("data-puskesmas/getDataPuskesmas") }}", data)
		.then((res) => {

			data = res.data;
			$nama.val(data.puskesmas_nama);
			$kecamatan.val(data.puskesmas_kecamatan_id);
			$id.val(data.puskesmas_id);
			$("#modal-title-puskesmas").text("Ubah Data Puskesmas");

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
				axios.post("{{ base_url("data-puskesmas/delete") }}", data)
				.then((res) => {
					Swal.fire({
						title: 'Deleted!',
						text: 'Your file has been deleted.',
						icon: 'success',
						timer: 500,
						showConfirmButton: false,

					})
					.then(() => {
						$tablePuskesmas.ajax.reload();
					})
				});

				
			}
		});
	}




	function clearData() {
		$id.val("");
		$nama.val("");
		$kecamatan.prop('selectedIndex',0);
		
	}
	function clearError() {
		$(".error").html("");
		$(".is-invalid").removeClass('is-invalid');
	}

</script>
@endsection
