<template>
	<div class="container-fluid">
		<h3>Nueva nota de venta</h3>
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="">Nombre del Cliente</label>
							<input type="text" class="form-control rounded-0 shadow-none" v-model="name">
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label for="">Numero de Celular</label>
							<input type="text" class="form-control rounded-0 shadow-none" v-model="mobile">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 m-0">
						<div class="for-group">
							<label for="">Cantidad</label>
							<input type="number" min="1" value="1" class="form-control rounded-0 shadow-none" v-model="quantity">
						</div>
					</div>
					<div class="col-md-8 m-0">
						<div class="form-group">
							<label for="">Artículo</label>
							<vue-select :options="articles" :reduce="name => name.idArticle" class="rounded-0" v-model="article" label="name"></vue-select>
						</div>
					</div>
					<div class="col-md-2 d-flex align-items-end m-0">
						<div class="form-group d-flex justify-content-end">
							<button class="btn btn-danger rounded-0"><span>+</span></button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="">Anticipo</label>
							<input type="text" class="form-control rounded-0 shadow-none" v-model="advance">
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label for="">Saldo</label>
							<input type="text" class="form-control rounded-0 shadow-none" v-model="payment">
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label for="">Entrega</label>
							<select name="" id="" class="form-control rounded-0 shadow-none" v-model="delivery_type">
								<option value="">Selecciona un tipo...</option>
								<option value="1">A domicilio</option>
								<option value="2">Ocurre</option>
							</select>
						</div>
					</div>
				</div>
				<h4 class="mt-3">Datos de Entrega</h4>
				<div class="row">
					<div class="col-md-8">
						<div class="for-group">
							<label for="">Calle</label>
							<input type="text" class="form-control rounded-0 shadow-none" v-model="street">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Numero</label>
							<input type="text" class="form-control rounded-0 shadow-none" v-model="number">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="">Colonia</label>
					<input type="text" class="form-control rounded-0 shadow-none" v-model="zone">
				</div>
				<div class="form-group">
					<label for="">Recibe / Telefono</label>
					<input type="text" class="form-control rounded-0 shadow-none" v-model="receiber">
				</div>
				<div class="form-group">
					<label for="">Observaciones</label>
					<input type="text" class="form-control rounded-0 shadow-none" v-model="details">
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="">Día</label>
							<input type="date" class="form-control rounded-0 shadow-none" v-model="delivery_day">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="">Hora preferencial</label>
							<select name="" id="" class="form-control rounded-0 shadow-none" v-model="delivery_time">
								<option value="">10:00 a.m</option>
								<option value="">10:30 a.m</option>
								<option value="">11:00 a.m</option>
								<option value="">11:30 a.m</option>
								<option value="">01:00 a.m</option>
							</select>
						</div>
					</div>
				</div>
				<div class="d-grid gap-2 mt-3">
					<button class="btn btn-danger rounded-0">Actualizar</button>
				</div>
			</div>
			<div class="col-md-6">
				<div class="ticket">
					<div class="ticket-header">
						<div class="ticket-logo">
							<img src="img/logo2.png" alt="" width="90">
						</div>
						<div class="ticket-local" v-for="id in data">
							<p>WhatsApp 461 358 1090</p>
							<p>Fecha: {{date}}</p>
							<p class="ticket-data-text">Pedido: #{{id.idOrder}}</p>
						</div>
					</div>
					<div class="ticket-data">
						<table>
							<tr>
								<th>Cliente</th>
								<td>{{name}}</td>
							</tr>
							<tr>
								<th>WhatsApp</th>
								<td>{{mobile}}</td>
							</tr>
						</table>
					</div>
					<table class="order-table">
						<tr>
							<th>Cant.</th>
							<th>Descripción</th>
							<th>P/U</th>
							<th>Total</th>
						</tr>
						<tr>
							<td>1</td>
							<td>Sello de goma de 59 x 23</td>
							<td>$250</td>
							<td>$250</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Sello de goma de 59 x 23</td>
							<td>$250</td>
							<td>$250</td>
						</tr>
						<tr>
							<td>1</td>
							<td>Sello de goma de 59 x 23</td>
							<td>$250</td>
							<td>$250</td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<th>Sub-total</th>
							<td>$250</td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<th>Anticipo</th>
							<td>$125</td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<th>Total</th>
							<td>$250</td>
						</tr>
					</table>
					<div class="order-bottom">
						<div class="row">
							<div class="col-md-8">
								<div class="order-features">
									<div class="order-detail">
										<p class="m-0 p-0">Direccion de entrega</p>
										<p>{{street}}, {{number}}, {{zone}}</p>
										<p class="m-0 p-0">Recibe</p>
										<p>{{receiber}}</p>
									</div>
									<div class="order-detail">
										<p class="m-0 p-0">Observaciones</p>
										<p>Azul, Negro</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<img src="img/model.png" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import VueSelect from 'vue-select'
	import 'vue-select/dist/vue-select.css';
	export default{
		props:['slug'],
		components:{
    		VueSelect
  		},
		data(){
			return{
				data:[],
				articles:[],
				name:"",
				mobile:"",
				quantity:"",
				article:"",
				advance:"",
				payment:"",
				delivery_type:"",
				street:"",
				number:"",
				zone:"",
				receiber:"",
				details:"",
				delivery_day:"",
				delivery_time:"",
				options:[],
				date:""
			}
		},
		methods:{
			articles_get(){
				var me = this;
				var url = '/articles_list';
				axios.get(url).then(function(response){
					me.articles = response.data;
				})
			},
			get_data(){
				var me = this;
				var url = '/get_order_data/'+me.slug;
				axios.get(url).then(function(response){
					me.data = response.data.data;
					me.date = response.data.date;

				})
			},
			save_data(){
				/*var me = this;
				var url = '/save_order_customer';
				axios.post(url,{
					'name'
					'mobile'
					'quantity'
					'advance'
					'name'
					'name'
					'name'
					'name'
					'name'
				}).then(function(response){})*/
			}
		},
		mounted(){
			this.articles_get();
			this.get_data();

		}
	}
</script>