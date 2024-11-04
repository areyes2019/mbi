const {createApp, ref} = Vue

createApp({

	data(){
		return{
			datos:{},
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
			reparacion:"",
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

			imagenes:[],
			refacciones:[
                { nombre: '', marca: '', modelo: '', costo: '',id:''} // Fila inicial
            ],
            id_diagnostico:"",

            //alert
            showAlert:false,
            alertText: "Contenido actualizado",

            imagenGrande: null,
		}
	},
	methods:{
		mostrar_general(){
			var id = this.$refs.kardex_id.innerHTML;
			axios.get('/kardex_general/'+id).then((response)=>{
				this.datos = response.data;
				console.log(response.data);
			})
		},
		formatearFecha(fechaString) {
	      const date = new Date(fechaString);
	      return date.toLocaleDateString("es-ES", {
	        weekday: "long",
	        day: "numeric",
	        month: "long",
	        year: "numeric"
	      });
	    },
	    formatearHora(horaString) {
	      const time = new Date(`1970-01-01T${horaString}`);
	      return time.toLocaleTimeString("es-ES", {
	        hour: "numeric",
	        minute: "2-digit",
	        hour12:true
	      });
	    },
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
		insertar(){
			if (this.validar()) {
				var me = this;
				var url = '/detalle_kardex';
				this.formulario.kardex = this.$refs.id_kardex.innerHTML;
				axios.post(url,this.formulario).then((response)=>{
					if (response.data == 1) {
						$('#equipos').modal('hide');
						$.notify('Reporte agregado');
						this.mostrar_general();
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
				this.vaciar_campos()
				var me = this;
				var url = '/modificar_diagnostico/'+ data;
				axios.get(url).then((response)=>{
					this.diagnostico = response.data[0].diagnostico;
					this.reparacion = response.data[0].reparacion;
					this.tiempo_estimado = response.data[0].tiempo_entrega;
					this.precio_estimado = response.data[0].precio_estimado;
					this.modal_text = "Actualizar diagnostico";
					this.id_slug = response.data[0].id_detalle_kardex;
					this.clase = 2;
				})
			}
		},
		generar_diagnostico(clase){
			var url = '/agregar_diagnostico';
			var url2 = '/actualizacion_diagnostico';

			if (clase == 1) {
				axios.post(url,{
					'diagnostico': this.diagnostico,
					'reparacion': this.reparacion,
					'tiempo_entrega':this.tiempo_estimado,
					'precio_estimado':this.precio_estimado,		
					'id_detalle': this.id_detalle,
					'clase':clase
				}).then((response)=>{
					$('#diagnostico').modal('hide');
					this.vaciar_campos_diagnostico();
					this.mostrar_general();
					$.notify("Diagnóstico agregado");
				})
			}else if(clase == 2){
				axios.post(url2,{
					'diagnostico': this.diagnostico,
					'reparacion': this.reparacion,
					'tiempo_entrega':this.tiempo_estimado,
					'precio_estimado':this.precio_estimado,		
					'slug': this.id_slug,
				}).then((response)=>{
					if (response.data == 1) {
						$('#diagnostico').modal('hide');
						this.mostrar_general();
						this.vaciar_campos_diagnostico();
						$.notify("Diagnóstico actualizado",'info');
					}
				})
			}
		},
		vaciar_campos_diagnostico(){
			this.diagnostico = "";
			this.reparacion = "";
			this.tiempo_estimado = "";
			this.precio_estimado = "";
			this.id_detalle = "";
		},
		borrar_diagnostico(data){
			var url = '/eliminar_diagnostico/'+data;
			if (confirm('¿Deseas eliminar este diagnóstico?')) {
				axios.get(url).then((response)=>{
					if (response.data == 1) {
						this.mostrar_general();
						this.vaciar_campos_diagnostico();
						$.notify("Diagnóstico eliminado");
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
				axios.get(url).then((response)=>{
					if (response.data == 1) {
						$.notify('El reporta ha sido borrado');
						this.mostrar_general();
						this.vaciar_campos();
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
				'slug':me.$refs.kardex_id.innerHTML,
				'kardex':me.$refs.id_kardex.innerHTML,
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
			axios.post(url,this.actualizar_linea).then((response)=>{
				if (response.data == 1) {
					$('#equipos_actualizar').modal('hide');
					this.mostrar_general();
					$.notify('Registro actualizado');
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
			}).then((response)=>{
				$('#agregar_imagen').modal('hide');
				$.notify('Imagen agregada con exito');
				this.mostrar_general();
			})
		},
		ver_galeria(data){
			var me = this;
			var url = "/ver_galeria/"+data;
			axios.get(url).then(function (response){
				me.imagenes = response.data;
			})
		},
		liberar(kardex){
			//alert('saludo');
			var me = this;
			var url = '/liberar_diagnostico/'+ kardex ;
			if (confirm('Vas a liberar este diagnostico, ¿Estas seguro?')) {}
			axios.get(url).then(function (response){
				if (response.data == 1) {
					$.notify('Este cardex ha sido liberado')
					setTimeout(function() {
					    window.location.href = '/inicio';
					}, 3000);
				}
			})
		},
		agregarFila() {
            // Agregar una nueva fila con campos vacíos
            this.refacciones.push({ nombre: '', marca: '', modelo: '', costo: '' });
        },
        eliminarFila(index) {
            // Eliminar la fila en el índice especificado
            this.refacciones.splice(index, 1);
        },
        submitForm() {
            axios.post('/agregar_refacciones',{
            	'id_diagnostico':this.id_diagnostico,
            	'refacciones':this.refacciones,

            }).then((response)=>{
            	if (response.data == 1) {
            		$('#agregar_refacciones').modal('hide');
            		this.refacciones = [{ nombre: '', marca: '', modelo: '', costo: '' }];
            		this.mostrar_general();
            	}
            })
        },
        borrar_refaccion(data){
        	var url = '/borrar_refaccion/'+data;
        	if (confirm('¿Realmente deseas eliminar este registro?')==true) {	
	        	axios.get(url).then((response)=>{
	        		if (response.data == 1) {
	        			$.notify('Registro eliminado');
	        			this.mostrar_general();
	        		}
	        	})
        	}
        },
        abrir_modal_refacciones(id){
        	this.id_diagnostico = id;
        },
        a_cotizacion(data) {
        	var url = '/nueva_cotizacion';
        	if (confirm('¿Deseas enviar este kardex a cotizacion?') == true) {
		      	axios.post(url,{
		      		'id':data
		      	}).then((response)=>{
		      		if (response.data.hecho == 1) {
		      			$.notify('Se ha generado un folio de cotizacion')
		      			setTimeout(function() {
		      				$.notify('En breve seras redirigido a la cotizacion');
						}, 1000);

						setTimeout(function(){
							window.location.href = '/pagina_cotizador/'+ response.data.slug +'/'+response.data.id;
						},2000);
		      		}
		      	})

        	}
	    },
	    mostrarImagenGrande(imagen) {
      		this.imagenGrande = imagen;
    	},
    	cerrarImagenGrande() {
      		this.imagenGrande = null;
    	},

	},
	mounted(){
		this.mostrar_general();
	}
}).mount('#app')