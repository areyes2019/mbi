<template>
	<div class="container-fluid">
		<div class="container-fluid">
	<ul class="nav nav-tabs" id="myTab" role="tablist">
  		<li class="nav-item" role="presentation">
    		<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Resumen</button>
  		</li>
  		<li class="nav-item" role="presentation">
    		<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#charge" type="button" role="tab" aria-controls="profile" aria-selected="false">Pendientes de Cobro</button>
  		</li>
  		<li class="nav-item" role="presentation">
    		<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#spense" type="button" role="tab" aria-controls="contact" aria-selected="false">Gastos</button>
  		</li>
  		<li class="nav-item" role="presentation">
    		<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#invoice" type="button" role="tab" aria-controls="contact" aria-selected="false">Para Facturar</button>
  		</li>
  		<li class="nav-item" role="presentation">
    		<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#credit" type="button" role="tab" aria-controls="contact" aria-selected="false">Notas de Credito</button>
  		</li>
	</ul>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  			<div class="container mt-4">
  				<h5>Enero 2023</h5>
  				<h4>Inventario</h4>
  				<table class="table table-bordered">
  					<tr>
  						<th>Total de inventario</th>
  						<td>$985.22</td>
  					</tr>
  					<tr>
  						<th>Utilidad del Inventario</th>
  						<td>$259.00</td>
  					</tr>
  				</table>
  				<h4>General</h4>
  				<table class="table table-bordered">
  					<tr>
  						<th>Ingresos Netos</th>
  						<td>$20.000</td>
  					</tr>
  					<tr>
  						<th>Gastos totales</th>
  						<td>$456.00</td>
  					</tr>
  					<tr>
  						<th>Utilidades en Bruto</th>
  						<td>$456.00</td>
  					</tr>
  					<tr>
  						<th>Utilidades Netas</th>
  						<td>$456.00</td>
  					</tr>
  				</table>
  			</div>
  		</div>
	  	
	</div>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show" id="charge" role="tabpanel" aria-labelledby="home-tab">
  			<div class="container mt-4">
  				<h5>Enero 2023</h5>
  				<table class="table table-bordered">
  					<tr>
  						<th>Id</th>
  						<th>Cliente</th>
  						<th>Anticipo</th>
  						<th>Saldo</th>
  						<th>Fecha</th>
  					</tr>
  					<tr>
  						<td>5</td>
  						<td>Mallas del Centro</td>
  						<td>$2596.00</td>
  						<td>$2596.00</td>
  						<td>25/11/23</td>
  					</tr>
  				</table>
  			</div>
  		</div>
	  	
	</div>
	<!-- Gastos -->
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show" id="spense" role="tabpanel" aria-labelledby="home-tab">
  			<div class="container mt-4">
  				<h5>{{month}} {{year}}</h5>
  				<form action="add_spent" method="post">
  					<div class="row mt-3 mb-3">
  						<div class="col">
  							<label for="">Concepto</label>
  							<input type="text" v-model="data.description" placeholder="Concepto del gasto" class="form-control rounded-0 shadow-none">
  						</div>
  						<div class="col">
  							<label for="">Cantidad</label>
  							<input type="text" v-model="data.amount" placeholder="Monto" class="form-control rounded-0 shadow-none">
  						</div>
  						<div class="col">
  							<label for="">Facturación</label>
  							<select v-model="data.invoice" id="" class="form-control rounded-0 shadow-none">
  								<option value="">Seleccione...</option>
  								<option value="0">Sin Factura</option>
  								<option value="1">Con Factura</option>
  							</select>
  						</div>
  						<div class="col">
  							<label for="">Tipo de Gasto</label>
  							<select v-model="data.type" id="" class="form-control rounded-0 shadow-none">
  								<option value="">Seleccione...</option>
  								<option value="1">Impuestos</option>
  								<option value="2">Suministros</option>
  								<option value="3">Gastos variables</option>
  								<option value="4">Gastos fijos</option>
  							</select>
  						</div>
  						<div class="col">
  							<label for="">Cuenta</label>
  							<select v-model="data.account" id="" class="form-control rounded-0 shadow-none">
  								<option value="">Seleccione...</option>
  								<option value="Efectivo">Efectivo</option>
  								<option value="Santander">Santander</option>
  								<option value="BBVA">BBVA</option>
  							</select>
  						</div>
  						<div class="col d-flex align-items-end">
  							<input type="submit" class="btn btn-danger rounded-0">
  						</div>
  					</div>
  				</form>
  				<table class="table table-bordered">
  					<tr>
  						<th>Fecha</th>
  						<th>Concepto</th>
  						<th>Monto</th>
  						<th>Facturado</th>
  						<th>Cuenta</th>
  					</tr>
  					<tr v-for = "data in list">
  						<td>{{date_format(data.created_at)}}</td>
  						<td>{{data.description}}</td>
  						<td>{{data.amount}}</td>
  						<td v-if="data.reference == 1">Facturado</td>
  						<td v-if="data.reference == 2">Sin Factura</td>
  						<td>{{data.account}}</td>
  					</tr>
  				</table>
  			</div>
  		</div> 	
	</div>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show" id="credit" role="tabpanel" aria-labelledby="home-tab">
  			<div class="container mt-4">
  				<form action="add_credit" method="post">
  					@csrf
  					<div class="row mt-3 mb-3">
  						<div class="col">
  							<label for="">Orden De Venta</label>
  							<select name="supplier" id="" class="form-control">
  								<option value="">Selecciona una opción...</option>
  								<option value="">Kimu S.A de C.V</option>
  								<option value="">Trodat S.A de C.V</option>
  							</select>
  						</div>
  						<div class="col">
  							<label for="">Orden De Venta</label>
  							<input type="text" name="order" placeholder="Ej, Orden 45695" class="form-control rounded-0 shadow-none">
  						</div>
  						<div class="col">
  							<label for="">Monto</label>
  							<input type="text" name="amount" placeholder="Monto" class="form-control rounded-0 shadow-none">
  						</div>
  						<div class="col d-flex align-items-end">
  							<input type="submit" class="btn btn-danger rounded-0">
  						</div>
  					</div>
  				</form>
  				<table class="table table-bordered">
  					<tr>
  						<th>Fecha</th>
  						<th>Concepto</th>
  						<th>Facturado</th>
  						<th>Monto</th>
  						<th>Fecha</th>
  					</tr>
  					<tr>
  						<td></td>
  						<td>Pago de Gasolina</td>
  						<td>No</td>
  						<td>$2596.00</td>
  						<td>25/11/23</td>
  					</tr>
  				</table>
  			</div>
  		</div>
	  	
	</div>
</div>
	</div>
</template>
<script>
	import moment from "moment";
	export default{
		data(){
			return{
				list:[],
				data:[],
				moment:moment,
				month:"",
				year:"",
			}
		},
		methods:{
			get_data(){
				var me = this;
				var url = '/show_spent';
				axios.get(url).then(function(response){
					me.list = response.data.data;
					me.month = response.data.month;
					me.year = response.data.year;
				})
			},
			add_data(){
				var me = this;
				var url = '/add_spent';
				axios.get(url,{
					'type':data.type,
					'account':data.account,
					'description':data.description,
					'reference':data.invoice,
					'amount':data.amount,
				}).then(function(response){
					me.get_data();
				})
			},
			date_format(d){
				return moment(d).format('DD-MMMM-YYYY')
			}

		},
		mounted(){
			this.get_data();
		}
	}
</script>