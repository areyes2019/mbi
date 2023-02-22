<template>
	<div class="container">
		<div class="card-box-std p-3">
			<div class="row">
				<div class="col-md-7">
					<div class="card-box-left">
						<div class="dropdown">
						  <button class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
						    Dropdown button
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
						    <li><a class="dropdown-item" href="#">Descargar Excel</a></li>
						    <li><a class="dropdown-item" href="#">Descargar PDF</a></li>
						  </ul>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="card-box-right">
						<label for="">Importar Excel</label>
						<input type="file" accept=".xlsx, .xls, .csv" @change="getExl" required ref="inputFile">
						<button class="btn btn-danger btn-sm" @click="importExl()"><span class="bi bi-upload"></span></button>
					</div>
				</div>
			</div>
		</div>
		<div class="card rounded-0">
			<div class="card-header rounded-0">
				<button class="btn btn-danger btn-sm rounded-0" @click.prevent="add_article"><span class="bi bi-box"></span> Agregar artículo</button>
			</div>
			<div class="card-body">
				<table class="table my-table" id="articles_table">
					<thead>
						<tr>
							<th>#</th>
							<th></th>
							<th>Nombre</th>
							<th>Mod.</th>
							<th>Tam.</th>
							<th>Fam.</th>
							<th>Mec.</th>
							<th>Goma</th>
							<th class="d-none"></th>
							<th>Total</th>
							<th>Precio</th>
							<th>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="article in table">
							<td>{{article.idArticle}}</td>
							<td>
								<a href=""><img :src="'storage/cataloge/'+article.img_url" alt="" width="40"></a>
							</td>
							<td>{{article.name}}</td>
							<td>{{article.model}}</td>
							<td>{{article.size}}</td>
							<td>{{article.family_name}}</td>
							<td>{{article.cost}}</td>
							<td>{{article.rubber}}</td>
							<td class="d-none">{{sum = parseFloat(article.cost) + parseFloat(article.rubber)}}</td>
							<td>{{res = sum.toFixed(2)}}</td>
							<td class="bg-secondary text-white font-weight-bold">{{article.price}}</td>
							<td>
								<a href="#" @click.prevent="showModal(article.idArticle)"><span class="bi bi-pencil-square"></span></a>
								<a href="#" @click.prevent="deleteData(article.idArticle)"><span class="bi bi-trash"></span></a>
								<a href="#" @click.prevent="addImage(article.idArticle)"><span class="bi bi-camera"></span></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- modal agregar artículo-->
		<div class="modal fade" id="add_article" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable">
		    <div class="modal-content rounded-0">
		      	<div class="modal-header rounded-0 bg-color">
		        	<h5 class="modal-title" id="staticBackdropLabel">Nuevo Artículo</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body">
		      		<div class="form-group">
		      			<label>Nombre del Sello</label>
						<input type="text" v-model="data.name" class="form-control rounded-0 shadow-none" placeholder="Nombre del Sello">
						<small class="text-danger m-0 p-0">{{errors.name}}</small>
					</div>
					<div class="form-group">
		      			<label>Modelo</label>
						<input type="text" v-model="data.model" class="form-control rounded-0 shadow-none" placeholder="Nombre del Sello">
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
				      			<label>Lineas sugeridas</label>
								<input type="number" min="1" v-model="data.lines" class="form-control rounded-0 shadow-none" value="1">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Tamaño</label>
								<input type="text" v-model="data.size" class="form-control rounded-0 shadow-none" placeholder="Tamaño">
							</div>
						</div>
					</div>
					<div class="my-form-group d-flex justify-content-between">
						<p class="m-0 p-0">¿Se agrega al stock?</p>
						<label class="switch">
						  <input type="checkbox" v-model="data.stock" :value="1">
						  <span class="slider"></span>
						</label>
					</div>
					<div class="my-form-group d-flex justify-content-between">
						<p class="m-0 p-0">Visible</p>
						<label class="switch">
						  <input type="checkbox" v-model="data.visible" :value="1">
						  <span class="slider"></span>
						</label>
					</div>
					<br>					
					<div class="form-group mt-3">
						<label for="">Precio Proveedor</label>
						<input type="text" v-model="data.cost" class="form-control rounded-0 shadow-none" placeholder="Precio Proveedor">
						<small class="text-danger">{{errors.cost}}</small>
					</div>
					<div class="form-group mt-3">
						<label for="">Precio Distribuidor</label>
						<input type="text" v-model="data.dealer" class="form-control rounded-0 shadow-none" placeholder="Precio Distribuidor">
						<small class="text-danger">{{errors.cost}}</small>
					</div>
					<div class="form-group">
						<label for="">Precio Público</label>
						<input type="text" v-model="data.price" class="form-control" placeholder="Precio Público">
						<small class="text-danger m-0">{{errors.price}}</small><br>
						<small class="text-danger m-0">{{errors.price_decimal}}</small>
					</div>
					<label for="">Asignar Proveedor</label>
					<div class="form-group">
						<div class="form-group">
							<div class="form-group">
								<span class="bi bi-people input-icon"></span>
								<select name="" id="" v-model="data.provider" class="input-control" @change="get_cataloge(data.provider)">
									<option :value="supplier.idContact" v-for="supplier in suppliers">{{supplier.company}}</option>
								</select>
							</div>
						</div>
						<small class="text-danger">{{errors.provider}}</small>
					</div>
					<label for="">Agregar Família</label>
					<div class="my-form-group">
						<div class="form-group">
							<span class="bi bi-people input-icon"></span>
							<select name="" id="" v-model="data.family" class="input-control">
								<option :value="member.idFamily" v-for="member in family">{{member.family_name}}</option>
							</select>
						</div>
						<small class="m-0 p-0 text-danger">{{errors.family}}</small>
					</div>
					<label for="">Agregar Categoría</label>
					<div class="my-form-group">
						<div class="form-group">
							<span class="bi bi-people input-icon"></span>
							<select name="" id="" v-model="data.categorie" class="input-control">
								<optgroup :label="parent.name" v-for="parent in parent_list">
									<option :value="child.idCategorie"  v-if="child.main == parent.idCategorie" v-for="child in child_list">{{child.name}}</option>
								</optgroup>
								<option :value="single.categorie" v-for="single in single_list" class="text-primary">{{single.name}}</option>
							</select>
						</div>
					</div>
					<label for="">Agregar a catálogo</label>
					<div class="my-form-group">
						<div class="form-group">
							<span class="bi bi-people input-icon"></span>
							<select  v-model="data.cataloge" class="input-control">
									<option :value="ctl.idCataloge"  v-for="ctl in cataloge">{{ctl.cataloge_name}}</option>
							</select>
						</div>
						<small class="m-0 p-0 text-danger">{{errors.cataloge}}</small>
					</div>
					
		      		<div class="row">
		      			<div class="col-md-6">
							<div class="my-form-group">
								<div class="form-group">
									<span class="bi bi-box input-icon"></span>
									<input type="number" min="1" v-model="data.re_order" class="input-control" placeholder="Cant. Re-orden">
								</div>
							</div>
		      			</div>
		      			<div class="col-md-6">
							<div class="my-form-group">
								<div class="form-group">
									<span class="bi bi-cash-coin input-icon"></span>
									<input type="text" v-model="data.discount" class="input-control" placeholder="Descuento %">
								</div>
							</div>
		      			</div>
		      		</div>
		      		<div class="row">
		      			<div class="col-12">
		      				<div class="form-group">
			      				<label for="">Descripción Corta</label>
			      				<textarea name="" id="" cols="30" rows="5" class="form-control rounded-0 shadow-none" v-model="data.short"></textarea>
		      				</div>
		      			</div>
		      			<div class="col-md-12">
		      				<div class="form-group">
			      				<label for="">Descripción Larga</label>
			      				<textarea name="" id="" cols="30" rows="5" class="form-control rounded-0 shadow-none" v-model="data.long"></textarea>
		      				</div>
		      			</div>
		      			
		      		</div>		      		
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn my-btn-secondary" data-bs-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn my-btn" @click="save_data()">Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- modal modificar artículo -->
		<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable">
		    <div class="modal-content rounded-0" v-for="product in update">
		      	<div class="modal-header rounded-0 bg-color">
		        	<h5 class="modal-title text-white" id="staticBackdropLabel">Editar Artículo</h5>
		        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body" >
	      			<div class="form-group">
	      				<label for="" class="mr-1">Nombre</label>
						<input type="text" v-model="product.name" class="form-control shadow-none rounded-0" placeholder="Nombre del Sello">
	      			</div>
					<div class="form-group">
						<label for="">Modelo</label>
						<input type="text" v-model="product.model" class="form-control shadow-none rounded-0" placeholder="Modelo">
					</div>
					<small class="text-danger m-0 p-0">{{errors.name}}</small>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Líneas</label>
								<input type="number" min="1" v-model="product.lines" class="form-control shadow-none rounded-0" placeholder="Líneas sugeridas">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Tamaño</label>
								<input type="text" v-model="product.size" class="form-control shadow-none rounded-0" placeholder="Tamaño">
							</div>
						</div>
					</div>
					<div class="my-form-group d-flex justify-content-between mt-3">
						<p class="m-0 p-0">¿Se agrega al stock?</p>
						<label class="switch">
						  <input type="checkbox" v-model="product.stock" :value="1">
						  <span class="slider"></span>
						</label>
					</div>
					<div class="my-form-group d-flex justify-content-between mt-3">
						<p class="m-0 p-0">Visible</p>
						<label class="switch">
						  <input type="checkbox" v-model="product.visible" :value="1">
						  <span class="slider"></span>
						</label>
					</div>					
					<div class="form-group">
						<label for="">Precio Proveedor</label>
						<input type="text" v-model="product.cost" class="form-control shadow-none rounded-0" placeholder="Precio Proveedor">
						<small class="text-danger">{{errors.cost}}</small>
					</div>
					<div class="form-group">
						<label for="">Precio de la Goma</label>
						<input type="text" v-model="product.rubber" class="form-control shadow-none rounded-0" placeholder="Precio Proveedor">
						<small class="text-danger">{{errors.rubber}}</small>
					</div>
					<div class="form-group">
						<label for="">Precio Público</label>
						<input type="text" v-model="product.price" class="form-control shadow-none rounded-0" placeholder="Precio Público">
						<small class="text-danger m-0">{{errors.price}}</small><br>
						<small class="text-danger m-0">{{errors.price_decimal}}</small>
					</div>
					<!-- <div class="form-group">
						<label for="">Precio Distribuidor</label>
						<input type="text" v-model="product.dealer" class="form-control shadow-none rounded-0" placeholder="Precio Proveedor">
						<small class="text-danger">{{errors.cost}}</small>
					</div>
					-->
					
					<label for="">Agregar Categoría</label>
					<div class="my-form-group">
						<div class="form-group">
							<select name="" id="" v-model="product.categorie" class="form-control shadow-none rounded-0">
								<optgroup :label="parent.name" v-for="parent in parent_list">
									<option :value="child.idCategorie"  v-if="child.main == parent.idCategorie" v-for="child in child_list">{{child.name}}</option>
								</optgroup>
								<option :value="single.idCategorie" v-for="single in single_list" class="text-primary">{{single.name}}</option>
							</select>
						</div>
					</div>
					<label for="">Agregar a catálogo</label>
					<div class="my-form-group">
						<div class="form-group">
							<select  v-model="product.cataloge" class="form-control shadow-none rounded-0">
									<option :value="ctl.idCataloge"  v-for="ctl in cataloge">{{ctl.cataloge_name}}</option>
							</select>
						</div>
						<small class="m-0 p-0 text-danger">{{errors.cataloge}}</small>
					</div>
					
		      		<div class="row">
		      			<div class="col-md-6">
		      				<label for="">Reorden</label>
							<div class="my-form-group">
								<div class="form-group">
									<input type="number" min="1" v-model="product.re_order" class="form-control shadow-none rounded-0" placeholder="Cant. Re-orden">
								</div>
							</div>
		      			</div>
		      			<div class="col-md-6">
		      				<label for="">Descuento</label>
							<div class="my-form-group">
								<div class="form-group">
									<input type="text" v-model="product.discount" class="form-control shadow-none rounded-0" placeholder="Descuento %">
								</div>
							</div>
		      			</div>
		      		</div>
		      		<div class="row">
		      			<div class="col-md-12">
		      				<label for="">Descripción Corta</label>
		      				<textarea name="" id="" cols="30" rows="5" class="form-control shadow-none rounded-0" v-model="product.short"></textarea>
		      			</div>
		      			<div class="col-md-12">
		      				<label for="">Descripción Larga</label>
		      				<textarea name="" id="" cols="30" rows="5" class="form-control shadow-none rounded-0" v-model="product.long"></textarea>
		      			</div>
		      			<div class="col-md-12">
		      				<label for="">Imágen</label>
		      				<input type="text" v-model="product.img_url" class="form-control shadow-none rounded-0" >
		      			</div>
		      		</div>		      		
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn my-btn-secondary" data-bs-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn my-btn" @click="updateData(product.idArticle)">Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<!-- errores de validacion -->
		<div class="modal fade" id="modal_warning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable">
		    <div class="modal-content rounded-0">
		      	<div class="modal-body">
		      		<div class="alert alert-warning" role="alert">
					  Tu importación tiene errores, por favor revisa tu archivo
					</div>
					<ul v-for="error in errors">
						<li><p>{{error}}</p></li>
					</ul>
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn my-btn-secondary-sm" data-bs-dismiss="modal"><span class="bi bi-x-octagon"></span> Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- modal imagen -->
		<div class="modal fade" id="modal_image" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable">
		    <div class="modal-content rounded-0">
		      	<div class="modal-body">
		      		<h3>Agregar imagen principal</h3>
		      		<form @submit.prevent="saveImg" enctype="mulipart/form-data">
		      			<input type="file" name="" @change="getImage" id="file">
		      			<button type="submit" class="btn btn-danger">Guardar</button>
		      		</form>

		      		<h3 class="mt-4">Agregar galería</h3>
					<form enctype="mulipart/formdata">
		      			<input type="file" name="" >
		      			<button type="submit" class="btn btn-danger">Guardar</button>
		      		</form>		      		
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn my-btn-secondary-sm" data-bs-dismiss="modal"><span class="bi bi-x-octagon"></span> Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
</template>
<script>
	import DataTable from 'datatables.net-bs5'
	export default{
		props:['percent'],
		data(){
			return{
				//aqui van los datos del artículo
				data:{
					_token:document.querySelector('#csrf').getAttribute('content'),
				},
				table:{},
				//aqui recibimos los errores
				errors:{},
				//mostrar cataogos
				cataloge:[],
				//update
				csrf:document.querySelector('#csrf').getAttribute('content'),
				update:{},
				//estilos
                display:"d-none",
                display_digit:"d-none",
                //datos del articulo
                article:[],
                article_array:"",
                categories:"",
                categorie:"",
                suppliers:[],
                exl:"",
                exl_name:"",
                family:[],
                search_family:"",

                //campos de busqueda
                search_name:"",

                //nombre del archivo
                exl:"",
                output: null,
                parent_list:[],
                child_list:[],
                single_list:[],
                errors:{
                	cost:"",
                	dealer:"",
                	name:"",
                	price:"",
                	provider:"",
                	family:"",
                	cataloge:""
                },
                img:"",
                image_id:""
			}
		},
		methods:{
			getData(){
                let me =this;
                let url = '/list' //Ruta que hemos creado para que nos devuelva todas las tareas
                axios.get(url).then(function(response) {
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.table = response.data;
                    me.my_table();
                })
            },
            
            get_categorie(){
            	var me = this;
            	var url = 'categories_list';
            	axios.get(url).then(function(response){

            	})
            },
            get_cataloge(data){
            	var me 	= this;
            	var url = '/get_cataloge/'+data;
            	axios.get(url).then(function(response){
            		//console.log(response.data);
            		me.cataloge = response.data;
            	}) 
            },
            getProviders(){
                var me = this;
                var url = 'contacts_list/'+2;
                axios.get(url).then(function(response){ 
                	me.suppliers = response.data
                });   
            },
            save_data(){

                var me = this;
                var url = "/articles";
                axios.post(url,me.data).then(function(response){
					me.getData();
                	me.errors="";
                	me.data=""
                	$('#add_article').modal('hide');
                	var title = "Felicidades";
					var message = "Has creado un artículo";
					toaster(title,message);
                }).catch(function(errors){
                	
                	if (errors.response.data.errors) {
                		me.errors = errors.response.data.errors;
                	}

                	if (errors.response.data.errors.name) {
		         	 	me.errors.name = errors.response.data.errors.name[0];
		         	}else{
		         	 	me.errors.name ="";
		         	}

		         	if (errors.response.data.errors.cost) {
		         	 	me.errors.cost = errors.response.data.errors.cost[0];
		         	}else{
		         	 	me.errors.cost ="";
		         	}
		         	

		         	if (errors.response.data.errors.dealer) {
		         	 	me.errors.dealer = errors.response.data.errors.dealer[0];
		         	}else{
		         	 	me.errors.dealer ="";
		         	}

		         	if (errors.response.data.errors.price) {
		         	 	me.errors.price = errors.response.data.errors.price[0];
		         	 	me.errors.price_decimal = errors.response.data.errors.price[1];
		         	}else{
		         	 	me.errors.price ="";
		         	 	me.errors.price_decimal ="";
		         	}

		         	if (errors.response.data.errors.provider) {
		         	 	me.errors.provider = errors.response.data.errors.provider[0];
		         	}else{
		         	 	me.errors.provider ="";
		         	}
		         	
		         	if (errors.response.data.errors.family) {
		         	 	me.errors.family = errors.response.data.errors.family[0];
		         	}else{
		         	 	me.errors.family ="";
		         	}
		         	
		         	if (errors.response.data.errors.cataloge) {
		         	 	me.errors.cataloge = errors.response.data.errors.cataloge[0];
		         	}else{
		         	 	me.errors.cataloge ="";
		         	}
		         	

		         	
                });
            },
            openLinked(data){
                
                $('#edit').modal('show');
                var me = this;
                var url = "article/"
                axios.get(url+data).then(function(response) {
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.article = response.data[0];
                })
            },
            cleanData(){
                this.name ="";
                this.model ="";
                this.size ="";
                this.cost ="";
                this.price ="";
                this.provider ="";
            },
            showModalAdd(){
                this.cleanData();
                $('#AddClient').modal('show');
            },
            showModal(data){
            	//console.log(data);
            	this.getProviders();
				this.getFamily();
				this.is_parent();
            	var me = this;
            	var url = '/articles/'+data
                axios.get(url).then(function(response){
                	me.update = response.data;
                })
                $('#edit_modal').modal('show');

            },
            addImage(data){
                $('#modal_image').modal('show');
                this.image_id = data;	
            },
            getImage(e){
            	var file = e.target.files[0];
            	this.img = file;
            },
            saveImg(){
            	var me = this;
            	var data = new FormData();
            	data.append('image',this.img);
            	data.append('_token', document.querySelector('#csrf').getAttribute('content'));
            	data.append('id_article', this.image_id);
            	var url = '/article_img';
            	axios.post(url,data).then(function(response){
            		if (response.data == 1) {
            			document.getElementById('file').value ='';
            			me.image_id = "";
            			me.getData();
            			$('#modal_image').modal('hide');
            			var title = "Felicidades";
						var message = "Tu imagen se ha agregado";
						toaster(title,message);
            		}
            	})
            },
            updateData(data){    
                let me =this;
                var url = "/articles/"+data;
                axios.put(url,{
                	'name':me.update[0].name,
                	'model':me.update[0].model,
                	'lines':me.update[0].lines,
                	'size':me.update[0].size,
                	'stock':me.update[0].stock,
                	'cost':me.update[0].cost,
                	'rubber':me.update[0].rubber,
                	'dealer':me.update[0].dealer,
                	'price':me.update[0].price,
                	'discount':me.update[0].discount,
                	'provider':me.update[0].provider,
                	're_order':me.update[0].re_order,
                	'visible':me.update[0].visible,
                	'family':me.update[0].family,
                	'short_desc':me.update[0].short_desc,
                	'long_desc':me.update[0].long_desc,
                	'img_url':me.update[0].img_url,
                	'categorie':me.update[0].categorie,
                	'cataloge':me.update[0].cataloge,
                	'_token':me.csrf,
                }).then(function (response) {
                    if (response.data == true) {
	                    me.getData();
	                    $('#edit_modal').modal('hide');
	                 	var title = "Hecho";
						var message = "Actualizaste el artículo";
						toaster(title,message);
						me.getData();   
                    }
                }).catch(function(errors){
                	console.log(errors.response.data.errors);
                })
            },
            deleteData(data){
                let me =this;
                let url = "/articles/"+data
                if (confirm('¿Seguro que deseas borrar este artículo?')) {
                    axios.delete(url).then(function (response) {
                        var title = "Hecho";
						var message = "Has borrado un artículo";
						toaster(title,message);
						me.getData();
                    })
                }
            },
        
            getExl(e){
                this.exl = e.target.files[0];
                this.exl_name = e.target.files[0].name;
                console.log(e.target.files[0]);
            },
            importExl(){
                //console.log('funciona');
                var me = this;
                //tomamos el archivo del formulario y la guardamos
                let formData = new FormData();
                    formData.set('file', this.exl);
                    axios.post('/excel', formData).then(function (response){
                    	if (response.data==1) {
                    		me.getData();
                    		var title = "Felicidades";
							var message = "La importacion fue exitosa";
							toaster(title,message);
                    		me.$refs.inputFile.value="";
                    	}
                    }).catch(function(errors){
                    	if (errors.response.data.errors) {
                    		me.errors = errors.response.data.errors;
                    		$('#modal_warning').modal('show');
                    	}
                    });
            },
            getFamily(){
                var me = this;
                var url = "/get_family";
                axios.get(url).then(function(response){
                    me.family = response.data;
                })

            },
            searchFamily(){
                
                var me = this;
                var url = "/search_family_line/"+this.search_family;
                if (this.search_family == "a") {
                    this.getData();
                }else{
                    axios.get(url).then(function(response){
                        me.dataArray = response.data;
                    })

                }
            },
            is_parent(){
            	var me = this;
            	var url = '/is_parent';
            	axios.get(url).then(function(response){
            		me.parent_list = response.data.parent;
            		me.child_list = response.data.child;
            		me.single_list = response.data.single;
            	})
            },
			add_article(){
				this.getProviders();
				this.getFamily();
				this.is_parent();
				$('#add_article').modal('show');
			},
			my_table(){
				$(document).ready(function () {
                    $('#articles_table').DataTable();
                });
			}
		},
		mounted(){
			this.getData();
			this.getProviders();
			this.getFamily();
			this.get_categorie();
		}
	}
</script>