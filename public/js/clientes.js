const {createApp,ref} = Vue
	createApp({
		data(){
			return{
				form:{},
				editar:[],
				errores:{},
				picked:"",
				display:"d-none",
				display_form:"d-none",
				display_form_one:"",
				texto:"",

			}
		},
		methods:{
			validar_form(){
				this.errores = {};
		      	if (!this.form.titular) {
			        this.errores.titular = 'El nombre del encargado es obligatorio'; //nombre del encargado o DR
		      	}

		      	if (!this.form.responsable) {
			        this.errores.responsable = 'El nombre de contacto es obligatorio';  //nombre del contacto
		      	}

		      	if (this.form.telefono) {
		      		if (!this.validar_numero(this.form.telefono)) {   // verifica si es numero
			        	this.errores.telefono = 'Debes poner solo números';
		      		}else if(!this.validar_long(this.form.telefono)){
		      			this.errores.telefono = "El campo solo amite 10 digitos";
		      		}

		      	}

		      	if (this.form.extencion) {
			      	if (!this.validar_numero(this.form.extencion)) {
				        this.errores.extencion = 'Solo número'; //extencion
			      	}

		      	}


		      	if (!this.form.movil) {
			        this.errores.movil = 'Debes asignar un numero móvil';
		      	}else if (!this.validar_numero(this.form.movil)) {
			        this.errores.movil = 'Debes poner solo números';
		      	}

		      	if (this.form.correo) {
		      		if (!this.validar_correo(this.form.correo)) {
		      			this.errores.correo = "Formato de correo iválido";
		      		}
		      	}

		  
		      	
			    return Object.keys(this.errores).length === 0;
			},
			limpiar_error(event,campo){
				this.texto = event.target.value;
				if (campo =='titular') {
					this.errores.titular = "";
				}else if (campo=='responsable') {
					this.errores.responsable = "";
				}else if (campo=='telefono') {
					this.errores.telefono = "";
				}else if (campo=='extencion') {
					this.errores.extencion = "";
				}else if (campo == 'movil') {
					this.errores.movil = "";
				}
			},
			validar_correo(correo){
				const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\.,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,})$/i;
      			return re.test(correo);
			},
			validar_numero(data){
				const re = /^[0-9]*$/;
				return re.test(data);
			},
			validar_long(num){

				if (num.length > 10) {
					return false;
					//this.errores.long = "El campo solo adminte 10 digitos";					
				}else{
					return true;
				}
			},
			validar_movil(movil){
				const re = /^[0-9]*$/;
				return re.test(movil);
			},
			enviar_form(){
				var me  = this;
				var url = "/nuevo_cliente";
				if (this.validar_form()) {
			    	axios.post(url,{
			    		'titular':me.form.titular,
			    		'responsable':me.form.responsable,
			    		'telefono':me.form.telefono,
			    		'extencion':me.form.extencion,
			    		'movil':me.form.movil,
			    		'direccion':me.form.direccion,
			    		'ubicacion':me.form.ubicacion,
			    		'laboratorio':me.form.laboratorio,
			    		'piso':me.form.piso,
			    		'correo':me.form.correo,
			    	}).then(function (response){
			    		if (response.data == 1) {
			    			var msg = "Cliente guardado correctamente";
			    			showAlert(msg);
			    			me.form.titular = "";
			    			me.form.responsable = "";
			    			me.form.telefono = "";
			    			me.form.extencion = "";
			    			me.form.movil = "";
			    			me.form.correo = "";
			    			me.form.direccion = "";
			    			me.form.ubicacion = "";
			    			me.form.laboratorio = "";
			    			me.form.piso = "";
			    		}
			    	})
			    }
			},
			editar_cliente(){
				var id = this.$refs.cliente.innerHTML;
				var url = "/mostrar_cliente/"+ id;
				var me = this;
				axios.get(url).then(function (response){
					me.editar = response.data;
				})
			},
			actualizar_cliente(){
				var me = this;
				var url = "/actualizar_cliente";
				//console.log(this.editar);
				axios.post(url,this.editar).then(function (response){
					if (response.data === 1) {
			    		window.location.href = "/clientes";
					}
				})
			},
			modal_fiscal(){
			   
			},
			direccion_fiscal(){
				if (this.picked == 2) {
					this.display = "";
				}else{
					this.display = "d-none"
				}
			},
			agregar_direccion_fiscal(){

			   	$('#datos').modal('hide');
				this.display_form = "";
				this.display_form_one = "d-none"

			}

		},
		mounted(){
			this.editar_cliente();
		}
}).mount('#app')