@extends('template.store')
@section('content')
<div class="container mt-5">
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
	    <li class="breadcrumb-item"><a href="{{url('store_categorie/'.$slug)}}">{{$categorie_name}}</a></li>
	    <li class="breadcrumb-item active" aria-current="page">{{$article_name}}</li>
	  </ol>
	</nav>
	@foreach ($article as $item)
	<div class="row">
		<div class="col-md-8 col-12 p-3 article-img">
			<img src="{{asset('storage/cataloge/'.$item->img_url)}}" class="img-fluid" alt="">
		</div>
		<div class="col-md-4 col-12 p-3 article-features">
			<p>{{$item->name}}</p>
			<p>Modelo {{$item->model}}</p>
			<p>${{$item->price}}</p>
			<p>{{$item->short_desc}}</p>
			<img src="{{asset('img/bancos.png')}}" class="img-fluid" alt="">
			<p>Es bueno que sepas</p>
			<p class="feature-icon-list"><span class="bi bi-hand-thumbs-up"></span> Lo fabricamos hasta que tu lo APRUEBAS</p>
			<p class="feature-icon-list"><span class="bi bi-chat-dots"></span> Tus sellos pueden ser en cualquier idioma</p>
			<p class="feature-icon-list"><span class="bi bi-wallet2"></span> Pago 100% seguro</p>
			<p class="feature-icon-list"><span class="bi bi-hand-thumbs-up"></span> Tus sellos se fabrican hasta que tengamos tu aprobación</p>
			<p class="feature-icon-list"><span class="bi bi-cash-coin"></span> Todos nuestros precios incuyen iva</p>
			<p class="ink-color">Puedes escoger el color de tu preferencia</p>
			<img src="{{asset('img/colors.png')}}" class="img-fluid" alt="">
			<button class="btn rounded-0"><span class="bi bi-whatsapp"></span> Me interesa</button>
		</div>
	</div>
	@endforeach
</div>
@endsection