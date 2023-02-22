<template>
	<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="my-breadcumb">
                <a href="/home">Inicio <span class="ti-angle-right"></span></a>
                <p class="m-0 p-0">Crear Contacto</p>
            </div>
		</div>
	</div>
	<div class="row mt-5 mb-5">
		<div class="col-md-8">
			<div class="card-box">
				<h4>Nuevo Contacto</h4>
				<form  action="" @submit.prevent="add_contact()">
					<div class="my-form-group">
						<p class="m-0 p-0">Tipo de contacto</p>
						<div class="radio-wrap">
							<span class="bi bi-people"></span>
							<label for="">Cliente</label>
							<input type="radio" name="type" value="1" v-model="data.type">
							<label for="">Proveedor</label>
							<input type="radio" name="type" value="2" v-model="data.type">
							<label for="">General</label>
							<input type="radio" name="type" value="3" v-model="data.type">
						</div>
						<small class="text-danger" v-if="type">{{type}}</small>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-shop input-icon"></span>
							<input type="text" v-model="data.company" id="" class="input-control" placeholder="Nombre de la empresa">
						</div>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-person input-icon"></span>
							<input type="text" v-model="data.name" id="" class="input-control" placeholder="Nombre">
						</div>
						<span class="text-danger" v-if="name">{{name}}</span>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-envelope input-icon"></span>
							<input type="text" v-model="data.email" id="" class="input-control" placeholder="Correo Electrónico" aria-describedby="helpId">
						</div>
						<span class="text-danger" v-if="email">{{email}}</span>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-telephone input-icon"></span>
							<input type="text" v-model="data.phone" id="" class="input-control" placeholder="Teléfono fijo" maxlength="10">
							<span class="text-danger" v-if="phone" >{{phone}}</span>
						</div>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-phone input-icon"></span>
							<input type="text" v-model="data.mobile" id="" class="input-control" placeholder="Telefono mobil"  axlength="10">
						</div>
						<span class="text-danger" v-if="mobile">{{mobile}}</span>
					</div>
					<div class="my-form-group">
						<div class="input-layer">
							<span class="bi bi-geo input-icon"></span>
	                      	<input type="text" v-model="data.address" id="" class="input-control" placeholder="Calle y numero">
						</div>
						<span class="text-danger" v-if="address">{{address}}</span>
                    </div>
                    <div class="my-form-group">
                    	<div class="input-layer">
							<span class="bi bi-map input-icon"></span>
	                      	<input type="text" v-model="data.zone" id="" class="input-control" placeholder="Colonia">
                    	</div>
						<span class="text-danger" v-if="zone">{{zone}}</span>
                    </div>
                    <div class="my-form-group">
                    	<div class="input-layer">
							<span class="bi bi-123 input-icon"></span>
	                      	<input type="text" v-model="data.zip" id="" class="input-control" placeholder="Código Postal">
                    	</div>
						<span class="text-danger" v-if="zip">{{zip}}</span>
                    </div>
                    <div class="my-form-group">
                    	<div class="input-layer">
							<span class="bi bi-credit-card-2-front input-icon"></span>
                      		<input type="text" v-model="data.tax_id" id="" class="input-control" placeholder="RFC" >
                      	</div>
						<span class="text-danger" v-if="tax_id">{{tax_id}}</span>
                    </div>
                    <div class="my-form-group d-flex justify-content-end">
                    	<button type="submit" class="btn my-btn mt-2"><span class="bi bi-upload icon"></span> Guadar</button>
                    </div>
				</form>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card-box-lg">
				<ul>					
					<li>
						<a href=""><span class="bi bi-circle"></span>Lista de Clientes</a>
					</li>
					<li>
						<a href=""><span class="bi bi-circle"></span>	Lista de Provedores</a>
					</li>
					<li>
						<a href=""><span class="bi bi-circle"></span>	Contactos</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>	
</template>
<script>
	export default{
		data(){
			return{
                data:{
				_token:document.querySelector('#csrf').getAttribute('content'),
                },
				/*type:"",
				name:"",
				email:"",
				phone:"",
				mobile:"",
				address:"",
				zone:"",
				zip:"",
				tax_id:"",
				store_id:"",*/
				type:"",
				name:"",
				email:"",
				phone:"",
				mobile:"",
				address:"",
				zone:"",
				zip:"",
				tax_id:"",
				
			}
		},
		methods:{
			add_contact(){
                var me = this;
                axios.post('/contact',me.data)
                .then(function(response){
                	me.type="";
                	me.name="";
                	me.email="";
                	me.phone="";
                	me.mobile="";
                	me.address="";
                	me.zone="";
                	me.zip="";
                	me.tax_id="";
                	me.data = "";
                	var title = "Felicidades";
					var message = "Has creado un contacto";
					toaster(title,message);
                })
                .catch(function(errors){
		         	 if (errors.response.data.errors.type) {
		         	 	me.type = errors.response.data.errors.type[0];
		         	 }else{
		         	 	me.type ="";
		         	 }
		         	 if (errors.response.data.errors.name) {
		         	 	me.name = errors.response.data.errors.name[0];
		         	 }else{
		         	 	me.name = "";
		         	 }
		         	 if (errors.response.data.errors.email) {
		         	 	me.email = errors.response.data.errors.email[0];
		         	 }else{
		         	 	me.email = "";
		         	 }
		         	 if (errors.response.data.errors.phone) {
		         	 	me.phone = errors.response.data.errors.phone[0];
		         	 }else{
		         	 	me.phone = "";
		         	 }
		         	 if (errors.response.data.errors.mobile) {
		         	 	me.mobile = errors.response.data.errors.mobile[0];
		         	 }else{
		         	 	me.mobile = "";
		         	 }
		         	 if (errors.response.data.errors.address) {
		         	 	me.address = errors.response.data.errors.address[0];
		         	 }else{
		         	 	me.address ="";
		         	 }
		         	 if (errors.response.data.errors.zone) {
		         	 	me.zone = errors.response.data.errors.zone[0];
		         	 }else{
		         	 	me.zone ="";
		         	 }
		         	 if (errors.response.data.errors.zip) {
		         	 	me.zip = errors.response.data.errors.zip[0];
		         	 }else{
		         	 	me.zip ="";
		         	 }
		         	 if (errors.response.data.errors.tax_id) {
		         	 	me.tax_id = errors.response.data.errors.tax_id[0];
		         	 }else{
		         	 	me.tax_id ="";
		         	 }
       
                })
			}
		},
		mounted(){
		}
	}
</script>