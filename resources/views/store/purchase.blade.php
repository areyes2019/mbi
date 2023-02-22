@extends('template.store')
@section('content')
<div class="container-fluid">
	<div class="compromise">
		<div class="row">
			<div class="col-md-8">
				<div class="quality">
					<p>Tu Compra 100% segura y tu satisfaccion garantizada</p>
					<p>Nunca fabricamos nada que no tenga tu visto bueno</p>
					<p>Siempre, siempre, siempre enviaremos un diseño previo para tu aprobación. Recuerda que el tiempo empieza a correr a partir de que tú nos digas <strong>¡Aprobado!</strong></p>

				</div>
			</div>
			<div class="col-md-4">
				<div class="quality-text">
					<span class="bi bi-credit-card"></span>
					<div class="quality-text-body">
						<p>Paga por trasferencia</p>
						<p>Sistema SPEI</p>
					</div>
				</div>
				<div class="quality-text">
					<span class="bi bi-shop"></span>
					<div class="quality-text-body">
						<p>Tiendas de Conveniencia</p>
						<p>Puedes pagar en las miles de tiendas OXXO en todo el país</p>
					</div>
				</div>
				<div class="quality-text">
					<span class="bi bi-arrow-return-left"></span>
					<div class="quality-text-body">
						<p>Garantía de Devolución</p>
						<p>Tu dinero siempre está seguro</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<img class="img-fluid" src="{{asset('img/order.png')}}" alt="">
		</div>
		<div class="col-md-4">
			<div class="compromise">
				<div class="quality-text">
					<span class="bi bi-hand-index"></span>
					<div class="quality-text-body">
						<p>Escoge el sello que se ajusta a tu necesidad</p>
						<p>Si tienes un dibujo o boceto a la mano, nos lo envias. Esto nos serviría mucho para ayudarte a elegir un tamaño</p>
					</div>
				</div>
				<div class="quality-text">
					<span class="bi bi-file-earmark-text"></span>
					<div class="quality-text-body">
						<p>Te enviamos una cotizacion por escrito</p>
						<p>Una vez que decidiste cual es el tamaño que necesitas te enviamos una cotización por escrito. Sin numero confusos ni letras chiquitas.</p>
					</div>
				</div>
				<div class="quality-text">
					<span class="bi bi-credit-card"></span>
					<div class="quality-text-body">
						<p>Pagas por el método de tu preferencia </p>
						<p>En la cotizacion veras los metodos de pago. Una vez que hagas el pago nos envias el ticket al correo ventas@sellopronto.com.mx</p>
					</div>
				</div>
				<div class="quality-text">
					<span class="bi bi-pencil"></span>
					<div class="quality-text-body">
						<p>Listo!! Arrancamos con el diseño</p>
						<p>Lo demás corre por nuestra cuenta. Una vez confirmado el pago nos pondremos a trabajar de inmediato en tu diseño. Tienes hasta tres oportunidades de cambiarlo.</p>
					</div>
				</div>
				<div class="quality-text">
					<div class="quality-text-body">
						<p>Listo eso es todo, lo demas corre por nuestra cuenta</p>
						<p></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection