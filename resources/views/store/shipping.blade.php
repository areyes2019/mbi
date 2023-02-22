@extends('template.store')
@section('content')
<div class="container-fluid">
	<div class="compromise">
		<div class="row">
			<div class="col-md-8">
				<div class="quality">
					<p>Nuestros envíos son super seguros</p>
					<p>Tu envío llega por que llega</p>
					<p>Hemos creado a lo argo de 10 años una estrategia segura con los proveedores de paquetería mas confiables de México</p>
					<img class="img-fluid" src="{{asset('img/carrier.png')}}" alt="">

				</div>
			</div>
			<div class="col-md-4">
				<div class="quality-text">
					<span class="bi bi-truck"></span>
					<div class="quality-text-body">
						<p>Envios Gratis</p>
						<p>Tu envío es 100% si tu compra es mayor  a $1200.00</p>
					</div>
				</div>
				<div class="quality-text">
					<span class="bi bi-headset"></span>
					<div class="quality-text-body">
						<p>Seguimiento total</p>
						<p>Estamos siempre contigo para dar seguimiento a tu envío</p>
					</div>
				</div>
				<div class="quality-text">
					<span class="bi bi-globe"></span>
					<div class="quality-text-body">
						<p>Cobertura de envíos</p>
						<p>Llegamos al 95% del terrotiro nacional</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid mt-3">
	<div class="row">
		<div class="col-md-8">
			<img class="img-fluid" src="{{asset('img/packing.jpg')}}" alt="">
		</div>
		<div class="col-md-4">
			<div class="compromise">
				<div class="quality-text">
					<div class="quality-text-body">
						<p>Politicas de envíos</p>
						<p>Los pedidos realizados de lunes a jueves a partir de las 3:00 p.m. se  tramitaran  al día siguiente y los pedidos que entren el viernes después de las  las 2:00 p.m. procesarán el lunes. <br><br>
						Siempre guarda una copia del numero de pedido y la guia para aclaraciones. <br><br>
						El envio gratis para pedidos arriba de los $1,200.00 sera el envio economico Estafeta de 2 a 5 dias. Si deseas aprovechar tu envio gratis y reducir el tiempo del mismo, se calculará la diferencia entre el envío de promoción y el envio 24 horas. <br><br>
						Para asegurarnos de que tu pedido llegue bien confirmaremos que tu direccion es correcta y deberás asegurarte de que haya alguien en el domicilio para recibir.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection