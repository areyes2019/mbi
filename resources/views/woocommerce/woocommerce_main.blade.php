@extends('template.app')
@section('content')
<div class="container">
	<div class="card-box-std p-3">
		@foreach ($query as $data)
			<h4>{{$data->name}}</h4>
        @endforeach
	</div>
	<div class="row mt-3">
		<div class="col-md-4">
			<div class="card-box">
                <p class="m-0 text-center"><span class="ti-package"></span></p>
                <p class="m-0 text-center"><a href="/woo_articles/{{$data->idStore}}">Artículos</a></p>
                <p class="m-0 text-center">250</p>
            </div>
		</div>
	</div>
</div>
@endsection