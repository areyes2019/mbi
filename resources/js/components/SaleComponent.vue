<template>
	<div class="container-fluid">
		<div class="card rounded-0">
			<div class="card-body">
				<a href="" class="btn btn-danger rounded-0" @click.prevent="add_order()">Agregar pedido</a>
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				<div class="list-pos">
					<div class="list-pos-header d-flex justify-content-between align-items-center">
						<a href="">Hoy</a>
						<a href="">Ayer</a>
						<label for="">Fecha</label>
						<input type="date">
					</div>
					<div class="list-pos-header d-flex justify-content-between align-items-center">
						<label for="" class="mr-1">No.</label>
						<input type="text" class="form-control form-control-sm rounded-0 shadow-none">
						</div>
					</div>
					<div class="list-pos-child">
						<div class="list-pos-link">
							<p><span>Pedido:</span>456</p>
							<p><span>Fecha:</span>12/03/23</p>
						</div>
						<p>Abdias Reyes Reyna</p>
						<div class="d-flex justify-content-between align-items-center">
							<div class="d-block">
								<p>Envio a domicilio</p>
								<p>Saldo: <span class="text-danger">$250.00</span></p>
							</div>
							<a href="" class="btn btn-danger rounded-0 btn-sm"><span class="bi bi-arrow-right-short"></span></a>
						</div>
					</div>
					<div class="list-pos-child">
						<div class="list-pos-link">
							<p><span>Pedido:</span>456</p>
							<p><span>Fecha:</span>12/03/23</p>
						</div>
						<p>Patricia Ortega Durán</p>
						<div class="d-flex justify-content-between align-items-center">
							<div class="d-block">
								<p>Envio a domicilio</p>
								<p>Saldo: <span class="text-danger">$250.00</span></p>
							</div>
							<a href="" class="btn btn-danger rounded-0 btn-sm"><span class="bi bi-arrow-right-short"></span></a>
						</div>
					</div>
					<div class="list-pos-child">
						<div class="list-pos-link">
							<p><span>Pedido:</span>456</p>
							<p><span>Fecha:</span>12/03/23</p>
						</div>
						<p>Esteban Labrego Martínez</p>
						<div class="d-flex justify-content-between align-items-center">
							<div class="d-block">
								<p>Envio a domicilio</p>
								<p>Saldo: <span class="text-danger">$250.00</span></p>
							</div>
							<a href="" class="btn btn-danger rounded-0 btn-sm"><span class="bi bi-arrow-right-short"></span></a>
						</div>
					</div>
					
				</div>
			</div>
			<div class="col-9">

			</div>
		</div>																
	</div>
</template>
<script>
	import VueSelect from 'vue-select'
	import 'vue-select/dist/vue-select.css';
	export default{
		data(){
			return{

			}
		},
		methods:{
			add_order(){
				var me = this;
				var url = '/add_sale_slug';
				let slug = Math.random().toString(36).substring(3);
				axios.post(url,{
					'slug':slug,
				}).then(function(response){
					window.location.href = 'add_sale'+'/'+slug;
				})
			}
		},
		mounted(){

		}
	}
</script>