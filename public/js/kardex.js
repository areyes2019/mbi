const {createApp, ref} = Vue

createApp({
	data(){
		return{
			lista:[],
			existencias:[],
			tipos:[],
			formulario:{},
			errores:{},
			destinatario:"",
			kardex_id:"",
			usuario:"defecto",
			asunto:"",
			kardex_data:[]
		}
	},
	methods:{
		validar(){
			this.errores = {};
			if (!this.formulario.nombre) {
				this.errores.nombre = "El nombre del equipo es obligatorio";
			}
			if (!this.formulario.marca) {
				this.errores.marca = "Debes agregar una marca";
			}
			if (!this.formulario.modelo) {
				this.errores.modelo = "Debes agregar un modelo";
			}
			if (!this.formulario.serie) {
				this.errores.serie = "El número de serie es obligatorio";
			}
			if (!this.formulario.inventario) {
				this.errores.inventario = "Inventario obligatorio";
			}
			if (!this.formulario.falla) {
				this.errores.falla = "Describe brevemente una falla";
			}
			return Object.keys(this.errores).length === 0;
		},
		limpiar_error(event,campo){
				this.texto = event.target.value;
				if (campo =='nombre') {
					this.errores.nombre = "";
				}else if (campo=='marca') {
					this.errores.marca = "";
				}else if (campo=='modelo') {
					this.errores.modelo = "";
				}else if (campo=='serie') {
					this.errores.serie = "";
				}else if (campo == 'inventario') {
					this.errores.inventario = "";
				}else if (campo == 'falla') {
					this.errores.falla = "";
				}
			},
		mostrar(){
			var me = this;
			var id = this.$refs.kardex.innerHTML;
			var url = '/mostrar_kardex/'+id;
			axios.get(url)
			.then(response => {
				me.lista = response.data;
			})
			.catch(error => {
				console.error(error);
			});
		},
		insertar(){
			if (this.validar()) {
				var me = this;
				var url = '/detalle_kardex';
				this.formulario.kardex = this.$refs.kardex.innerHTML;
				axios.post(url,this.formulario).then(function (response){
					if (response.data == 1) {
						location.reload();
					}
				})
			}    
		},
		vaciar_campos(){
			this.formulario.nombre = "";
			this.formulario.marca = "";
			this.formulario.modelo = "";
			this.formulario.serie = "";
			this.formulario.inventario = "";
			this.formulario.falla = "";
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
			var url = '/borrar_linea/'+data;
			if (window.confirm("¿Realmente quieres borrar esta linea?")) {
				axios.get(url).then(function (response) {
					if (response.data == 1) {
						me.mostrar();
						location.reload();
					}
				})
			}
		},
		enviar() {
			//alert('hola');
			var me = this;
			var url = '/enviar_kardex';
			axios.post(url,{
				'destinatario':me.usuario,
				'kardex':me.$refs.kardex.innerHTML,
				'asunto':me.asunto
			}).then(function (response){
				if (response.data == 1) {
					window.location.href = '/mi_tablero/';
				}
			})
		},

	},
	mounted(){
		this.mostrar();

	}
}).mount('#app')