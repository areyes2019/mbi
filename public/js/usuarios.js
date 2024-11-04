const {createApp, ref} = Vue

createApp({
	data(){
		return{
			existencias:[],
			form:{},
			errores:{},
			rol:"",
			roles:[],
		}
	},
	methods:{
		mostrar(){
			var me = this;
			var url = "/ver_roles";
			axios.get(url).then(function (response){
				me.roles = response.data;
			})
		},
		validar_form(){
			this.errores = {};
			const regex = /^(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
	      	if (!this.form.nombre) {
		        this.errores.nombre = 'El nombre del usuario es obligatorio'; //nombre del encargado o DR
	      	}
	      	if (!this.form.apellidos) {
		        this.errores.apellidos = 'Los appellidos son obligatorios'; //nombre del encargado o DR
	      	}

	      	if (!this.form.correo) {
		        this.errores.correo = 'El correo del usuario es obligatorio';  //nombre del contacto
	      	}else if (this.form.correo) {
	      		if (!this.validar_correo(this.form.correo)) {
	      			this.errores.correo = "Formato de correo iválido";
	      		}
	      	}

	      	if (!regex.test(this.form.password)) {
	      		this.errores.pass = "La contraseña debe tener por lo menos 8 caracteres y contar con un caracter especial";
	      	}

	      	if (this.form.password !== this.form.password_confirm) {
	      		this.errores.pass = "Las contraseñas no coinciden";
	      	}

	      	
		    return Object.keys(this.errores).length === 0;
		},
		limpiar_error(event,campo){
			this.texto = event.target.value;
			if (campo =='nombre') {
				this.errores.nombre = "";
			}else if (campo=='correo') {
				this.errores.correo = "";
			}else if (campo=='pass01') {
				this.errores.pass01 = "";
			}else if (campo=='pass02') {
				this.errores.pass02 = "";
			}else if (campo == 'apellidos') {
				this.errores.apellidos = "";
			}
		},
		validar_correo(correo){
			const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\.,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,})$/i;
  			return re.test(correo);
		},
		insertar(){
			var me = this;
			var url = "/nuevo_usuario";
			if (this.validar_form()) {
				axios.post(url,this.form).then(function (response){
					if (response.data == 1) {
						location.reload();
					}
				})
			}   
		},
		modificar(data){
			var me = this;
			var url = "/editar_ajax";
			axios.post(url,this.formulario,{
				"id":data
			}).then(function (response){

			})

		},

		borrar_linea(data){
			var me = this;
			if (window.confirm("¿Realmente quieres borrar esta linea?")) {
				axios.get('/borrar_linea/'+data).then(function (response) {
					me.mostrar_lineas();
				})
			}
		},
		limpiar_form(){
			this.form.nombre = "";
			this.form.correo = "";
			this.form.password = "";
			this.form.password_confirm = "";
		},
		agregar_rol(){
			var me = this;
			var url = "/agregar_rol";
			axios.post(url,{
				'nombre':me.rol
			}).then(function (response){
				if (response.data == 1) {
					me.rol = "";
					me.mostrar();
				}
			})
		},
		eliminar_rol(id){
			var me = this;
			var url = "/eliminar_rol/"+id;
			var msg = "¿Deseas eiminar este Rol?, afectaras los permisos de todos los usuarios"
			if (confirm(msg)==true) {
				axios.get(url).then(function (response){
					if (response.data == 1) {
						showAlert('Rol eliminado');
						me.mostrar();
					}
				})
			}
		},
		
	},
	mounted(){
		this.mostrar();
	}
}).mount('#app')