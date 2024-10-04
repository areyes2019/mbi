const {createApp, ref} = Vue

createApp({
	data(){
		return{
			mis_tareas:[],
			tareas:[],
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
			var me = this;
			var url = 'crear_kardex';
			var data =this.tipos_model[cliente];
			axios.post(url,{
				'cliente':cliente,
				'tipo':data,
			}).then(function (response){
				if (response.data['exito'] == 1) {
					window.location = '/kardex/'+response.data['slug'];	
				}
			})
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
			var me = this;
			var url = "eliminar_kardex/"+data;
			if (confirm('Vas a eliminar todo un registro, ¿Deseas continuar?')==true) {
				axios.get(url).then(function (response){
					if (response.data == 1) {
						location.reload();
					}
				})

			}
		}
		
	},
	mounted(){
	}
}).mount('#app')