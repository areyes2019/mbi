const {createApp,ref} = Vue
	createApp({
		data(){
			return{
				form:{
					nombre:"",
					apellidos:"",
					correo:"",
					password:"",
					password_confirmada:"",
				},
				data:[],
				msg:"",
				errores:{},
				usuario:"",
				password:"",

			}
		},
		methods:{
			entrar(){
				var me = this;
				var url = '/validar_entrada';
				axios.post('ruta',{
					'usuario':usuario,
					'password':password,
				}).then(function (response){
					if (response.data == true) {
						console.log('si hay entrada');
					}else if(response.data == false){
						console.log('Datos incorrectos');
					}
				})
			},

			validar_form(){
				this.errores = {};
		      	if (!this.form.nombre) {
			        this.errores.nombre = 'El nombre es obligatorio';
		      	}
		      		if (!this.form.apellidos) {
			        this.errores.apellidos = 'Los apellidos son obligatorio';
		      	}
		      	if (!this.form.correo) {
			        this.errores.correo = 'El correo es obligatorio';
		      	} else if (!this.validar_correo(this.form.correo)) {
			        this.errores.correo = 'El email no es válido. Verifica la ortografía';
		      	}
		      	if (!this.form.password) {
			        this.errores.password = 'La contraseña es obligatoria';
			    } else if (this.form.password.length < 8) {
			        this.errores.password = 'La contraseña debe tener al menos 8 caracteres';
			    }
			    if (!this.form.password_confirmada) {
			        this.errores.password_confirmada = 'La confirmación de la contraseña es obligatoria';
			    } else if (this.form.password !== this.form.password_confirmada) {
			        this.errores.password_confirmada = 'Las contraseñas no coinciden';
			    }
			    return Object.keys(this.errores).length === 0;
			},
			enviar_form(){
				var me  = this;
				var url = "nueva_cuenta";
				if (this.validar_form()) {
			    	axios.post(url,{
			    		'nombre':me.form.nombre,
			    		'apellidos':me.form.apellidos,
			    		'correo':me.form.correo,
			    		'password':me.form.password_confirmada
			    	}).then(function (response){
			    		if (response.data.status == 1) {
			    			me.form ="";
			    			$.notify('Se creo la cuenta correctamente');
			    			setTimeout(function(){
			    				window.location = "/";
			    			},2000);
			    		}
			    	})
			    }
			},
			validar_correo(correo){
				const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\.,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,})$/i;
      			return re.test(correo);
			}

		},
		mounted(){

		}
}).mount('#app')