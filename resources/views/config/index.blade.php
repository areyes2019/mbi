@extends('template.app')
@section('content')
<div class="container-fluid">
	<ul class="nav nav-tabs" id="myTab" role="tablist">
  		<li class="nav-item" role="presentation">
    		<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Imagenes de página principal</button>
  		</li>
  		<li class="nav-item" role="presentation">
    		<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Configuracion de precios</button>
  		</li>
  		<li class="nav-item" role="presentation">
    		<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Datos del negocio</button>
  		</li>
	</ul>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  			<div class="img-banner-area">
				<div class="row">
					<div class="col-md-3">
						<img src="{{asset('img/banner_zone01.png')}}" alt="" class="img-fluid">
					</div>
					<div class="col-md-6 hook-area">
						<h4>Hook principal</h4>
						<form method="POST" action="{{route('main_upload')}}" enctype="multipart/form-data">
							{{csrf_field()}}
							<input type="file" class="form-control" name="hook">
							<input type="text" value="1" name="id" class="d-none">
							<input type="submit" class="btn btn-danger mt-1" value="Guardar">
						</form>
						<p>Tamaño adecuado de la imagen 936 x 760 px</p>
					</div>
					<div class="col-md-3">
						@foreach ($query as $main_image )
						<img src="storage/multiporpouse/{{$main_image->img01}}" alt="" class="mt-3" width="150">
						@endforeach
					</div>
				</div>
			</div>
			<div class="img-banner-area">
				<div class="row">
					<div class="col-md-3">
						<img src="{{asset('img/banner_zone02.png')}}" alt="" class="img-fluid">
					</div>
					<div class="col-md-6 hook-area">
						<h4>Hook superior</h4>
						<form method="POST" action="{{route('main_upload')}}" enctype="multipart/form-data">
							{{csrf_field()}}
							<input type="file" class="form-control" name="hook">
							<input type="text" value="2" name="id" class="d-none">
							<input type="submit" class="btn btn-danger mt-1" value="Guardar">
						</form>
						<p>Tamaño adecuado de la imagen 936 x 760 px</p>
					</div>
					<div class="col-md-3">
						@foreach ($query as $superior_image )
						<img src="storage/multiporpouse/{{$superior_image->img02}}" alt="" class="mt-3" width="150">
						@endforeach
					</div>
				</div>
			</div>
			<div class="img-banner-area">
				<div class="row">
					<div class="col-md-3">
						<img src="{{asset('img/banner_zone03.png')}}" alt="" class="img-fluid">
					</div>
					<div class="col-md-6 hook-area">
						<h4>Hook inferior</h4>
						<form method="POST" action="{{route('main_upload')}}" enctype="multipart/form-data">
							{{csrf_field()}}
							<input type="file" class="form-control" name="hook">
							<input type="text" value="3" name="id" class="d-none">
							<input type="submit" class="btn btn-danger mt-1" value="Guardar">
						</form>
						<p>Tamaño adecuado de la imagen 936 x 760 px</p>
					</div>
					<div class="col-md-3">
						@foreach ($query as $inferior_image )
						<img src="storage/multiporpouse/{{$inferior_image->img03}}" alt="" class="mt-3" width="150">
						@endforeach
					</div>
				</div>
			</div>
  		</div>
  	<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  		<div class="row p-5">
			<div class="col-md-5">
				<h4>Ajuste de precios  por catalogo</h4>
				<form action="{{url('')}}" method="POST">
					{{csrf_field()}}
					<label for="">Selecciona el Catalogo</label>
					<select name="cataloge" id="" class="form-control">
						<option value="">Distribuidora Kimu</option>
						<option value="">Pahger</option>
						<option value="">Trosellos México</option>
					</select>
					<label class="mt-1"  for="">Selecciona el aumento</label>
					<input type="number" min="1" name="percent" class="form-control mt-1">
					<input type="submit" value="Guardar" class="btn btn-danger btn-sm mt-2">
				</form>
				<h4 class="mt-3">Ajuste de precios global</h4>
				<form action="{{url('profit_global')}}" method="POST">
					{{csrf_field()}}
					<label for="">Selecciona el aumento global</label>
					<input type="number" min="1" name="increment" class="form-control mt-1">
					<input type="submit" value="Guardar" class="btn btn-danger btn-sm mt-2">
				</form>

				<h4 class="mt-3">Ajustar el margen</h4>
				<form action="{{url('profit')}}" method="POST">
					{{csrf_field()}}
					<label for="">Agregar una cantida en dinero</label>
					<input type="number" min="1" name="profit" class="form-control mt-1">
					<input type="submit" value="Guardar" class="btn btn-danger btn-sm mt-2">
				</form>
			</div>
		</div>
  	</div>
  	<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
	</div>
</div>
@endsection