<template>
	<div class="container">
		<div class="card-box-std p-3">
			<button class="btn btn-danger btn-sm" @click="open_modal()">Nuevo {{button}}</button>
		</div>
		<div class="card-box-std p-3 mt-3">
			<h3>{{page_title}}</h3>
			<table class="table" id="contacts">
				<thead>
					<tr>
						<th>#</th>
						<th>Empresa</th>
						<th>Nombre</th>
						<th>Correo</th>
						<th>Telefono</th>
						<th>Mobil</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="item in data">
						<td>{{item.idContact}}</td>
						<td>{{item.company}}</td>
						<td>{{item.name}}</td>
						<td>{{item.email}}</td>
						<td>{{item.phone}}</td>
						<td>{{item.mobile}}</td>
						<td>
							<button class="btn btn-primary btn-sm mr-2" @click="update_contact_modal(item.idContact)">Editar</button>
							<button class="btn btn-danger btn-sm" @click="delete_contact(item.idContact)">Borrar</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- modal agregar proveedor -->
		<div class="modal fade" id="new" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable">
		    <div class="modal-content rounded-0">
		      	<div class="modal-header rounded-0 bg-color">
		        	<h5 class="modal-title" id="staticBackdropLabel">{{modal_title}}</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body">
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-shop input-icon"></span>
							<input type="text" v-model="save.company" id="" class="input-control" placeholder="Nombre de la empresa">
						</div>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-person input-icon"></span>
							<input type="text" v-model="save.name" id="" class="input-control" placeholder="Nombre de Contacto *">
						</div>
						<span class="text-danger" v-if="name">{{name}}</span>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-envelope input-icon"></span>
							<input type="text" v-model="save.email" id="" class="input-control" placeholder="Correo Electrónico" aria-describedby="helpId">
						</div>
						<span class="text-danger" v-if="email">{{email}}</span>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-telephone input-icon"></span>
							<input type="text" v-model="save.phone" id="" class="input-control" placeholder="Teléfono fijo" maxlength="10">
							<span class="text-danger" v-if="phone" >{{phone}}</span>
						</div>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-phone input-icon"></span>
							<input type="text" v-model="save.mobile" id="" class="input-control" placeholder="Telefono mobil *"  axlength="10">
						</div>
						<span class="text-danger" v-if="mobile">{{mobile}}</span>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-geo input-icon"></span>
	                      	<input type="text" v-model="save.address" id="" class="input-control" placeholder="Calle y numero">
						</div>
						<span class="text-danger" v-if="address">{{address}}</span>
                    </div>
                    <div class="my-form-group">
                    	<div class="input-layer">
							<span class="bi bi-map input-icon"></span>
	                      	<input type="text" v-model="save.zone" id="" class="input-control" placeholder="Colonia">
                    	</div>
						<span class="text-danger" v-if="zone">{{zone}}</span>
                    </div>
                    <div class="my-form-group">
                    	<div class="input-layer">
							<span class="bi bi-123 input-icon"></span>
	                      	<input type="text" v-model="save.zip" id="" class="input-control" placeholder="Código Postal">
                    	</div>
						<span class="text-danger" v-if="zip">{{zip}}</span>
                    </div>
                    <div class="my-form-group">
                    	<div class="input-layer">
							<span class="bi bi-credit-card-2-front input-icon"></span>
                      		<input type="text" v-model="save.tax_id" id="" class="input-control" placeholder="RFC" >
                      	</div>
						<span class="text-danger" v-if="tax_id">{{tax_id}}</span>
                    </div>
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn btn-danger btn-sm" @click="add_contact()">Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- modal editar contacto -->
		<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable">
		    <div class="modal-content rounded-0" v-for="update_contact in update_data">
		      	<div class="modal-header rounded-0 bg-color">
		        	<h5 class="modal-title text-white" id="staticBackdropLabel">{{modal_title}}</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body">
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-shop input-icon"></span>
							<input type="text" v-model="update_contact.company" id="" class="input-control" placeholder="Nombre de la empresa">
						</div>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-person input-icon"></span>
							<input type="text" v-model="update_contact.name" id="" class="input-control" placeholder="Nombre de Contacto *">
						</div>
						<span class="text-danger" v-if="name">{{name}}</span>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-envelope input-icon"></span>
							<input type="text" v-model="update_contact.email" id="" class="input-control" placeholder="Correo Electrónico" aria-describedby="helpId">
						</div>
						<span class="text-danger" v-if="email">{{email}}</span>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-telephone input-icon"></span>
							<input type="text" v-model="update_contact.phone" id="" class="input-control" placeholder="Teléfono fijo" maxlength="10">
							<span class="text-danger" v-if="phone" >{{phone}}</span>
						</div>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-phone input-icon"></span>
							<input type="text" v-model="update_contact.mobile" id="" class="input-control" placeholder="Telefono mobil *"  axlength="10">
						</div>
						<span class="text-danger" v-if="mobile">{{mobile}}</span>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-geo input-icon"></span>
	                      	<input type="text" v-model="update_contact.address" id="" class="input-control" placeholder="Calle y numero">
						</div>
						<span class="text-danger" v-if="address">{{address}}</span>
                    </div>
                    <div class="my-form-group">
                    	<div class="input-layer">
							<span class="bi bi-map input-icon"></span>
	                      	<input type="text" v-model="update_contact.zone" id="" class="input-control" placeholder="Colonia">
                    	</div>
						<span class="text-danger" v-if="zone">{{zone}}</span>
                    </div>
                    <div class="my-form-group">
                    	<div class="input-layer">
							<span class="bi bi-123 input-icon"></span>
	                      	<input type="text" v-model="update_contact.zip" id="" class="input-control" placeholder="Código Postal">
                    	</div>
						<span class="text-danger" v-if="zip">{{zip}}</span>
                    </div>
                    <div class="my-form-group">
                    	<div class="input-layer">
							<span class="bi bi-credit-card-2-front input-icon"></span>
                      		<input type="text" v-model="update_contact.tax_id" id="" class="input-control" placeholder="RFC" >
                      	</div>
						<span class="text-danger" v-if="tax_id">{{tax_id}}</span>
                    </div>
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn btn-danger btn-sm" @click="save_update(update_contact.idContact)">Guardar</button>
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
				data:[],
				save:{
					_token:document.querySelector('#csrf').getAttribute('content'),
					type:"",
				},
				//errores
				type:"",
				name:"",
				email:"",
				phone:"",
				mobile:"",
				address:"",
				zone:"",
				zip:"",
				tax_id:"",
				modal_title:"",
				taster:"",
				page_title:"",
				button:"",
				update_data:[],
				csrf: document.querySelector('#csrf').getAttribute('content'),
			}
		},
		methods:{
			get_list(){
				var me = this;
				var url = location.pathname.split('/').pop();
				axios.get('/contacts_list/'+url).then(function(response){
					me.table();
					me.data = response.data;
					if (url==1) {
						//si es cliente
						me.modal_title ="Agregar Cliente";
						me.toaster ="Cliente Agregado";
						me.page_title ="Lista de Clientes";
						me.button = "Cliente";
						me.save.type = 1;

					}else if (url==2) {
						//si es proveedor
						me.modal_title ="Agregar Proveedor";
						me.toaster ="Proveedor Agregado";
						me.page_title ="Lista de Proveedores";
						me.button = "Proveedor";
						me.save.type = 2;
					}else{
						//si es otro 
						me.modal_title ="Agregar Contacto";
						me.toaster ="Contacto Agregado";
						me.page_title ="Lista de Contacto";
						me.button = "Contacto";
						me.save.type = 3;
					}
				})
			},
			open_modal(){
				$('#new').modal('show');
			},
			table(){
				$(document).ready(function () {
				    $('#contacts').DataTable();
				});
			},
			add_contact(){
                var me = this;
                axios.post('/contact',me.save)
                .then(function(response){
					$('#new').modal('hide');
					me.get_list();
                	me.type="";
                	me.name="";
                	me.email="";
                	me.phone="";
                	me.mobile="";
                	me.address="";
                	me.zone="";
                	me.zip="";
                	me.tax_id="";
                	me.save = "";
                	var title = "Felicidades";
					var message = "Has creado un contacto";
					toaster(title,message);
                })
                .catch(function(errors){
		         	 if (errors.response.data.errors.type) {
		         	 	me.type = errors.response.data.errors.type[0];
		         	 }else{
		         	 	me.type ="";
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }
		         	 if (errors.response.data.errors.name) {
		         	 	me.name = errors.response.data.errors.name[0];
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }else{
		         	 	me.name = "";
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }
		         	 if (errors.response.data.errors.email) {
		         	 	me.email = errors.response.data.errors.email[0];
		         	 }else{
		         	 	me.email = "";
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }
		         	 if (errors.response.data.errors.phone) {
		         	 	me.phone = errors.response.data.errors.phone[0];
		         	 }else{
		         	 	me.phone = "";
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }
		         	 if (errors.response.data.errors.mobile) {
		         	 	me.mobile = errors.response.data.errors.mobile[0];
		         	 }else{
		         	 	me.mobile = "";
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }
		         	 if (errors.response.data.errors.address) {
		         	 	me.address = errors.response.data.errors.address[0];
		         	 }else{
		         	 	me.address ="";
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }
		         	 if (errors.response.data.errors.zone) {
		         	 	me.zone = errors.response.data.errors.zone[0];
		         	 }else{
		         	 	me.zone ="";
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }
		         	 if (errors.response.data.errors.zip) {
		         	 	me.zip = errors.response.data.errors.zip[0];
		         	 }else{
		         	 	me.zip ="";
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }
		         	 if (errors.response.data.errors.tax_id) {
		         	 	me.tax_id = errors.response.data.errors.tax_id[0];
		         	 }else{
		         	 	me.tax_id ="";
		         	 	me.save.type = location.pathname.split('/').pop();
		         	 }
       
                })
			},
			update_contact_modal(data){
				var me = this;
				var url = '/contact_show/'+data;
				axios.get(url).then(function(response){
					me.update_data = response.data;
					$('#edit').modal('show');
				})
			},
			save_update(data){    
                let me =this;
                var url = "/contact_update/"+data
                axios.post(url,{
                	'type':me.update_data[0].type,
                	'company':me.update_data[0].company,
                	'name':me.update_data[0].name,
                	'email':me.update_data[0].email,
                	'phone':me.update_data[0].phone,
                	'mobile':me.update_data[0].mobile,
                	'address':me.update_data[0].address,
                	'zone':me.update_data[0].zone,
                	'zip':me.update_data[0].zip,
                	'tax_id':me.update_data[0].tax_id,
                	'_token':me.csrf,
                }).then(function (response) {
                    if (response.data == true) {
	                    $('#edit').modal('hide');
	                 	var title = "Hecho";
						var message = "Actualizaste el"+me.button;
						toaster(title,message);
						me.get_list();   
                    }
                }).catch(function(errors){
                	console.log(errors.response.data.errors);
                })
            },
			delete_contact(data){
				var me = this;
				var url = '/delete_contact/'+ data;
				if (confirm('¿Deseas eliminar este proveedor?')) {
					axios.get(url).then(function(response){
						me.get_list();
						if (response.data==true) {
							var title = "Hecho";
							var message = "Contacto eliminado";
							toaster(title,message);
						}
					});
			  	}
			}
		},
		mounted(){
			this.get_list();
		}
	}
</script>