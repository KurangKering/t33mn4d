@section('css-inline')
<style>
	#logo-web {
		float: left;
	}

	#logo-web > img {
		width: 100px;
	}
	#judul-sistem {
		float: left;
		margin-left: 20px;

	}
	#judul-sistem > h1 {
		line-height: 300%;
		margin: 0;
		font-weight: 600;
		color: #9900ff;
	}

	@media (max-width:1262px) {
		#logo-web {
			float: none;
			text-align: center;
		}

		#logo-web > img {
			width: 100px;
		}
		#judul-sistem {
			float: none;
			text-align: center;

		}
		#judul-sistem > h1 {
			margin: 0;
			line-height: 100%;
			font-weight: 600;
			color: #9900ff;
		}
	}

</style>
@endsection
@extends('layouts.layout')
@section('content')


<div class="row" >
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_content">

				<div id="logo-web">
					<img  src="{{ base_url('assets/images/kampar.png') }}" alt="">	
				</div>
				
				<div id="judul-sistem">
					<h1>SISTEM KESAKITAN KABUPATEN KAMPAR</h1>
				</div>

				
			</div>
		</div>
	</div>
	
	
</div>
<div class="row">
	
	<div class="col-md-12 col-sm-12 ">
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
					<div class="x_content">
						<div class="dashboard-widget-content">
							<img width="100%" src="{{ base_url('assets/images/dinkes-kampar_Farmakmin.jpg') }}" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
