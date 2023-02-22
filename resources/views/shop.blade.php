@extends('template.store')
<?php use App\Models\cnnxn_categorie ?>
@section('content')
<div class="container-fluid categories">
		<div class="row">
			<div class="col-12 col-md-3">
				<div class="categories-menu">
					<span class="bi bi-list"></span>
					<p>nuestros sellos</p>
				</div>
				<ul class="categories-list p-2">
					@foreach ($parent as $parents)
					<li><a href="#{{$parents->slug}}" class="d-flex justify-content-between" data-bs-toggle="collapse">{{$parents->name}}<span class="bi bi-plus-circle-dotted"></span></a>
						<ul class="p-0 m-0 collapse" id="{{$parents->slug}}">
							<?php $query = cnnxn_categorie::where('main',$parents->idCategorie)->get()?>
							@foreach ($query as $child)
							<li class="m-0"><a href="/store_categorie/{{$child->slug}}">{{$child->name}}</a></li>
							@endforeach
						</ul>
					</li>
					@endforeach
					
					@foreach ($single as $singles)
					<li><a href="/store_categorie/{{$singles->slug}}">{{$singles->name}}</a></li>
					@endforeach
					
				</ul>
			</div>
			<div class="col-12 col-md-9">
				<img src="img/banner.png" class="img-fluid" alt="">
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="compromise">
			<div class="row">
				<div class="col-md-8">
					<div class="quality">
						<p>Cuando hablamos de calidad</p>
						<p>Hablamos en serio</p>
						<p>La experiencia de mas de 10 años vendiendo en linea y en el negocio de los sellos de goma, nos repaldan. Nuestro compromiso es que tu producto llegue a tus manos como si lo huberas pedido en persona</p>
						<a href="/expert" class="btn btn-danger btn-lg">Saber mas</a>
					</div>
				</div>
				<div class="col-md-4">
					<div class="quality-text">
						<span class="bi bi-truck"></span>
						<div class="quality-text-body">
							<p>Envios Gratis</p>
							<p>En compras mallores a $1200.00</p>
						</div>
					</div>
					<div class="quality-text">
						<span class="bi bi-pencil"></span>
						<div class="quality-text-body">
							<p>Garantía de diseño</p>
							<p>Siempre enviamos un diseño previo para tu aprobación</p>
						</div>
					</div>
					<div class="quality-text">
						<span class="bi bi-box"></span>
						<div class="quality-text-body">
							<p>Garantía de calidad</p>
							<p>Si el producto no cumple con la función, te devolvemos tu dinero</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="block">
			<div class="row">
				<div class="col-md-5">
					<img src="img/grupo.png" class="img-fluid" alt="">
				</div>
				<div class="col-md-7 we-are">
					<p>Nuestros sellos</p>
					<p>Somo distrubuidores de la linea Colop, con sede en Wels / Austria, y sucursales y participaciones en todo el mundo. Colop es uno de los principales fabricantes internacionales de sellos y modernos dispositivos de marcaje. Todos nuestros productos cuentan con garantía contra defectos de fábrica y los encontrarás a precios competitivos. Contamos tambien con un amplio catálogo de sellos de madera, el tradicional. El personal de Sello Pronto  te ayudará a adquirir los artículos correctos.</p>
					<p>Nuestros servicio </p>
					<p>Tanto si eres una empresa, como si eres un particular, nuestro compromiso es brindarte una atención profesional. Nuestro Catalaogo esta diseñado de manera intutiva para que juntos logremos encontrar lo que necesitas</p>
					<button class="btn btn-danger btn-lg">Quiero cotizar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid mt-4">
		<div class="top-ten">
			<div class="top-ten-title">
				<p>Te recomendamos</p>
				<p>nuestro top 10</p>
			</div>
			<div class="row">
				<div class="col-md-3 p-2">
					<div class="top-ten-item">
						<img src="img/front01.png" class="img-fluid" alt="">
						<p>Colop C40</p>
						<p>Sello de 59 x 23 mm</p>
						<p>$250.00</p>
					</div>
				</div>
				<div class="col-md-3 p-2">
					<div class="top-ten-item">
						<img src="img/front01.png" class="img-fluid" alt="">
						<p>Colop C60</p>
						<p>Sello de 59 x 23 mm</p>
						<p>$250.00</p>
					</div>
				</div>
				<div class="col-md-3 p-2">
					<div class="top-ten-item">
						<img src="img/front01.png" class="img-fluid" alt="">
						<p>Colop C35</p>
						<p>Sello de 59 x 23 mm</p>
						<p>$250.00</p>
					</div>
				</div>
				<div class="col-md-3 p-2">
					<div class="top-ten-item">
						<img src="img/front01.png" class="img-fluid" alt="">
						<p>Colop C40</p>
						<p>Sello de 59 x 23 mm</p>
						<p>$250.00</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- harea de hooks-->
	<div class="container-fluid">
		<div class="banner-container">
			@foreach ($hooks as $img )
			<div class="img-banner">
				<img src="storage/multiporpouse/{{$img->img01}}" class="img-fluid" alt="">
				<button class="btn my-btn-red">Me intresa</button>
			</div>
			<div class="img-banner-side">
				<div class="banner01">
					<img src="storage/multiporpouse/{{$img->img02}}" class="img-fluid" alt="">
					<button class="btn my-btn-red">Me intresa</button>
				</div>
				<div class="banner02">
					<img src="storage/multiporpouse/{{$img->img03}}" class="img-fluid" alt="">
					<button class="btn my-btn-red">Me intresa</button>
				</div>
			</div>
			@endforeach
		</div>
	</div>			
	<!-- harea de hooks-->

	<!-- categorias destacadas -->
	<div class="container-fluid mt-4">
		<div class="top-ten">
			<div class="top-ten-title">
				<p>Categorías</p>
				<p>destacadas</p>
			</div>
			<div class="row">
				<div class="col-md-3 p-2 col-12">
					<div class="card">
					  <img src="img/banner-side01.jpg" class="card-img-top" alt="...">
					  <div class="card-body">
					    <h5 class="card-title">Para Maesros</h5>
					    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
					    <a href="#" class="btn my-btn-red">Me interesa</a>
					  </div>
					</div>
				</div>
				<div class="col-md-3 p-2 col-12">
					<div class="card">
					  <img src="img/banner-side01.jpg" class="card-img-top" alt="...">
					  <div class="card-body">
					    <h5 class="card-title">Para Doctores</h5>
					    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
					    <a href="#" class="btn my-btn-red">Me interesa</a>
					  </div>
					</div>
				</div>
				<div class="col-md-3 p-2 col-12">
					<div class="card">
					  <img src="img/banner-side01.jpg" class="card-img-top" alt="...">
					  <div class="card-body">
					    <h5 class="card-title">Para Maesros</h5>
					    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
					    <a href="#" class="btn my-btn-red">Me interesa</a>
					  </div>
					</div>
				</div>
				<div class="col-md-3 p-2 col-12">
					<div class="card">
					  <img src="img/banner-side01.jpg" class="card-img-top" alt="...">
					  <div class="card-body">
					    <h5 class="card-title">Para Maesros</h5>
					    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
					    <a href="#" class="btn my-btn-red">Me interesa</a>
					  </div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<!-- prin big-->
	<div class="container-fluid mt-4">
		<div class="row">
			<div class="col-md-7 big-img">
				<img src="img/big_rubber.png" class="img-fluid" alt="">
			</div>
			<div class="col-md-5">
				<div class="big-title">
					<p>Queremos que...</p>
					<p>pienses en grande</p>
					<p>Los sellos de GRAN TAMAÑO tienen múltiples aplicaciones, playeres, bolsas, cajas de pizza y más. Las más comunes son para marcar bolsas de tela (aunque también se podrían marcar bolsas de plástico con una tinta especial de secado rápido) y para marcar cajas de diferentes tipos y tamaños.</p>
					<img src="img/big.png">
					<a href="" class="btn my-btn-red mt-4">Me interesa</a>
				</div>
			</div>
		</div>
	</div>
	<!-- populares-->
	<div class="container-fluid mt-4">
		<div class="top-ten">
			<div class="top-ten-title">
				<p>Nuestros sellos</p>
				<p>mas populares</p>
			</div>
			<div class="row">
				<div class="col-md-3 p-2">
					<div class="top-ten-item">
						<img src="img/front01.png" class="img-fluid" alt="">
						<p>Colop C40</p>
						<p>Sello de 59 x 23 mm</p>
						<p>$250.00</p>
					</div>
				</div>
				<div class="col-md-3 p-2">
					<div class="top-ten-item">
						<img src="img/front01.png" class="img-fluid" alt="">
						<p>Colop C60</p>
						<p>Sello de 59 x 23 mm</p>
						<p>$250.00</p>
					</div>
				</div>
				<div class="col-md-3 p-2">
					<div class="top-ten-item">
						<img src="img/front01.png" class="img-fluid" alt="">
						<p>Colop C35</p>
						<p>Sello de 59 x 23 mm</p>
						<p>$250.00</p>
					</div>
				</div>
				<div class="col-md-3 p-2">
					<div class="top-ten-item">
						<img src="img/front01.png" class="img-fluid" alt="">
						<p>Colop C40</p>
						<p>Sello de 59 x 23 mm</p>
						<p>$250.00</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
