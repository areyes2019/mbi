const {createApp, ref} = Vue

createApp({
	data(){
		return{
			existencias:[],
			enviado:[],
			recibido:[],
			borrador:[],
			salida:[],
			kardex_lateral:[],
			kardex_detalle:[],
			pedido:null,
			primer_kardex:[],
			vista_defecto:"1",
			usuario:'defecto',
			asunto:"",
			id_kardex:""
		}
	},
	methods:{
		mostrar_bandeja(){
			var me = this;
			var url = '/mostrar_bandeja';
			axios.get(url)
			.then(response => {
				me.enviado = response.data.enviado;
				me.recibido = response.data.recibido;
				//me.borrador = response.data.borrador;
			})
			.catch(error => {
				console.error(error);
			});
		},
		mostrar_primero(){
			var me = this;
			var url = "primer_kardex";
			axios.get(url).then(function(response){
				me.primer_kardex = response.data.kardex; 
				me.kardex_detalle = response.data.resultado_kardex; 
			})
		},
		abrir_modal_single(data){
			$('#modal_enviar').modal('show');
			this.id_kardex = data;
		},
		abrir_modal_lista(data){
			$('#modal_enviar').modal('show');
			this.id_kardex = data;
		},
		enviar_form(){
			var me = this;
			var url = '/enviar_kardex';
			axios.post(url,{
				'destinatario':me.usuario,
				'kardex':me.id_kardex,
				'asunto':me.asunto
			}).then(function (response){
				if (response.data == 1) {
					$('#modal_enviar').modal('hide');
					me.usuario = "defecto";
					me.asunto = "";
					me.mostrar_bandeja();
				}
			})

		},
		insertar(data){    
			var me = this;
			var url = "/ruta";
			axios.post(url,this.formulario).then(function (response){
				if (response.data == 1) {

				}
			})
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
		calcularDiferenciaDias(fechaPasada) {
			
			// Reemplazar el espacio entre la fecha y la hora con 'T'
			const fechaPasadaISO = fechaPasada.replace(" ", "T");
			  
			// Crear objeto de fecha
			const fechaPasadaDate = new Date(fechaPasadaISO);
			const fechaActual = new Date();
			  
			// Comparar solo el día, ignorar la hora (convertir a solo fecha)
			const soloFechaPasada = new Date(fechaPasadaDate.getFullYear(), fechaPasadaDate.getMonth(), fechaPasadaDate.getDate());
			const soloFechaActual = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), fechaActual.getDate());

			// Calcular la diferencia en milisegundos
			const diferenciaMilisegundos = soloFechaActual - soloFechaPasada;
			  
			// Convertir milisegundos a días
			const milisegundosPorDia = 1000 * 60 * 60 * 24;
			return Math.floor(diferenciaMilisegundos / milisegundosPorDia);
			//console.log(res);
      	},
      	calcularDiferenciaEnviado(fechaPasada) {
			
			// Reemplazar el espacio entre la fecha y la hora con 'T'
			const fechaPasadaISO = fechaPasada.replace(" ", "T");
			  
			// Crear objeto de fecha
			const fechaPasadaDate = new Date(fechaPasadaISO);
			const fechaActual = new Date();
			  
			// Comparar solo el día, ignorar la hora (convertir a solo fecha)
			const soloFechaPasada = new Date(fechaPasadaDate.getFullYear(), fechaPasadaDate.getMonth(), fechaPasadaDate.getDate());
			const soloFechaActual = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), fechaActual.getDate());

			// Calcular la diferencia en milisegundos
			const diferenciaMilisegundos = soloFechaActual - soloFechaPasada;
			  
			// Convertir milisegundos a días
			const milisegundosPorDia = 1000 * 60 * 60 * 24;
			return Math.floor(diferenciaMilisegundos / milisegundosPorDia);
			//console.log(res);
      	},
      	vista_previa(data){
      		
      		var me = this;
      		var url = "vista_previa/"+data;
      		axios.get(url).then(function (response){
      			me.kardex_lateral = response.data.kardex;
      			me.kardex_detalle = response.data.kardex_detalle;
      			me.vista_defecto = 0;
      			me.mostrar_bandeja();
      		})
      	},
      	ver_primer_kardex(){
      		var me = this;
      		var url = "ver_primer_kardex";
      		axios.get(url).then(function (response){
      			console.log(response.data);
      			me.pedido = response.data.primer_kardex;
      			me.primer_kardex_detalle = response.data.primer_detalle;
      		})
      	}
	},
	mounted(){
		this.mostrar_bandeja();
		this.mostrar_primero();
	}
}).mount('#app')