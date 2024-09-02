const {createApp,ref} = Vue
	createApp({
		data(){
			return{
				form:{},
				editar:[],
				errores:{},
				picked:"",
				display:"d-none",
				display_form:"d-none",
				display_form_one:"",
				texto:"",
				id_cliente:"",
				id_cliente_fiscal:"",
				campos: [{
                        dia: '',
                        horaInicio: '',
                        horaFin: '',
                    }],
                diasSemana: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                /*Formulario de datos fiscales*/
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
                horarios:[],
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
			    regimen_seleccionado:"",
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
			validar_form(){
				this.errores = {};
		      	if (!this.form.titular) {
			        this.errores.titular = 'El nombre del encargado es obligatorio'; //nombre del encargado o DR
		      	}

		      	if (!this.form.responsable) {
			        this.errores.responsable = 'El nombre de contacto es obligatorio';  //nombre del contacto
		      	}

		      	if (this.form.telefono) {
		      		if (!this.validar_numero(this.form.telefono)) {   // verifica si es numero
			        	this.errores.telefono = 'Debes poner solo números';
		      		}else if(!this.validar_long(this.form.telefono)){
		      			this.errores.telefono = "El campo solo amite 10 digitos";
		      		}

		      	}

		      	if (this.form.extencion) {
			      	if (!this.validar_numero(this.form.extencion)) {
				        this.errores.extencion = 'Solo número'; //extencion
			      	}

		      	}


		      	if (!this.form.movil) {
			        this.errores.movil = 'Debes asignar un numero móvil';
		      	}else if (!this.validar_numero(this.form.movil)) {
			        this.errores.movil = 'Debes poner solo números';
		      	}

		      	if (this.form.correo) {
		      		if (!this.validar_correo(this.form.correo)) {
		      			this.errores.correo = "Formato de correo iválido";
		      		}
		      	}

		  
		      	
			    return Object.keys(this.errores).length === 0;
			},
			limpiar_error(event,campo){
				this.texto = event.target.value;
				if (campo =='titular') {
					this.errores.titular = "";
				}else if (campo=='responsable') {
					this.errores.responsable = "";
				}else if (campo=='telefono') {
					this.errores.telefono = "";
				}else if (campo=='extencion') {
					this.errores.extencion = "";
				}else if (campo == 'movil') {
					this.errores.movil = "";
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
			enviar_form(){
				var me  = this;
				var url = "/nuevo_cliente";
				if (this.validar_form()) {
					//console.log(this.form);
			    	axios.post(url,this.form).then(function (response){
			    		if (response.data == 1) {
			    			var msg = "Cliente guardado correctamente";
			    			showAlert(msg);
			    			me.form.titular = "";
			    			me.form.responsable = "";
			    			me.form.telefono = "";
			    			me.form.extencion = "";
			    			me.form.movil = "";
			    			me.form.correo = "";
			    			me.form.direccion = "";
			    			me.form.ubicacion = "";
			    			me.form.laboratorio = "";
			    			me.form.piso = "";
			    		}
			    	})
			    }
			},
			
			mostrar_cliente_modal(data){
				var me = this;
				var url = "/mostrar_cliente/"+ data;
				axios.get(url).then(function (response){
					me.editar = response.data;
				})
				this.ver_horarios(data);
			},
			ver_horarios(id){
            	var me = this;
            	var url = '/ver_horarios/'+ id;
            	axios.get(url).then(function (response){
            		me.horarios = response.data['query'];
            	})
            },
            formatTo12Hour(time) {
		      	const [hour, minute] = time.split(':').map(Number);
		      	const ampm = hour >= 12 ? 'PM' : 'AM';
		      	const formattedHour = hour % 12 || 12;
		      	return `${formattedHour}:${minute < 10 ? '0' + minute : minute} ${ampm}`;
		    },

		},
		mounted(){

		}
}).mount('#app')