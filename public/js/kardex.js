const {createApp, ref} = Vue

createApp({
	data(){
		return{
			lista:[],
			existencias:[],
			tipos:[],
			formulario:{},
			errores:{}
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
		agregar_kardex(cliente){
			var me = this;
			var url = '/crear_kardex';
			var data =this.tipos[cliente];
			axios.post(url,{
				'cliente':cliente,
				'tipo':data,
			}).then(function (response){
				if (response.data['exito'] == 1) {
					window.location = '/kardex/'+response.data['slug'];	
				}
			})
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
						me.mostrar();
						me.vaciar_campos();
						showAlert('Reporte generado');
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
			if (window.confirm("¿Realmente quieres borrar esta linea?")) {
				axios.get('/borrar_linea/'+data).then(function (response) {
					me.mostrar_lineas();
				})
			}
		},
	},
	mounted(){
		this.mostrar();

	}
}).mount('#app')