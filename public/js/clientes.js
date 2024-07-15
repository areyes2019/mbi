const {createApp,ref} = Vue
	createApp({
		data(){
			return{
				form:{},
				errores:{},
				picked:"",
				display:"d-none",
				display_form:"d-none",
				display_form_one:""
			}
		},
		methods:{
			validar_form(){
				this.errores = {};
		      	if (!this.form.empresa) {
			        this.errores.empresa = 'El nombre de la empesa es obligatorio';
		      	}
		      	if (!this.form.contacto) {
			        this.errores.contacto = 'Debes asigna un nombre de contacto';
		      	}
		      	if (!this.form.correo) {
			        this.errores.correo = 'Debes asignar una correo';
		      	}else if (!this.validar_correo(this.form.correo)) {
			        this.errores.correo = 'El email no es válido, verifica la ortografía';
			    }
			    //aqui va el numero interior y exterior pero no es obligatorio
		      	if (!this.form.fijo) {
			        this.errores.fijo = 'Debes poner un numero fijo';
		      	}else if (!this.validar_telefono(this.form.fijo)) {
			        this.errores.fijo = 'Debes poner solo números';
		      	}
		      	if (!this.form.movil) {
			        this.errores.movil = 'Debes asignar un numero móvil';
		      	}else if (!this.validar_movil(this.form.movil)) {
			        this.errores.movil = 'Debes poner solo números';
		      	}
		      	if (!this.form.calle) {
			        this.errores.calle = 'El correo es obligatorio';
		      	}
		      	if (!this.form.ciudad) {
			        this.errores.ciudad = 'El correo es obligatorio';
		      	}
		      	if (!this.form.estado) {
			        this.errores.estado = 'El correo es obligatorio';
		      	}
		      	
			    return Object.keys(this.errores).length === 0;
			},
			validar_correo(correo){
				const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\.,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,})$/i;
      			return re.test(correo);
			},
			validar_telefono(fijo){
				const re = /^[0-9]+$/;
				return re.test(fijo);
			},
			validar_movil(movil){
				const re = /^[0-9]+$/;
				return re.test(movil);
			},
			enviar_form(){
				var me  = this;
				var url = "nuevo_cliente";
				if (this.validar_form()) {
			    	axios.post(url,this.form).then(function (response){
			    	})
			    }
			},
			modal_fiscal(){
			   $('#datos').modal('show');

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

		}
}).mount('#app')