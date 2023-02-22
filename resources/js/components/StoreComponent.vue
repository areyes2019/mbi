<template>
<div class="main">
	<div class="store-menu">
		<div class="vertical-menu">
			<p>categorías</p>
			<div class="vertical-menu-body">
				<ul>
					<li>
						<a href="#" @click.prevent="menu=!menu, display_menu()">
						<span class="bi bi-shop"></span>
						Sellos fechadores
						</a>
						<div :class="['row','m-0','side-menu-list',display]">
							<h5>Sellos Fechadores</h5>
							<div class="col-md-5">
								<ul>
									<li><a href="">Tipo boligrafo</a></li>
									<li><a href="">Mouse stamp</a></li>
									<li><a href="">Plumas con sello</a></li>
								</ul>
							</div>
							<div class="col-md-7">
								<img class="img-fluid" src="img/colop.png" alt="">
							</div>
						</div>
					</li>
					<li>
							<a href="">
									<span class="bi bi-shop"></span>
									Sellos personalizados
							</a>
					</li>
					<li>
							<a href="">
									<span class="bi bi-shop"></span>
									Sellos para doctores
							</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="side-menu">
			<div class="row m-0 search">
				<div class="col-md-12">
					<div class="search-field">
						<span class="bi bi-search"></span>
						<input type="text" class="input-field">
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="slider">
        <div class="slider-content">
            <p>Estamos más <br> que <span>listos</span></p>
            <p>Envíos a todo México</p>
            <img src="img/grupo.png" alt="">
            <div class="slider-img">
                <img src="img/order.png" alt="">
            </div>
        </div>
	</div>
    <div class="container-fluid my-contanier">
        <div class="row m-0 p-0">
            <div class="col-md-4">
                <div class="features">
                    <div class="features-icon">
                        <span class="bi bi-truck"></span>
                    </div>
                    <div class="features-text">
                        <p>Envio el mismo dia</p>
                        <p>Si tu pedido entra antes de las 2:00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="features">
                    <div class="features-icon">
                        <span class="bi bi-hearts"></span>
                    </div>
                    <div class="features-text">
                        <p>Calidad garantizada</p>
                        <p>100% de a tu gusto</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            	<div class="features">
                    <div class="features-icon">
                        <span class="bi bi-wallet2"></span>
                    </div>
                    <div class="features-text">
                        <p>Multi Pagos</p>
                        <p>Tu pago es 100% seguro</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
    	<div class="row">
    		<div class="col-md-3 my-trends">
    			<h6 class="trends-title">Los mas buscados</h6>
    			<div class="trends">
    				<div class="trends-img">
    					<img src="img/front01.png" alt="" class="img-fluid">
    				</div>
    				<div class="trends-data">
    					<p>Colop C40</p>
    					<p>Sello de 47 x 18 mm</p>
    					<p>$250.00</p>
    				</div>
    			</div>
    			<div class="trends">
    				<div class="trends-img">
    					<img src="img/front01.png" alt="" class="img-fluid">
    				</div>
    				<div class="trends-data">
    					<p>Colop C40</p>
    					<p>Sello de 47 x 18 mm</p>
    					<p>$250.00</p>
    				</div>
    			</div>
    			<div class="trends">
    				<div class="trends-img">
    					<img src="img/front01.png" alt="" class="img-fluid">
    				</div>
    				<div class="trends-data">
    					<p>Colop C40</p>
    					<p>Sello de 47 x 18 mm</p>
    					<p>$250.00</p>
    				</div>
    			</div>
    			<div class="trends">
    				<div class="trends-img">
    					<img src="img/front01.png" alt="" class="img-fluid">
    				</div>
    				<div class="trends-data">
    					<p>Colop C40</p>
    					<p>Sello de 47 x 18 mm</p>
    					<p>$250.00</p>
    				</div>
    			</div>
    		</div>
    		<div class="col-md-9">
    			<div class="popular">
    				<h6 class="popular-title">Catagorías Destacadas</h6>
    				<div class="row popular-body">
    					<div class="col-md-4">
    						<div class="popular-categorie">
    							<img src="img/colop.png" class="img-fluid" alt="">
    							<p>Sellos para Maestros</p>
    							<p>Lorem ipsum dolor sit, amet, consectetur adipisicing elit. Ducimus voluptates illum laboriosam earum a, cupiditate quos omnis minima unde est adipisci culpa nesciunt consectetur voluptatem expedita magnam ratione consequatur repellat.</p>
    							<a href="/shop">Me interesa <span class="bi bi-arrow-right-short"></span></a>
    						</div>
    					</div>
    					<div class="col-md-4">
    						<div class="popular-categorie">
    							<img src="img/colop.png" class="img-fluid" alt="">
    							<p>Sellos para Maestros</p>
    							<p>Lorem ipsum dolor sit, amet, consectetur adipisicing elit. Ducimus voluptates illum laboriosam earum a, cupiditate quos omnis minima unde est adipisci culpa nesciunt consectetur voluptatem expedita magnam ratione consequatur repellat.</p>
    							<a href="">Me interesa <span class="bi bi-arrow-right-short"></span></a>
    						</div>
    					</div>
    					<div class="col-md-4">
    						<div class="popular-categorie">
    							<img src="img/colop.png" class="img-fluid" alt="">
    							<p>Sellos para Maestros</p>
    							<p>Lorem ipsum dolor sit, amet, consectetur adipisicing elit. Ducimus voluptates illum laboriosam earum a, cupiditate quos omnis minima unde est adipisci culpa nesciunt consectetur voluptatem expedita magnam ratione consequatur repellat.</p>
    							<a href="">Me interesa <span class="bi bi-arrow-right-short"></span></a>
    						</div>
    					</div>
    				</div>
    			</div>
    			<div class="popular">
    				<h6 class="popular-title">Top ventas</h6>
    				<div class="row popular-body mt-5">
    					<div class="col-md-3">
    						<div class="popular-item">
    							<img src="img/colop.png" class="img-fluid" alt="">
    							<a href="">Sello de 38 x 14 mm</a>
    							<p>Colop C20</p>
    							<p>$250.00</p>
    							<div class="add-to">
    								<a href=""><span class="bi bi-basket"></span>Enviar a cotizar</a>
    								<a href=""><span class="bi bi-eyeglasses"></span></a>
    							</div>
    						</div>
    					</div>
    					<div class="col-md-3">
    						<div class="popular-item">
    							<img src="img/colop.png" class="img-fluid" alt="">
    							<a href="">Sello de 38 x 14 mm</a>
    							<p>Colop C20</p>
    							<p>$250.00</p>
    							<div class="add-to">
    								<a href=""><span class="bi bi-basket"></span>Enviar a cotizar</a>
    								<a href=""><span class="bi bi-eyeglasses"></span></a>
    							</div>
    						</div>
    					</div>
    					<div class="col-md-3">
    						<div class="popular-item">
    							<img src="img/colop.png" class="img-fluid" alt="">
    							<a href="">Sello de 38 x 14 mm</a>
    							<p>Colop C20</p>
    							<p>$250.00</p>
    							<div class="add-to">
    								<a href=""><span class="bi bi-basket"></span>Enviar a cotizar</a>
    								<a href=""><span class="bi bi-eyeglasses"></span></a>
    							</div>
    						</div>
    					</div>
    					<div class="col-md-3">
    						<div class="popular-item">
    							<img src="img/colop.png" class="img-fluid" alt="">
    							<a href="">Sello de 38 x 14 mm</a>
    							<p>Colop C20</p>
    							<p>$250.00</p>
    							<div class="add-to">
    								<a href=""><span class="bi bi-basket"></span>Enviar a cotizar</a>
    								<a href=""><span class="bi bi-eyeglasses"></span></a>
    							</div>
    						</div>
    					</div>

    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
</template>
<script>
	export default{
		data(){
			return{
				menu:false,
				display:"hide",
			}
		},
		methods:{
			display_menu(){
				if (this.menu==true) {
					this.display = 'show';
				}else{
					this.display = 'hide';
				}
			}
		},
		mounted(){
			console.log('hola')
		}
	}
</script>
