const {createApp, ref} = Vue

createApp({

	data(){
		return{
			datos:{},
			reporte:{},
			diagnostico:{},
			lista:[],
			existencias:[],
			tipos:[],
			formulario:{},
			formularioDefault: {
	            nombre:"",
				marca:"",
				modelo:"",
				serie:"",
				inventario:"",
				falla:"",
        	},
			actualizar_linea:{},
			errores:{},
			destinatario:"",
			kardex_id:"",
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

			imagenes:{},
			refacciones:{},
            id_diagnostico:"",

            //alert
            showAlert:false,
            alertText: "Contenido actualizado",

            imagenGrande: null,
            precio_admin:"",
            entidad:"",
            mensaje:"",
            asunto:"",
            usuario_model:"",
            horario_seleccionado:"",
            error_datos:{},
            imagen_modal:""
		}
	},
	methods:{
		mostrar_general(){
			var id = this.$refs.kardex.innerHTML;
			console.log(id);
			/*var usuario = this.$refs.usuario.innerHTML;
			axios.get('/kardex_general/'+id).then((response)=>{
				this.datos = response.data.data;
				this.usuario = usuario;
				this.error_datos = response.data.errors;
				this.ver_galeria();
			})
			.catch((error) => {
                    console.error('Error cargando los datos:', error);
                    this.error_datos = { fallas: 'Error al cargar los datos' };
            })
            .finally(() => {
            	console.log('solicitud completada');
            });*/
		},
		mostrar_reporte() {
			var id = this.$refs.kardex.innerHTML;
			axios.get('/mostrar_reporte/'+ id).then((response)=>{ //aqui vemos el reporte del vendedor
				
				if (response.data.length > 0) { //comprueba que la consulta trea datos
					this.reporte = response.data;
					this.mostrar_diagnostico(response.data[0].id_detalle);
				}

			})
		},
		mostrar_diagnostico(data){
			if (!data) {
				console.log('no hay data');
			}else{
				var url = "/diagnosticos_mostrar/"+ data;
				axios.get(url).then((response)=>{
					if (response.data.length == 0) {
						this.errores.diagnostico = 1;
					}else{
						this.diagnostico = response.data
						this.mostrar_refacciones(response.data.id_diagnostico);
						this.mostrar_imagenes(response.data.id_diagnostico);
					}
				})
			}
		},
		mostrar_refacciones(data){
			var url = "/ver_refacciones/"+data;
			axios.get(url).then((response)=>{
				if (response.data.status == "error") {
					this.errores.refaccion = 1;
				}else{
					this.refacciones = response.data;
				}
					
			});
		},
		mostrar_imagenes(data){
			var url = "/ver_galeria/"+ data;
			axios.get(url).then((response)=>{
				if (response.data.length > 0) {
					this.imagenes = response.data;
				}else{
					this.errores.imagen = 1;
				}

			})
		},
		mandar_img_modal(data){  //manda la imagen de la miniatura al modal
			this.imagen_modal = data;
		},
		eliminarImagen(data){ //elimina la imagen del diagnostico
			axios.get('/eliminar_img/'+data).then((response)=>{
				if (response.data == 1) {
					$.notify('La imagen se ha eliminado');
				}
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
				var url = '/detalle_kardex';
				this.formulario.kardex = this.$refs.id_kardex.innerHTML;
				axios.post(url,this.formulario).then((response)=>{
					if (response.data == 1) {
						$('#equipos').modal('hide');
						$.notify('Reporte agregado');
						// Limpiar formulario
			            this.formulario.nombre = "";
			            this.formulario = {
			                nombre: '',
			                marca: '',  // Asegúrate de incluir todos los campos del formulario aquí
			                modelo: '',
			                serie: '',
			                inventario: '',
			                falla: '',
			            };
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
				var data = {
					'diagnostico': this.diagnostico,
					'reparacion': this.reparacion,
					'tiempo_entrega':this.tiempo_estimado,
					'precio_estimado':this.precio_estimado,		
					'id_detalle': this.id_detalle,
					'clase':clase,
					'kardex':this.$refs.id_kardex.innerHTML
				};
				axios.post(url,data,{
					headers:{
						'Content-Type': 'application/json'
					}
					
				}).then((response)=>{
					if (response.data.flag == 1) {
						$('#diagnostico').modal('hide');
						this.mostrar_general();
						this.vaciar_campos_diagnostico();
						$.notify(response.data.message);
					}else{
						$.notify(response.data.message);
					};
				})
			}else if(clase == 2){
				var data = {
					'diagnostico': this.diagnostico,
					'reparacion': this.reparacion,
					'tiempo_entrega':this.tiempo_estimado,
					'precio_estimado':this.precio_estimado,		
					'id_detalle': this.id_detalle,
					'slug':this.id_slug
				};
				axios.post(url2,data,{
					headers:{
						'Content-Type':'application/json'
					}
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
					if (response.data.flag==1) {
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
			if (!data) {
				console.log('no hay data');
			}else{
				var url = '/borrar_linea/'+data;
				if (window.confirm("¿Realmente quieres borrar esta linea?")) {
					axios.get(url).then((response)=>{
						if (response.data.flag == 1) {
							$.notify('El reporta ha sido borrado');
							this.mostrar_reporte();
						}	
					})
				}
			}
		},
		enviar() {
			var url = '/enviar_kardex';
			axios.post(url,{
				'destinatario':this.usuario_model,
				'kardex':this.$refs.id_kardex.innerHTML,
				'horario_seleccionado':this.horario_seleccionado,
				'dia':this.dia,
				'hora':this.hora
			}).then((response)=>{
				if (response.data.status == 'success') {
					$('#enviar_cardex').modal('hide');
					$.notify('Se envió el Kardex correctamente');
					setTimeout(function(){document.location.href = "/inicio"},1000);
				}
			})
		},
		aceptar_tarea(kardex){
			if (confirm('¿Deseas aceptar esta tarea?')==true) {
				// Configurar los datos y headers
		        const data = {
		            kardex: kardex,
		            accion: 1,
		            razon: 'aceptado'
		        };
				var url = "/kardex_accion";
				axios.post(url,data,{
					headers:{
						'Content-Type':'application/json',
						'Accept': 'application/json'
					}
				}).then((response)=>{
					if (response.data.success == true) {
						$.notify('Usted ha aceptado la orden de servicio')
						setTimeout(function(){document.location.href = "/inicio"},100);
					}
				})
			}
		},
		rechazar_tarea_modal(kardex){
			this.kardex = kardex;
			$('#rechazar_tarea').modal('show');
		},
		rechazar_tarea(){
			var url = '/kardex_accion';
			axios.post(url,{
				'kardex':this.kardex,
				'accion':2,
				'razon':this.razon,
			}).then((response)=>{
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
		regresar_vendedor(){
			var id = this.$refs.id_kardex.innerHTML;
			axios.post('/regresar_vendedor',{
				'id':id,
				'mensaje':this.mensaje,
				'asunto':this.asunto
			}).then((response)=>{
				if (response.data.status == 'success') {
					$('#regresar_cardex').modal('hide');
					$.notify('Se regresó el Kardex al vendedor');
					setTimeout(function(){document.location.href="/inicio"},1000);
				}else{
					console('no se realizo la acción');
				}
			})

		},
		regresar(data){
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
					this.mostrar_reporte();
					$.notify('Registro actualizado');
				}
			})
		},
		actualizar(detalle){
			var url = '/actualizar_detalle/'+ detalle;
			axios.get(url).then((response)=>{
				this.actualizar_linea = response.data;
			})
		},
		si_ingeniero(usuario){
			var url = '/si_ingeniero/'+ usuario;
			axios.get(url).then((response)=>{
				if (response.data ==  1) {
					this.ingeniero = 1;
				}else{
					this.ingeniero = 0;
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
			this.diagnostico_slug = data; //este es el id del diagnostico: id_diagnostico
		},
		subir_imagen(){
			alert('si esta bien');
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
					}, 1000);
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
            	if (response.data.status === 'success') {
            		$.notify('Refacciones agregadas');
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
	    cotizar(){
        	var id = this.$refs.id_kardex.innerHTML;
	    	const url = '/nueva_cotizacion';
		    if (confirm('¿Deseas enviar este kardex a cotización?')) {
		        axios.post(url, { 
		        	'id':id,
		        	'entidad':this.entidad,
		        })
		            .then((response) => {
		                if (response.data.estado === 1) {
		                    $.notify(response.data.mensaje);

		                    setTimeout(() => {
		                        $.notify('En breve serás redirigido a la cotización');
		                    }, 1000);

		                    setTimeout(() => {
		                        window.location.href = `/pagina_cotizador/${response.data.slug}`;
		                    }, 1000);
		                } else {
		                    $.notify(response.data.mensaje || 'Error inesperado');
		                }
		            })
		            .catch((error) => {
		                console.error(error);
		                $.notify('Error al procesar la solicitud');
		            });
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
		//this.mostrar_general();
		this.mostrar_reporte();
	}
}).mount('#app')