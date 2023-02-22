<template>
	<div class="container">
		<div class="card-box-std p-3">
			<div class="row">
				<div class="col-md-4">
					<h5>Productos de <strong>{{name}}</strong></h5>
				</div>
				<div class="col-md-8 d-flex justify-content-end">
					<a href="">Ver por categorías</a>
				</div>
			</div>
		</div>
		<div class="card-box-std p-3 mt-3">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>Precio</th>
						<th>Visibilidad</th>
						<th>Stock</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="items in data">
						<td>{{items.id}}</td>
						<td>{{items.name}}</td>
						<td>{{items.price}}</td>
						<td>{{items.catalog_visibility}}</td>
						<td>{{items.stock_quantity}}</td>
						<th>
							<button class="btn my-btn-sm" @click="goto_article(items.id)"><span class="ti-hand-point-right"></span> Ver</button>
							<button class="btn my-btn-secondary-sm"><span class="bi bi-download"></span></button>
						</th>
					</tr>
				</tbody>	
			</table>
		</div>
	</div>
</template>
<script>
	import DataTable from 'datatables.net-bs5'
	export default{
		props:['store'],
		data(){
			return{
				name:"",
				data:[],
			}
		},
		methods:{
			store_data(){
				var me = this;
				var url = "/store_id/"+this.store;
				axios.get(url).then(function(response){
					me.name = response.data;
				})
			},
			articles(){
				var me = this;
				var url = "/woo_articles_list/"+this.store;
				axios.get(url).then(function(response){
					me.data = response.data;
					me.table();
				})
			},
			goto_article(data){
				var me = this;
				var url = "/woo_get_article/"+data+'/'+this.store;
				window.location.href=url;
				
			},
			table(){
				$(document).ready(function () {
                    $('#woocommerce').DataTable();
                });
			}
		},
		mounted(){
			this.store_data();
			this.articles();
		}
	}
</script>