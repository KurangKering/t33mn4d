@extends('layouts.layout')
@section('css-export')

@endsection
@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Data Kecamatan</h3>
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
							<table id="table-kecamatan" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>
											#
										</th>
										<th>Kabupaten</th>
										<th>Kecamatan</th>
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
				<h5 class="modal-title" id="modal-title-kecamatan">Tambah Kecamatan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<form>
						<input type="hidden" id="id" value="">
						
						<div class="form-group">
							<label for="message-text" class="col-form-label">Kabupaten:</label>
							<select  id="kabupaten" class="form-control">
								@foreach ($data['kabupaten'] as $kabupaten)
								<option value="{{ $kabupaten->kabupaten_id }}">{{ $kabupaten->kabupaten_nama }}</option>
								@endforeach
							</select>
							<div class="error"></div>

						</div>
						<div class="form-group">
							<label for="message-text" class="col-form-label">Nama Kecamatan:</label>
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
	let $tableKecamatan = null;
	let $modalDetail = null;
	let $btnTambah = null;
	let $btnSubmit = null;
	let $nama = null;
	let $kabupaten = null;
	let $id = null;
	$(function() {
		$modalDetail = $("#modalDetail");
		$btnTambah = $("#btn-tambah");
		$btnSubmit = $("#btn-submit");
		$nama = $("#nama");
		$kabupaten = $("#kabupaten");
		$id = $("#id");

		$tableKecamatan = $('#table-kecamatan').DataTable({ 
			"bAutoWidth": false ,
			"processing": true, 
			"serverSide": true, 
			"order": [], 
			"ajax": {
				"url": '<?php echo base_url('data-kecamatan/jsonDataKecamatan'); ?>',
				"type": "POST",
				

			},
			"columns": [
			{"data": "nomor"},
			{"data": "kabupaten_nama"},
			{"data": "kecamatan_nama"},
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
			$("#modal-title-kecamatan").text("Tambah Kecamatan");
			$modalDetail.modal("show");
		})

		$btnSubmit.click(function(e) {
			formData = {
				nama: $nama.val(),
				kabupaten: $kabupaten.val(),
				id: $id.val(),
			};
			data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
			var url = "";
			if (formData.id) {
				url = '{{ base_url('data-kecamatan/update') }}';
			} else {
				url = '{{ base_url('data-kecamatan/store') }}'
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
					$tableKecamatan.ajax.reload();

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
		axios.post("{{ base_url("data-kecamatan/getDataKecamatan") }}", data)
		.then((res) => {

			data = res.data;
			$nama.val(data.kecamatan_nama);
			$kabupaten.val(data.kecamatan_kabupaten_id);
			$id.val(data.kecamatan_id);
			$("#modal-title-kecamatan").text("Ubah Data Kecamatan");

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
				axios.post("{{ base_url("data-kecamatan/delete") }}", data)
				.then((res) => {
					Swal.fire({
						title: 'Deleted!',
						text: 'Your file has been deleted.',
						icon: 'success',
						timer: 500,
						showConfirmButton: false,

					})
					.then(() => {
						$tableKecamatan.ajax.reload();
					})
				});

				
			}
		});
	}




	function clearData() {
		$id.val("");
		$nama.val("");
		$kabupaten.prop('selectedIndex',0);
		
	}
	function clearError() {
		$(".error").html("");
		$(".is-invalid").removeClass('is-invalid');
	}

</script>
@endsection
