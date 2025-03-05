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
            precio_admin:"",
            entidad:"",
            horario:{}
		}
	},
	methods:{
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
		insertar(){ //inserta nuevo detalles en el reporte de falla
			if (this.validar()) {
				var me = this;
				var url = '/detalle_kardex';
				this.formulario.kardex = this.$refs.kardex_id.innerHTML;
				axios.post(url,this.formulario).then((response)=>{
					if (response.data == 1) {
						$('#equipos').modal('hide');
						$.notify('Reporte agregado');
						location.reload();
					}
				})
			}    
		},
		editar_diagnostico(data){
			var url = '/modificar_diagnostico/'+ data
			
			if (!data) {
				console.log('no estan llegando los datos');
			}

			axios.get(url).then((response)=>{
				this.formulario = response.data[0];
			});
		},
		actualizar_diagnostico(){
			var url = '/actualizacion_diagnostico';
			var data = this.formulario;
			axios.post(url,data,{
				headers:{
					'Content-Type':'application/json'
				}
			}).then((response)=>{
				if (response.data.flag = 1) {
					location.reload();
				}
			})
		},
		generar_diagnostico(id){
			var url = '/agregar_diagnostico';
			const data = {
				'id_diagnostico': this.$refs.ref_detalle.innerHTML,
				'diagnostico': this.diagnostico,
				'reparacion': this.reparacion,
				'tiempo_entrega':this.tiempo_estimado,
				'precio_estimado':this.precio_estimado,		
			};
			axios.post(url,data,{
				headers: {
		        	'Content-Type': 'application/json'
		        }
			}).then((response)=>{
				if (response.data.flag == 1) {}
				$('#diagnostico').modal('hide');
				this.vaciar_campos_diagnostico();
				$.notify("Diagnóstico agregado");
				setTimeout(function() {
					location.reload();
				}, 1000);
			})
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
					if (response.data.success == true) {
						this.vaciar_campos_diagnostico();
						$.notify("Diagnóstico eliminado");
						setTimeout(function() {
							location.reload();
						}, 1000);
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

		borrar_linea(data){ //borra el detalle del reporte
			var me = this;
			var url = '/borrar_linea/'+data;
			if (window.confirm("¿Realmente quieres borrar este reporte?")) {
				axios.get(url).then((response)=>{
					if (response.data.flag == 1) {
						$.notify('El reporta ha sido borrado');
						setTimeout(function() {
							location.reload();
						}, 2000);
					}	
				})
			}
		},
		enviar(data) {
			var url = '/enviar_kardex';
			axios.post(url,{
				'destinatario':this.usuario,
				'kardex':data,
				'dia':this.dia,
				'hora':this.hora
			}).then((response)=>{
				if (response.data.flag == 1) {
					$.notify('Se ha enviado el kardex')
					window.location.href = '/inicio/';
				}
			})
		},
		aceptar_tarea(kardex){
			if (confirm('¿Deseas aceptar esta tarea?')==true) {
				var url = "/aceptar_tarea/"+kardex;
				axios.get(url).then((response)=>{
					if (response.data.flag == 1) {
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
			var id = this.$refs.kardex_id.innerHTML;
			var url = '/rechazar_tarea';
			if (confirm('Deseas rechazar esta tarea?')==true) {
				
				axios.post(url,{
					'kardex':id,
					'razon':this.razon,
				}).then((response)=>{
					if (response.data.flag == 1) {
						$.notify('Usted ha rechazado la tarea')
						setTimeout(function(){document.location.href = "/inicio"},500);

					}
				})
			}
		},
		horarios(id_horario, event){
			if (event.target.checked) {
				this.horario = id_horario;
			}
		},
		regresar_kardex(data){
			this.id_kardex = data;
			$('#regresar_tarea').modal('show');
		},
		regresar(id){
			var url = '/regresar_kardex';
			axios.post(url,{
				'razon':this.razon,
				'kardex':id,
			}).then((response)=>{
				if (response.data.flag == 1) {
					$.notify('Kardex devuelto con exito');
					$('#regresar').modal('hide');
					setTimeout(function() {
						window.location.href='/inicio';
					}, 1000);
				}
			})
		},
		actualizar(detalle){  //manda los datos al modal editar
			var url = '/actualizar_detalle/'+ detalle;
			axios.get(url).then((response)=>{
				this.actualizar_linea = response.data[0];
				this.id_detalle = response.data[0].id_detalle;
			})
		},
		actualizar_detalle(id){ //hace la acutalizacion del detalle en la db
			var url = "/actualizar_final/"+id;
			this.actualizar_linea.id_detalle = this.$refs.id_detalle.innerHTML; //aqui tomamos el id detalle pra meterlo al form
			axios.post(url,this.actualizar_linea).then((response)=>{
				if (response.data == 1) {
					$('#equipos_actualizar').modal('hide');
					location.reload();
				}
			})
		},
		si_ingeniero(usuario){
			var id  = this.$refs.id_kardex.innerHTML;
			var url = '/si_ingeniero';
			axios.post(url,{
					'usuario':usuario,
					'id':id  //estes es el ik kardex
				}).then((response)=>{
				if (response.data.flag ==  1) {
					this.ingeniero = 1;
					this.horario = response.data.datos
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
        abrir_modal_refacciones(id){
        	this.id_diagnostico = id;
        },
        submitForm() {
            axios.post('/agregar_refacciones',{
            	'id_diagnostico':this.id_diagnostico,
            	'refacciones':this.refacciones,
            }).then((response)=>{
            	if (response.data.flag == 1) {
            		location.reload();
            	}
            })
        },
        borrar_refaccion(data){
        	var url = '/borrar_refaccion/'+data;
        	if (confirm('¿Realmente deseas eliminar este registro?')==true) {	
	        	axios.get(url).then((response)=>{
	        		if (response.data.flag == 1) {
	        			location.reload();
	        		}
	        	})
        	}
        },
        a_cotizacion(data,kardex) {
        	
        	if (confirm('Deseas enviar este kardex a cotizacion por el vendedor')) {
	        	axios.post('/enviar_a_cotizar',{
	        		'usuario':data,
	        		'costo': this.precio_admin,
	        		'kardex':kardex
	        	}).then((response)=>{
	        		if (response.data == 1) {
	        			$('#miModal').modal('hide');
	        			$.notify('Se ha enviado a cotizar');
	        			location.reload();
	        		}
	        	})

        	}
	    },
	    cotizar(data){
	    	const url = '/nueva_cotizacion';
		    if (confirm('¿Deseas enviar este kardex a cotización?')) {
		        axios.post(url, { 'id': data })
		            .then((response) => {
		                if (response.data.hecho === 1) {
		                    $.notify(response.data.mensaje);

		                    setTimeout(() => {
		                        $.notify('En breve serás redirigido a la cotización');
		                    }, 1000);

		                    setTimeout(() => {
		                        window.location.href = `/pagina_cotizador/${response.data.slug}/${response.data.id}`;
		                    }, 2000);
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
	}
}).mount('#app')