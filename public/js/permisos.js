const {createApp,ref} = Vue
	createApp({
		data(){
			return{
				seccion_id:"",
				secciones:[],
				seccion_id:"",
				nombre_seccion:"",
				permiso:"",
				permisos:[],
				alert:"",
				alert_top:"",
				display:"",
				permisos_rol:"",
				seccion_id_agregar:""
			}
		},
		methods:{
			mostrar_secciones(){
				var me = this;
				var url = '/ver_secciones';
				axios.get(url).then(function (response){
					me.secciones = response.data;
				})
			},
			abir_permisos(id,data){
				$("#agregar_permisos").modal("show");
				this.seccion_id = id;
				this.nombre_seccion = data;
				this.mostrar_permiso_seccion(id);
			},
			ver_permisos(){
				var me = this;
				var url = "/ver_permisos";
				axios.get(url).then(function (response){
					me.permisos = response.data;
				})
			},
			agregar_permiso(){
				var me = this;
				var id = this.$refs.seccion.innerHTML;
				var url = "/agregar_permiso";
				axios.post(url,{
					'rol_seccion':id,
					'permiso':me.permiso
				}).then(function (response){
					//$("#agregar_permisos").modal("hide");
					me.alert = "";
					me.mostrar_permiso_seccion(id);
				}).catch(error=>{
					var match = error.response.data.message;
					var palabra = "Duplicate";
					if (match.includes(palabra)){
						me.alert = "Este permiso ya existe, intenta con otro valor";
					}
				})
			},
			mostrar_permiso_seccion(data){
				var me = this;
				var url = '/mostrar_permiso_seccion/'+ data;
				axios.get(url).then(function (response){
					me.permisos_rol = response.data;
				});
			},
			borrar_permiso(data){
				var me = this;
				var id = this.$refs.seccion.innerHTML;
				var url = '/borrar_permiso/'+data;
				axios.get(url).then(function (response){
					if (response.data == 1) {
			        	me.mostrar_permiso_seccion(id);
			        	me.alert = "";
					}
				})
			},
			add_seccion(){
				var me = this;
				var id = this.$refs.rol.innerHTML;
				var url = '/add_seccion';
				axios.post(url,{
					'rol':id,
					'seccion':me.seccion_id_agregar
				}).then(function (response){
					if (response.data == 1) {
						me.alert = "";
						location.reload();
					}
				}).catch(error=>{
					var match = error.response.data.message;
					var palabra = "Duplicate";
					if (match.includes(palabra)){
						me.alert_top = "Esta sección ya esta asignada, intenta con otro valor";
					}
				})

			},
			eliminar_seccion_rol(data){
				var me = this;
				var url = "/eliminar_seccion_rol/" + data;
				var txt = "Si eliminas esta seccion, el usuario ya no podrá accederer ¿Deseas continuar? "
				if (confirm(txt) == true) {
    				axios.get(url).then(function (response){
    					if (response.data == 1) {
    						var title = "Listo";
			        		var message = "Se elimió la seecion de el rol";
			        		toaster(title,message);
			        		location.reload();
    					}

    				})
  				}
			}

		},
		mounted(){
			this.mostrar_secciones();
			this.ver_permisos();
		}
	}).mount("#app")