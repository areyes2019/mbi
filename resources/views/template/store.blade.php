<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Sello Pronto" />
	<meta property="og:description" content="Todo tipo de sellos de goma. Envio a todo México" />
	<meta property="og:image" content="{{asset('img/logo2.png')}}" />
	<meta property="og:image:width" content="828" />
	<meta property="og:image:height" content="450" />
	<title>Sello Pronto</title>
	<link rel="stylesheet" href="{{asset('css/app.css')}}">	
	<link rel="stylesheet" href="{{asset('css/store.css')}}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">	
</head>
<body>
	<div class="top-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-8 top-links">
					<div class="header-group">
						<p><span class="bi bi-send"></span>ventas@sellopronto.com.mx</p>
	   				</div>
					<div class="header-group">		
						<p><span class="bi bi-whatsapp"></span> 461 358 1090</p>
					</div>	
				</div>
				<div class="col-12 col-md-4">
					<img src="{{asset('img/bancos.png')}}" class="img-fluid" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="main-header">
		<div class="container-fluid">
			<div class="row p-0 header-container">
				<div class="col-md-4 col-12 header-logo">
					<a href="/"><img src="{{asset('img/logoweb.png')}}" class="img-fluid" alt=""></a>
				</div>
				<div class="col-md-4 offset-4 col-12 header-support">
					<div class="header-support-group">
						<div class="support-icon">
							<span class="bi bi-headset"></span>
						</div>
						<div class="support-text">
							<p>Soporte</p>
							<p>461 358 1090</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>											
	<div class="mobile-menu">
		<div class="mobile-menu-link">
			<a href="#mobile-menu" data-bs-toggle="collapse"><span class="bi bi-list"></span></a>
		</div>
		<div class="mobile-menu-body collapse" id="mobile-menu">
			<ul>
				<li><a href="{{url('shipping')}}">Politicas de envios</a></li>
				<li><a href="">Nosotros</a></li>
				<li><a href="{{url('purchase')}}">Metodo de compra</a></li>
				<li><a href="">Contacto</a></li>
			</ul>
		</div>
	</div>
	<div class="normal-menu">
		<div class="container-fluid">
			<div class="normal-menu-list">
				<ul>
					<li><a href="{{url('shipping')}}">Politicas de envios</a></li>
					<li><a href="">Nosotros</a></li>
					<li><a href="{{url('purchase')}}">Metodo de compra</a></li>
					<li><a href="">Contacto</a></li>
				</ul>
				<a href=""><span class="bi bi-bag"></span> Cotizador</a>
			</div>
		</div>
	</div>
	@yield('content')
	<div id="footer">
		<div class="row">
			<div class="col-12 col-md-4">
				<h4>Categorias</h4>
				<ul>
					<li><a href="">Contacto</a></li>
					<li><a href="">Nosotros</a></li>
					<li><a href="">Contacto</a></li>
					<li><a href="">Contacto</a></li>
				</ul>
			</div>
			<div class="col-12 col-md-4">
				<h4>Acerca de nosotros</h4>
				<ul>
					<li><a href="">Nosotros</a></li>
					<li><a href="">Garantía de calidad</a></li>
					<li><a href="">Envíos</a></li>
					<li><a href="">Metodo de compra</a></li>
				</ul>
			</div>
			<div class="col-12 col-md-4">
				<img src="img/promesa.png" class="img-fluid" alt="">
				<p class="mt-4"><center>Siguenos en nuestras redes</center></p>
			</div>
		</div>
	</div>
	<script src="{{asset('js/app.js')}}"></script>
</body>
</html>