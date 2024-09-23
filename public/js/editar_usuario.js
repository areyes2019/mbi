const { createApp, ref } = Vue
createApp({
	data(){
		return{
			msg:"hola",
			secciones:[],
			secciones_asignados:[],
			seccion:"",
			alert:"",
			funciones:[],
			funcion:"",
			checked:true,
			data:{
				solo_ver:0
			},
			valor:0
		}
	},
	methods:{
		ver_secciones(){
			var me = this;
			var url = '/ver_secciones';
			axios.get(url).then(function (response){
				me.secciones = response.data;
			})
		},
		ver_funciones(){
			var me = this;
			var url = '/ver_roles';
			axios.get(url).then(function (response){
				me.funciones = response.data;
			})
		},
		asignar_funcion(){
			var me = this;
			var id = this.$refs.usuario.innerHTML;
			var url = "/asignar_funcion";
			axios.post(url,{
				'usuario':id,
				'funcion':me.funcion

			}).then(function (response){
				if (response.data==1) {
					me.ver_secciones_asignadas();
					$("#agregar_seccion").modal('hide');
					me.alert="";
				}
			}).catch(error=>{
					var match = error.response.data.message;
					var palabra = "Duplicate";
					if (match.includes(palabra)){
						me.alert = "Esta seccion ya esta asignada a este usuario, intenta con otro valor";
					}
				})	
		},
		agregar_seccion(){
			var me = this;
			var id = this.$refs.usuario.innerHTML;
			var url = "/agregar_seccion_usuario";
			axios.post(url,{
				'usuario':id,
				'seccion':me.seccion

			}).then(function (response){
				if (response.data==1) {
					me.ver_secciones_asignadas();
					$("#agregar_seccion").modal('hide');
					me.alert="";
				}
			}).catch(error=>{
					var match = error.response.data.message;
					var palabra = "Duplicate";
					if (match.includes(palabra)){
						me.alert = "Esta seccion ya esta asignada a este usuario, intenta con otro valor";
					}
				})
		},
		ver_secciones_asignadas(){
			var me = this;
			var id = this.$refs.usuario.innerHTML;
			var url = '/ver_secciones_asignadas/'+ id;
			axios.get(url).then(function (response){
				me.secciones_asignados = response.data;
			})
		},
		eliminar_seccion(data){
			var me 	= this;
			var txt = "Vas quitar este permiso al usuario, ¿Deseas continuar?";
			if (confirm(txt)== true) {

			var url = '/quitar_seccion_usuario/'+ data;
			axios.get(url).then(function (response){
				if (response.data==1) {
	        		me.ver_secciones_asignadas();
				}
			}); 
			}

		},
		permisos(id,permiso){
			
			var number = permiso+id; 
			var me = this;
			var url = "/actualizar_permiso_seccion"
			const elemento = this.$refs[number][0].value;
			console.log(elemento);


			if (elemento == 1) {
				valor = 0;
			}else if(elemento == 0){
				valor = 1
			}
			
			//valor booleano para cambiar el permiso
			axios.post(url,{
				'seccion':id, 
				'permiso':permiso, 
				'valor':valor, 
			}).then(function (response){
				if (response.data == 1) {
					location.reload();
				}
			})
			 //console.log(valor);
		}
	},
	mounted(){
		this.ver_secciones();
		this.ver_funciones();
		this.ver_secciones_asignadas();
	}

}).mount('#app')