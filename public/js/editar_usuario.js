const { createApp, ref } = Vue
createApp({
	data(){
		return{
			msg:"hola",
			roles:[],
			roles_asignados:[],
			rol:"",
			alert:""	
		}
	},
	methods:{
		ver_roles(){
			var me = this;
			var url = '/ver_roles';
			axios.get(url).then(function (response){
				me.roles = response.data;
			})
		},
		agregar_rol(){
			var me = this;
			var id = this.$refs.usuario.innerHTML;
			var url = "/agregar_rol_usuario";
			axios.post(url,{
				'usuario':id,
				'rol':me.rol

			}).then(function (response){
				if (response.data==1) {
					me.ver_roles_asignados();
					$("#agregar_roles").modal('hide');
				}
			}).catch(error=>{
					var match = error.response.data.message;
					var palabra = "Duplicate";
					if (match.includes(palabra)){
						me.alert = "Este rol ya esta asignado a este usuario, intenta con otro valor";
					}
				})
		},
		ver_roles_asignados(){
			var me = this;
			var id = this.$refs.usuario.innerHTML;
			var url = '/ver_roles_asignados/'+ id;
			axios.get(url).then(function (response){
				me.roles_asignados = response.data;
			})
		},
		eliminar_rol(data){
			var me 	= this;
			var txt = "Vas a eliminar este permiso del usuario, ¿Deseas continuar?";
			if (confirm(txt)== true) {

			var url = '/quitar_rol_usuario/'+ data;
			axios.get(url).then(function (response){
				if (response.data==1) {
	        		me.ver_roles_asignados();
				}
			}); 
			}

		}
	},
	mounted(){
		this.ver_roles();
		this.ver_roles_asignados();
	}

}).mount('#app')