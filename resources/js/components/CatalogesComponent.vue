<template>
	<div class="container">
		<h5 class="m-0">Catálogos</h5>
		<button class="btn btn-danger btn-sm mt-4" @click="add_cataloge_modal(1)"><span class="bi bi-file-earmark-plus"></span> Agregar Catálogo</button>
		<table class="table table-bordered mt-4">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Proveedor</th>
					<th>Dcto.</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in array">
					<td>{{item.idCataloge}}</td>
					<td>{{item.cataloge_name}}</td>
					<td>{{item.company}} - {{item.name}}</td>
					<td>{{item.discount}}%</td>
					<td>
						<a href="#" class="icon-link" @click.prevent="open_trash_modal(item.idCataloge)"><span class="bi bi-trash"></span></a>
						<a href="#" class="icon-link" @click="open_trash_modal(item.idCataloge)"><span class="bi bi-pencil-square"></span>
						</a>
					</td>
				</tr>
			</tbody>
		</table>
		<h5 class="mt-4">Familias</h5>
		<button class="btn btn-danger btn-sm mt-4" @click="add_cataloge_modal(2)"><span class="bi bi-file-earmark-plus"></span> Agregar Familia</button>
		<table class="table table-bordered mt-4">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="family in list_family">
					<td>{{family.idFamily}}</td>
					<td>{{family.family_name}}</td>
					<td >
						<a href="#" class="icon-link" @click.prevent="open_trash_modal(item.idCataloge)"><span class="bi bi-trash"></span>
						</a>
						<a href="#" class="icon-link" @click="open_trash_modal(item.idCataloge)"><span class="bi bi-pencil-square"></span>
						</a>
					</td>
				</tr>
			</tbody>
		</table>
		
		<!-- Modal agergar Catalogo -->
		<div class="modal fade" id="add_cataloge" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable">
		    <div class="modal-content rounded-0">
		      	<div class="modal-header rounded-0 bg-color">
		        	<h5 class="modal-title text-white" id="staticBackdropLabel">Agregar Catálogo</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body">
		      		<div class="form-group">
		      			<label for="">Nombre del Catálogo</label>
						<input type="text"  class="form-control rounded-0 shadow-none" v-model="cataloge.cataloge_name" placeholder="Nombre del Catalogo">
						<p class="m-0 text-danger" v-if="errors.name">{{errors.name}}</p>
					</div>
					<label for="">Selecciona un proveedor</label>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-person input-icon"></span>
							<select class="input-control" v-model="cataloge.supplier">
								<option :value="supplier.idContact" v-for="supplier in suppliers" :selected="supplier.idContact ==1">{{supplier.company}}</option>
							</select>
						</div>
						<p class="m-0 text-danger" v-if="errors.supplier">{{errors.supplier}}</p>
					</div>
					<div class="d-flex justify-content-between align-items-center">
						<label for="">Este catalogo tiene un descuento</label>					
						<div class="my-form-group">
							<div class="input-layer">
								<span class="bi bi-percent input-icon"></span>
								<input type="text"  class="input-control" v-model="cataloge.discount" placeholder="Dcto.">
							</div>
							<p class="m-0 text-danger" v-if="errors.discount">{{errors.discount}}</p>
						</div>
					</div>
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn btn-danger btn-sm rounded-0" @click="add_cataloge()">Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal agregar familia-->
		<div class="modal fade" id="add_family" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable">
		    <div class="modal-content rounded-0">
		      	<div class="modal-header rounded-0 bg-color">
		        	<h5 class="modal-title text-white" id="staticBackdropLabel">Agregar Familia</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body">
		      		<div class="my-form-group">
		      			<div class="input-layer">
							<span class="bi bi-file-check input-icon"></span>
							<input type="text"  class="input-control" v-model="family" placeholder="Nombre de la Familia">
		      			</div>
					</div>
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn my-btn-secondary-sm" data-bs-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn my-btn-sm" @click="add_family()">Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- Modal advertencia -->
		<!-- Modal agergar Catalogo -->
		<div class="modal fade" id="modal_warning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable">
		    <div class="modal-content rounded-0">
		      	<div class="modal-body">
		      		<div class="body-warning">
			      		<center><span class="bi bi-exclamation-diamond warning-icon"></span>
			      		<p class="m-0 warning-title">¡Advertencia!</p>
			      		<p class="m-0 warning-text">La elminación de este catálogo, representa la eleminación de todos los productos que lo conforman.</p>
			      		<p class="m-0 warning-ref text-danger">¿Desas continuar?</p>
			      		</center>
		      		</div>
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><span class="bi bi-x-octagon"></span> Cancelar</button>
		        <button type="button" class="btn btn-danger btn-sm" @click="delete_confirm()"><span class="bi bi-check"></span> Confirmar</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
</template>
<script>
	import DataTable from 'datatables.net-bs5'
	export default{
		data(){
			return{
				suppliers:[],
				cataloge:{
					cataloge_name:"",
					supplier:"",
					discount:"",
					_token:document.querySelector('#csrf').getAttribute('content'),
				},
				array:[],
				errors:{
					cataloge_name:"",
					supplier:"",
					discount:"",
				},
				id_cataloge:"",
				family:"",
				list_family:[],
			}
		},
		methods:{
			add_cataloge_modal(data){
				if (data==1) {
					this.get_suppliers();
					$("#add_cataloge").modal('show');
				}else{
					$("#add_family").modal('show');
				}
			},
			add_cataloge(){
				var me = this;
				var url = "/add_cataloge";
				axios.post(url,{
					'idProvider':me.cataloge.supplier,
					'name':me.cataloge.cataloge_name,
					'discount':me.cataloge.discount
				}).then(function(response){
					if (response.data==1) {
						$('#add_cataloge').modal('hide');
						me.errors = "";
						me.cataloge = "";
						var title = "Felicidades";
						var message = "Has creado un catálogo";
						toaster(title,message);
						me.cataloge.cataloge_name = "";
						me.cataloge.supplier = "";
						me.cataloge.discount = "";
						me.list_cataloges();
					}

					
				}).catch(function(errors){
					if (errors.response.data.errors.name) {
		         	 	me.errors.name = errors.response.data.errors.name[0];
		         	}else{
		         	 	me.errors.name ="";
		         	}
		         	if (errors.response.data.errors.supplier) {
		         	 	me.errors.supplier = errors.response.data.errors.supplier[0];
		         	}else{
		         	 	me.errors.supplier ="";
		         	}
		         	if (errors.response.data.errors.discount) {
		         	 	me.errors.discount = errors.response.data.errors.discount[0];
		         	}else{
		         	 	me.errors.discount ="";
		         	}
				});
			},
			get_suppliers(){
				var me = this;
				var url = "contacts_list/"+2;
				axios.get(url).then(function(response){
					me.suppliers = response.data
				})
			},
			list_cataloges(){
				var me = this;
				var url = '/show_cataloges';
				axios.get(url).then(function(response){
					me.array = response.data;
				})
			},
			open_trash_modal(data){
				$('#modal_warning').modal('show');
				this.id_cataloge = data
			},
			delete_confirm(){
				var me = this;
				var id = this.id_cataloge;
				var url = "/delete_cataloge/"+id;
				axios.get(url).then(function(response){
					if (response.data==1) {
						$('#modal_warning').modal('hide');
						var title = "Felicidades";
						var message = "Se Elminó el catálogo";
						toaster(title,message);
						me.list_cataloges();
					}
				})
			},
			add_family(){
				var me = this;
				var url = '/add_family';
				axios.post(url,{
					'family_name':me.family,
				}).then(function(response){
					if (response.data==1) {
						$('#add_family').modal('hide');
						var title = "Felicidades";
						var message = "Se agregó una familia";
						toaster(title,message);
						me.get_family();
					}
				})
			},
			get_family(){
				var me = this;
				var url = '/get_family';
				axios.get(url).then(function(response){
					me.list_family = response.data;
				})
			},
			delete_family(){

			}

		},
		mounted(){
			this.list_cataloges();
			this.get_family();
		}
	}
</script>