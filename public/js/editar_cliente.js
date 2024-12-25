const {createApp,ref} = Vue
	createApp({
		data(){
			return{
				editar:[],
				form:{},
				errores:{},
				editar_datos_fiscales:[],
				editar_hora:[],
				regimen:"",
                nombre:"",
                correo:"",
                rfc:"",
                calle:"",
                numero_ext:"",
                numero_int:"",
                colonia:"",
                cp:"",
                ciudad:"",
                estado:"",
                texto:"",
                campos:[{
                	dia:'',
                	horaInicio:'',
                	horaFin:''
                }],
                formulario: {
		          equipo: '',
		          marca: '',
		          modelo: '',
		          inventario: '',
		          noSerie: '',
		          foto: null,
		          id_cliente:''
		        },
                horarios:[],
                vista:"",
                diasSemana:['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                regimenes: [
                    { clave: '601', descripcion: 'General de Ley Personas Morales' },
                    { clave: '603', descripcion: 'Régimen de Incorporación Fiscal' },
                    { clave: '605', descripcion: 'Régimen de Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras' },
                    { clave: '606', descripcion: 'Régimen de Arrendamiento' },
                    { clave: '607', descripcion: 'Régimen de Sueldos y Salarios' },
                    { clave: '608', descripcion: 'Régimen de Honorarios'},
                    { clave: '609', descripcion: 'Régimen de Enajenación o Adquisición de Bienes'},
                    { clave: '610', descripcion: 'Régimen de Personas Morales con Fines no Lucrativos'},
                    { clave: '611', descripcion: 'Régimen de Maquiladoras'},
                    { clave: '612', descripcion: 'Régimen de Actividades Profesionales'},
                    { clave: '614', descripcion: 'Régimen de Enajenación de Bienes'},
                    { clave: '615', descripcion: 'Régimen de los ingresos por obtención de premios'},
                    { clave: '616', descripcion: 'Régimen de Dividendos y Participaciones'},
                    { clave: '618', descripcion: 'Régimen de Opciones sobre Acciones'},
                    { clave: '620', descripcion: 'Régimen de Personas Morales con Fines Lucrativos'},
                    { clave: '621', descripcion: 'Régimen de Pequeñas Empresas'}
                ],
                estados:[
				    { nombre: "Aguascalientes", abreviatura: "AGU" },
				    { nombre: "Baja California", abreviatura: "BC" },
				    { nombre: "Baja California Sur", abreviatura: "BCS" },
				    { nombre: "Campeche", abreviatura: "CAM" },
				    { nombre: "Chiapas", abreviatura: "CHP" },
				    { nombre: "Chihuahua", abreviatura: "CHH" },
				    { nombre: "Coahuila", abreviatura: "COA" },
				    { nombre: "Colima", abreviatura: "COL" },
				    { nombre: "Durango", abreviatura: "DUR" },
				    { nombre: "Guanajuato", abreviatura: "GTO" },
				    { nombre: "Guerrero", abreviatura: "GRO" },
				    { nombre: "Hidalgo", abreviatura: "HID" },
				    { nombre: "Jalisco", abreviatura: "JAL" },
				    { nombre: "México", abreviatura: "MEX" },
				    { nombre: "Michoacán", abreviatura: "MIC" },
				    { nombre: "Morelos", abreviatura: "MOR" },
				    { nombre: "Nayarit", abreviatura: "NAY" },
				    { nombre: "Nuevo León", abreviatura: "NL" },
				    { nombre: "Oaxaca", abreviatura: "OAX" },
				    { nombre: "Puebla", abreviatura: "PUE" },
				    { nombre: "Querétaro", abreviatura: "QUE" },
				    { nombre: "Quintana Roo", abreviatura: "QROO" },
				    { nombre: "San Luis Potosí", abreviatura: "SLP" },
				    { nombre: "Sinaloa", abreviatura: "SIN" },
				    { nombre: "Sonora", abreviatura: "SON" },
				    { nombre: "Tabasco", abreviatura: "TAB" },
				    { nombre: "Tamaulipas", abreviatura: "TAM" },
				    { nombre: "Tlaxcala", abreviatura: "TLA" },
				    { nombre: "Veracruz", abreviatura: "VER" },
				    { nombre: "Yucatán", abreviatura: "YUC" },
				    { nombre: "Zacatecas", abreviatura: "ZAC" }
				]
			}
		},
		methods:{
			agregarCampo(){
				this.campos.push({
					dia:'',
                	horaInicio:'',
                	horaFin:''
				})
			},
			eliminarCampo(index) {
                this.campos.splice(index, 1);
            },
            enviarDatos() {
            	var me = this;
            	var cliente = this.$refs.cliente.innerHTML;
            	var url = '/agregar_horario';
                axios.post(url,{
                	'horarios':me.campos,
                	'cliente': cliente
                }).then(function (response){
                	if (response.data == 1) {
                		me.campos = "";
                		$('#horarios').modal('hide');
                		me.ver_horarios();
                	}
                })
            },
            ver_horarios(){
            	var me = this;
            	var id = this.$refs.cliente.innerHTML;
            	var url = '/ver_horarios/'+ id;
            	axios.get(url).then(function (response){
            		me.horarios = response.data['query'];
            		me.vista = response.data['cuenta'];
            	})
            },
            eliminar_horario(data){

            	var me = this;
            	var url = "/eliminar_horario/"+data;
            	var txt = "¿Desas eliminar este horario?";
            	if (confirm(txt)==true) {

	            	axios.get(url).then(function (response){
	            		if (response.data == 1) {
	            			me.ver_horarios();
	            			showAlert('Horario eliminado');
	            		}
	            	})
            	}
            },
            editar_horarios(){
            	var me = this;
            	var id = this.$refs.cliente.innerHTML;
            	var url = '/editar_horarios/'+ id;
            	axios.get(url).then(function (response){
            		me.editar_horarios = response.data;
            	})
            },
            actualizar_hora(data){
            	var me = this;
            	var url = "/actualizar_hora";
            	var txt = "¿Estas seguro de querer actulizar este horario?"
            	if (confirm(txt)==true) {
	            	axios.post(url,this.horarios[0]).then(function (response){
	            		if (response.data == 1) {
	            			$('#modificar_horarios').modal('hide');
	            			showAlert('El horario ha sido modificado');
	            		}
	            	})
            	}
            },
            formatTo12Hour(time) {
		      	const [hour, minute] = time.split(':').map(Number);
		      	const ampm = hour >= 12 ? 'PM' : 'AM';
		      	const formattedHour = hour % 12 || 12;
		      	return `${formattedHour}:${minute < 10 ? '0' + minute : minute} ${ampm}`;
		    },
			validar_form(){
				

				this.errores = {};
		      	if (!this.regimen) {
			        this.errores.regimen = 'Debes asignar un regimen fiscal'; //nombre del encargado o DR
		      	}

		      	if (!this.nombre) {
			        this.errores.nombre = 'Debes escribir una razón social';  //nombre del contacto
		      	}

		      	if (this.correo) {
		      		if (!this.validar_correo(this.correo)) {
		      			this.errores.correo = "Formato de correo iválido";
		      		}
		      	}

		      	if (!this.rfc) {
			        this.errores.rfc = 'El RFC es necesario';  //nombre del contacto
		      	}

		      	if (!this.cp) {
			        this.errores.cp = 'El Código Postarl es necesario';  //nombre del contacto
		      	}else if(!this.validar_numero(this.cp)){
		      		this.errores.cp = 'Debes poner solo números';
		      	}

		  
		      	
			    return Object.keys(this.errores).length === 0;
			},
			limpiar_error(event,campo){
				this.texto = event.target.value;
				if (campo =='nombre') {
					this.errores.nombre = "";
				}else if (campo=='correo') {
					this.errores.correo = "";
				}else if (campo=='rfc') {
					this.errores.rfc = "";
				}else if (campo=='cp') {
					this.errores.cp = "";
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
			editar_cliente(){
				var id = this.$refs.cliente.innerHTML;
				var url = "/mostrar_cliente/"+ id;
				var me = this;
				axios.get(url).then(function (response){
					me.editar = response.data;
					me.ver_horarios();
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
			actualizar_datos_fiscales(){
				var me = this;
				var url = "/actualizar_datos_fiscales"
				axios.post(url,this.editar_datos_fiscales[0]).then((response)=>{
					$('#actualizar_datos_fiscales').modal('hide');
					$.notify('Datos Fiscales Actualizados');

				})
			},
			agregar_direccion_fiscal(){
				var me = this;
				var url = "/agregar_datos_fiscales"
				var cliente = this.$refs.cliente.innerHTML;
				if (this.validar_form()) {
					axios.post(url,{
						'regimen':me.regimen,
		                'nombre':me.nombre,
		                'correo':me.correo,
		                'rfc':me.rfc,
		                'calle': me.calle,
		                'numero_ext': me.numero_ext,
		                'numero_int': me.numero_int,
		                'colonia': me.colonia,
		                'cp': me.cp,
		                'ciudad': me.ciudad,
		                'estado': me.estado,
		                'cliente':cliente,
					}).then(function (response){
						if (response.data==1) {
							showAlert('Datos fiscales agregados')
							$('#agregar_datos_fiscales').modal('hide');
						}
					})		
				}
			},
			mostrar_datos_fiscales(data){
				var me = this;
				var url = '/mostrar_datos_fiscales/'+ data;
				axios.get(url).then(function (response){
					me.editar_datos_fiscales = response.data;
				})
			},
			subir_imagen(event){
				var file = event.target.files[0];
				this.formulario.foto = file;
				this.formulario.id_cliente = this.$refs.cliente.innerHTML;
				//console.log(this.formulario.foto);
			},
			validar_formulario(){
				this.errores = {};
				if (!this.formulario.equipo) {
			        this.errores.equipo = 'El nombre del equipo es obligatorio';  //nombre del contacto
		      	}

		      	if (!this.formulario.marca) {
			        this.errores.marca = 'Debes poner una marca';  //nombre del contacto
		      	}
		      	if (!this.formulario.modelo) {
			        this.errores.modelo = 'Debes poner una modelo';  //nombre del contacto
		      	}
		      	if (!this.formulario.inventario) {
			        this.errores.inventario = 'Debes poner un numero de inventario';  //nombre del contacto
		      	}else if (!this.validar_numero(this.formulario.inventario)) {
				    this.errores.inventario = 'Solo se admiten valores numéricos'; //extencion
		      	}
		      	if (!this.formulario.noSerie) {
			        this.errores.serie = 'El nombre de serie es obligatorio';  //nombre del contacto
		      	}
		      	
				return Object.keys(this.errores).length === 0;
			},
			limpiar_error_equipo(event,campo){
				this.texto = event.target.value;
				if (campo =='equipo') {
					this.errores.equipo = "";
				}else if (campo=='marca') {
					this.errores.marca = "";
				}else if (campo=='modelo') {
					this.errores.modelo = "";
				}else if (campo=='inventario') {
					this.errores.inventario = "";
				}else if (campo == 'serie') {
					this.errores.serie = "";
				}
			},
			agregar_equipo(){				
				var me = this;
				var url = "/agregar_equipo";
				if (this.validar_formulario()) {
          			axios.post(url,this.formulario,{
	          			headers:{
	          				'Content-Type': 'multipart/form-data',
	          			}
          			}).then(function (response){
          				if (response.data == 1) {
          					me.formulario = "";
          					$('#equipos').modal('hide');
          					showAlert('Equipo registrado correctamente');		
          				}
          			})
					
				}
				//console.log(this.formulario.foto);
				//ponemos todos los valores en las variables

			},

		},
		mounted(){
			this.editar_cliente();
			//this.ver_horarios();
		}
	}).mount('#app')