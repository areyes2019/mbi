<template>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="my-breadcumb">
	                <a href="/home">Inicio <span class="ti-angle-right"></span></a>
	                <p class="m-0 p-0">Tiendas Woocommerce</p>
	            </div>
			</div>
		</div>
		<div class="card-box mt-3">
			<button class="btn my-btn" @click="open_modal()">Crear tienda</button>
		</div>
       <div class="row mt-5">
       	<div class="col-md-4 mt-2" v-for="store in data">
       		<div class="card-box-std p-3">
       			<p class="text-danger"><a href="#" @click.prevent=to_store(store.idStore,store.slug)>{{store.name}}</a></p>
       			<p class="m-0 p-0">Llave publica <strong>{{store.public_key}}</strong></p>
       			<p class="m-0 p-0">Llave privada <strong>{{store.private_key}}</strong></p>
       			<div class="d-flex justify-content-end">
       				<button class="btn my-btn-secondary-sm mr-3"><span class="ti-pencil-alt"></span></button>
       				<button class="btn my-btn-sm"><span class="ti-trash"></span></button>
       			</div>
       		</div>
       	</div>
       </div>
        <div class="modal fade" tabindex="-1" id="open">
		  <div class="modal-dialog">
		    <div class="modal-content rounded-0">
		      <div class="modal-header bg-color rounded-0">
		        <h5 class="modal-title text-white">Crear Tienda</h5>
		        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="my-modal-body p-4">
		        <div class="my-form-group">
		        	<span class="bi bi-shop input-icon"></span>
		        	<input type="text" class="input-control" v-model="name" placeholder="Nombre de la tienda">
		        	<span class="text-danger" v-if="err_name">{{err_name}}</span>
		        </div>
		        <div class="my-form-group">
		        	<span class="bi bi-shop input-icon"></span>
		        	<input type="text" class="input-control" v-model="url" placeholder="URL de la tienda">
		        	<span class="text-danger" v-if="err_name">{{err_url}}</span>
		        </div>
		        <div class="my-form-group">
		        	<span class="ti-key input-icon"></span>
		        	<input type="text" class="input-control" v-model="public_key" placeholder="Llave pública">
		        	<span class="text-danger" v-if="err_public_key">{{err_public_key}}</span>
		        </div>
		        <div class="my-form-group">
		        	<span class="bi bi-incognito input-icon"></span>
		        	<input type="text" class="input-control" v-model="private_key" placeholder="Llave privada">
		        	<span class="text-danger" v-if="err_private_key">{{err_private_key}}</span>
		        	<span class="text-danger" v-if="err_slug">{{err_slug}}</span>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn my-btn-secondary" data-bs-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn my-btn" @click="add_store()">Guardar</button>
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
				data:[],
				name:"",
				url:"",
				public_key:"",
				private_key:"",
				csrf:document.querySelector('#csrf').getAttribute('content'),
				characteres:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",
				/*errors*/
				err_name:"",
				err_url:"",
				err_slug:"",
				err_public_key:"",
				err_private_key:"",
				success:"",
			}
		},
		methods:{
			get_list(){
				var me=this;
				var url = '/woocommerce_list';
				axios.get(url).then(function(response){
					me.data = response.data; 
				})
			},
			add_store(){
				var me = this;
				var url = "/add_woocommerce";
				var slug = Math.random().toString(36).substring(2);
				axios.post(url,{
					'_token':me.csrf,
					'name':me.name,
					'url':me.url,
					'slug':slug,
					'public_key':me.public_key,
					'private_key':me.private_key

				})
				.then(function(response){
					me.name="";
					me.public_key="";
					me.private_key="";
					$('#open').modal('hide');
					var title = "Felicidades";
					var message = "Has creado una connexion";
					toaster(title,message);
					me.get_list();
				}).catch(function(errors){
					if (errors.response.data.errors.name) {
						me.err_name = errors.response.data.errors.name[0];
					}else{
						me.err_name ="";
					}
					if (errors.response.data.errors.url) {
						me.err_name = errors.response.data.errors.url[0];
					}else{
						me.err_url ="";
					}
					if (errors.response.data.errors.public_key) {
						me.err_public_key = errors.response.data.errors.public_key[0];
					}else{
						me.err_public_key ="";
					}
					if (errors.response.data.errors.private_key) {
						me.err_private_key = errors.response.data.errors.private_key[0];
					}else{
						me.err_private_key ="";
					}
					if (errors.response.data.errors.slug) {
						me.err_slug = errors.response.data.errors.slug[0];
					}else{
						me.err_slug = "";
					}
				});
				
			},
			open_modal(){
				$('#open').modal('show');
			},
			to_store(id, slug){
				window.location.href = '/store/'+id+'/'+slug;
			}
		},
		mounted(){
			this.get_list();
		}
	}
</script>