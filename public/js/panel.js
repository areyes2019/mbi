const {createApp, ref} = Vue

createApp({
	data(){
		return{
			mis_tareas:[],
			tareas:[],
			tipo_servicio:"",
			tipos_model:['0'],
			tipos:[
				{clave:'0',tipo:'Selecciona...'},
				{clave:'1',tipo:'Diagnóstico'},
				{clave:'2',tipo:'Refacciones'},
				{clave:'3',tipo:'Mtto. Prev.'},
				{clave:'4',tipo:'Garantía'},
			],
			kardex_data:[],
			detalles:[],
			accion:"",
			modal_msg:"",
			kardex:"",
			usuario:[],
		}
	},
	methods:{
		ver_mis_tareas(){
			var me = this;
			var id = this.$refs.usuario.innerHTML;
			var url = '/ver_mis_tareas/';
			
		},
		editar_kardex(data){
			var url = 'kardex/'+ data;
			window.location.href = url;
		},
		ver_tareas(){


		},
		ver_doc(data){
			var me = this;
			var url = "ver_kardex/"+data;
			axios.get(url).then(function (response){
				me.kardex_data = response.data.kardex;
				me.detalles = response.data.detalles;
			})
		},
		nuevo_kardex(cliente){
			var url = '/crear_kardex'; //aqui creamos la ruta
			
			if (!cliente) {  //confirmamos que si ha y cliente
				console.log('no hay cliente');
			}else{
				//aqui juntamos los datos para enviarlos por json
				var data = {
					cliente: cliente,
					tipo:this.tipos_model[cliente]
				}
				//aqui envaimos por ajax
				axios.post(url, data,{
				headers: {
				    'Content-Type': 'application/json'
				}
				}).then((response)=>{
					if (response.data['exito'] == 1) {
						window.location = '/kardex/'+response.data['slug'];	
					}
				})

			}
		},
		aceptar_tarea(kardex, data){
			this.accion = data;
			this.kardex = kardex;
			$('#ver_doc').modal('hide');
			if (data == 1) {
				this.modal_msg = "Vas a aceptar esta tarea, ¿Deseas continuar?"
			}else if(data==2){
				this.modal_msg = "Vas a rechazar esta tarea, ¿Deseas continuar?"
			}
			$('#aceptar_tarea').modal('show');

		},
		continuar_accion(kardex,accion){
			var me = this;
			var url = "kardex_accion";
			axios.post(url,{
				'kardex':kardex,
				'accion':accion
			}).then(function (response){
				location.reload();
			})
		},
		eliminar_kardex(data){
			var url = "eliminar_kardex/"+data;
			if (confirm('¿Estas seguro de querer eliminar este kardex? Esta accion ya no se puede revocar')==true) {
				axios.get(url).then((response)=>{
					if (response.data.kardex.status == 'success') {
						$.notify('Se elimió correctamente el kardex');
						setTimeout(()=>{
							location.reload();
						},1000)
					};
				})

			}
		}
		
	},
	mounted(){
	}
}).mount('#app')