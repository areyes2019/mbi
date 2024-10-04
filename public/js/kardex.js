const {createApp, ref} = Vue

createApp({
	data(){
		return{
			lista:[],
			existencias:[],
			tipos:[],
			formulario:{},
			actualizar_linea:{},
			errores:{},
			destinatario:"",
			kardex_id:"",
			usuario:"defecto",
			asunto:"",
			kardex_data:[],
			id_kardex:"",
			razon:"",
			ingeniero: 0,
			dia:"",
			hora:"",
			kardex:"",
			razon:"",

			//formulario agregar diagnostico
			diagnostico:"",
			refacciones:"",
			tiempo_estimado:"",
			precio_estimado:"",

			//subir imagenes
			imagen:"",
			imageUrl:"",
			archivo_permitido:"d-none",

			id_detalle:"",
			clase:1,
			modal_text:"",
			id_slug:"",
			diagnostico_slug:"",

			imagenes:[]
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
			var id = this.$refs.kardex_id.innerHTML;
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
				this.formulario.kardex = this.$refs.kardex_id.innerHTML;
				axios.post(url,this.formulario).then(function (response){
					if (response.data == 1) {
						location.reload();
					}
				})
			}    
		},
		modal_diagnostico(data,tipo){
			if (tipo == 1) {
				//crear
				this.id_detalle = data;

			}else if(tipo == 2){
				//actualizar
				var me = this;
				var url = '/modificar_diagnostico/'+ data;
				axios.get(url).then(function (response){
					me.diagnostico = response.data[0].diagnostico;
					me.refacciones = response.data[0].refacciones;
					me.tiempo_estimado = response.data[0].tiempo_entrega;
					me.precio_estimado = response.data[0].precio_estimado;
					me.modal_text = "Actualizar diagnostico";
					me.id_slug = response.data[0].id_detalle_kardex;
					me.clase = 2;
				})
			}
		},
		generar_diagnostico(clase){
			var me = this;
			var url = '/agregar_diagnostico';
			var url2 = '/actualizacion_diagnostico';

			if (clase == 1) {
				axios.post(url,{
					'diagnostico': me.diagnostico,
					'refacciones': me.refacciones,
					'tiempo_entrega':me.tiempo_estimado,
					'precio_estimado':me.precio_estimado,		
					'id_detalle': me.id_detalle,
					'clase':clase
				}).then(function (response){
					location.reload();
				})
			}else if(clase == 2){
				axios.post(url2,{
					'diagnostico': me.diagnostico,
					'refacciones': me.refacciones,
					'tiempo_entrega':me.tiempo_estimado,
					'precio_estimado':me.precio_estimado,		
					'slug': me.id_slug,
				}).then(function (response){
					if (response.data == 1) {
						location.reload();
					}
				})
			}
		},
		borrar_diagnostico(data){
			var me = this;
			var url = '/eliminar_diagnostico/'+data;
			if (confirm('¿Deseas eliminar este diagnóstico?')) {
				axios.get(url).then(function (response){
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
				'slug':me.$refs.kardex.innerHTML,
				'kardex':me.$refs.kardex_id.innerHTML,
				'asunto':me.asunto,
				'dia':me.dia,
				'hora':me.hora
			}).then(function (response){
				if (response.data == 11) {
					//window.location.href = '/inicio/';
					//window.location.assign("/inicio")
					setTimeout(function(){document.location.href = "/inicio"},500);
				}
			})
		},
		aceptar_tarea(kardex){
			if (confirm('¿Deseas aceptar esta tarea?')==true) {
				var me = this;
				var url = "/kardex_accion";
				axios.post(url,{
					'kardex':kardex,
					'accion':1
				}).then(function (response){
					if (response.data == 1) {
						setTimeout(function(){document.location.href = "/inicio"},500);
					}
				})
			}
		},
		rechazar_tarea_modal(kardex){
			this.kardex = kardex;
			$('#rechazar_tarea').modal('show');
		},
		rechazar_tarea(){
			var me = this;
			var url = '/kardex_accion';
			axios.post(url,{
				'kardex':me.kardex,
				'accion':2,
				'razon':me.razon,
			}).then(function (response){
				if (response.data == 1) {
					setTimeout(function(){document.location.href = "/inicio"},500);

				}
			})
		},
		horarios(id_horario, event){
			if (event.target.checked) {
				this.horario = id_horario;
			}
		},
		regresar_kardex(data){
			this.id_kardex = data;
			$('#regresar').modal('show');
		},
		regresar(){
			var me = this;
			var url = '/regresar_kardex';
			axios.post(url,{
				'razon':me.razon,
				'kardex':me.id_kardex,
			}).then(function (response){
				if (response.data == 1) {
					$('#regresar').modal('hide');
					window.location.href='/inicio';
				}
			})
		},
		actualizar_detalle(id){
			var me = this;
			var url = "/actualizar_final/"+id;
			axios.post(url,this.actualizar_linea).then(function (response){
				if (response.data == 1) {
					$('#equipos_actualizar').modal('hide');
					me.mostrar();
				}
			})
		},
		actualizar(detalle){
			var me  = this;
			var url = '/actualizar_detalle/'+ detalle;
			axios.get(url).then(function (response){
				me.actualizar_linea = response.data[0];
			})
		},
		si_ingeniero(usuario){
			var me  = this;
			var url = '/si_ingeniero/'+ usuario;
			axios.get(url).then(function (response){
				if (response.data ==  1) {
					me.ingeniero = 1;
				}else{
					me.ingeniero = 0;
				}
			})
		},
		archivo(e) {
	        var archivo = this.imagen = e.target.files[0];
	        var permitidos = ['image/jpeg','image/png','image/jpg'];
	        console.log(archivo);
	        if (!permitidos.includes(archivo.type) || archivo.size > 3774111){
	        	alert('Tipo de archivo no permitido o tamaño de archivo muy grande ');
	        	return;
	        }else{
	        	this.archivo_permitido = 'd-block';
	        }
		},
		guardar_imgen_diangostico(data){
			this.diagnostico_slug = data;
		},
		subir_imagen(){
			const formData = new FormData();
			formData.append('imagen',this.imagen);
			formData.append('slug',this.diagnostico_slug);
			var url = '/subir_imagen';
			axios.post(url,formData,{
				headers:{
					'Content-Type':'multipart/form-data'
				}
			}).then(function (response){
				location.reload();
			})
		},
		ver_galeria(data){
			var me = this;
			var url = "/ver_galeria/"+data;
			axios.get(url).then(function (response){
				me.imagenes = response.data;
			})
		}

	},
	mounted(){
		this.mostrar();

	}
}).mount('#app')