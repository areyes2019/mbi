<template>
	<div class="container-fluid">
		<h3>Inventario</h3>
		<div class="row">
			<div class="col-md-4">
				<div class="card">
		            <div class="card-body">
		                <h5 class="card-title">Valor Total</h5>
		                <h6 class="card-subtitle mb-2 text-muted">Valor bruto del inventario</h6>
		                <h4>${{total_value}}</h4>
		                <a href="#" class="card-link">Ir a resumen</a>
		            </div>
		        </div>
			</div>
			<div class="col-md-4">
				<div class="card">
		            <div class="card-body">
		                <h5 class="card-title">Valor Beneficio</h5>
		                <h6 class="card-subtitle mb-2 text-muted">Valos de las utilidades del inventario</h6>
		                <h4>${{profit}}</h4>
		                <a href="#" class="card-link">Ir a resumen</a>
		            </div>
		        </div>
			</div>
			<div class="col-md-4">
				<div class="card">
		            <div class="card-body">
		                <h5 class="card-title">Valor invertido</h5>
		                <h6 class="card-subtitle mb-2 text-muted">Valor de productos en iventario</h6>
		                <h4>${{investment}}</h4>
		                <a href="#" class="card-link">Ir a resumen</a>
		            </div>
		        </div>
			</div>
		</div>
		<div class="card mt-4 mb-2 rounded-0">
			<div class="card-header">
				<div class="row">
					<div class="col">
						<label for="">Artículo</label>
						<vue-select :options="result" :reduce="model => model.idArticle" class="rounded-0" v-model="article" label="model"></vue-select>
					</div>
					<div class="col">
						<label for="">Cantidad</label>
						<input type="number" class="form-control shadow-none rounded-0" min="1" v-model="quantity">
					</div>
					<div class="col d-flex align-items-end">
						<button class="btn btn-danger" @click="update_stock">Guardar</button>
					</div>
				</div>
			</div>
			<div class="card-body">
				<h3 class="mt-4">Lista de existencias</h3>
				<table class="table table-bordered mt-1">
					<tr>
						<th>#</th>
						<th>Cant</th>
						<th>Artículo</th>
						<th>Modelo</th>
						<th>P/U</th>
						<th>Total</th>
						<th></th>
					</tr>
					<tr v-for = "list in data">
						<td>{{list.idStock}}</td>
						<td>{{list.quantity}}</td>
						<td>{{list.name}}</td>
						<td>{{list.model}}</td>
						<td>${{list.cost}}</td>
						<td class="d-none">{{sum = list.cost * list.quantity}}</td>
						<td>${{res = sum.toFixed(2)}}</td>
						<td>
							<a href="" @click.prevent="delete_line(list.idStock)"><span class="bi bi-trash"></span></a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</template>
<script>
	import VueSelect from 'vue-select'
	import 'vue-select/dist/vue-select.css';
	import datatable from 'datatables.net-bs5'
	export default{
		components:{
    		VueSelect
  		},
		data(){
			return{
				data:[],
				search:"",
				result:[],
				quantity:"",
				article:"",
				total_value:"",
				profit:"",
				investment:"",
			}
		},
		methods:{
			get_data(){
				var me=this;
				var url = '/show_stock';
				axios.get(url).then(function(response){
					me.data = response.data.table;
					me.total_value = response.data.total_value;
					me.profit = response.data.profit;
					me.investment = response.data.investment;
				})
			},
			select_stock(){
				var me = this;
				var url = '/select_stock';
				axios.get(url).then(function(response){
					me.result = response.data;
				})
			},
			/*search_list(){
				var me = this;
				var url = 'search_stock';
				axios.post(url,{
					'data': me.search
				}).then(function(response){
					
					if (response.data == 0) {
						me.result = ""
					}else{
						me.result = response.data;
					}
				})
			},*/
			list_value(data){
				var text = $("#"+data).text();
				this.search = text;
				this.result ="";
				this.article = data;
			},
			update_stock(){
				var me = this;
				var url = '/update_stock';
				axios.post(url,{
					'qty':me.quantity,
					'article':me.article
				}).then(function(response){
					me.get_data();
					me.article = "";
					me.quantity = "";
					me.search = "";
				})
			},
			delete_line(data){
				var me = this;
				var url = '/delete_stock_line';
				axios.post(url,{
					'stock':data
				}).then(function(response){
					var title = "Felicidades";
                    var message = "Has ha contabilizado esta cotización";
                    toaster(title,message);
					me.get_data();

				})
			}
		},
		mounted(){
			this.get_data();
			this.select_stock();
		}
	}
</script>