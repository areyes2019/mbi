const {createApp,ref} = Vue
	createApp({
		data(){
			return{
				nombre:"",
				roles:[],
				secciones:[],
				permisos:[],
				rol:"",
				seccion_id:"",
				secciones:[]
			}
		},
		methods:{
			mostrar_roles(){
				var me = this;
				var url = "ver_roles";
				axios.get(url).then(function (response){
					me.roles = response.data;
				})
			},
			agregar_rol(){
				var me = this;
				var url = "/agregar_rol";
				axios.post(url,{
					'nombre':me.nombre
				}).then(function (response){
					if (response.data==1) {
						me.mostrar_roles();
						me.nombre = "";
						var title = "Listo";
			        	var message = "Se agregó el rol";
			        	toaster(title,message);
					}
				}).catch(error=>{
					var error = error.response.data.message;
					var n = error.search()
					console.log(n);
				});
			},
			mostrar_secciones(){
				var me = this;
				var url = "ver_secciones";
				axios.get(url).then(function (response){
					me.secciones = response.data;
				})
			},
			mostrar_permisos(){
				var me = this;
				var url = "ver_permisos";
				axios.get(url).then(function (response){
					me.permisos = response.data;
				})
			},
			eliminar(data){
				var me = this;
				var url = "/eliminar_rol/"+data;
				if (confirm('Estas a putno de eliminar este rol. Al hacerlo se eliminaran todos los permisos, ¿Deseas continuar?')==true) {
					axios.get(url).then(function (response){
						var title = "Listo";
			        	var message = "Se Elimino el rol";
			        	toaster(title,message);
			        	me.mostrar_roles();
					})
				}
			},
			abrir_modal(data){
				this.rol = data;
				$('#agregar_secciones').modal('show');
			},
			add_seccion(){
				var id = this.$refs.rol.innerHTML;
				var me = this;
				var url = 'add_seccion';
				axios.post(url,{
					'id_seccion':me.seccion_id,
					'id_rol': id
				}).then(function (response){

				})

			},
			editar_rol(data){

			},
			
		},
		mounted(){
			this.mostrar_roles();
			this.mostrar_secciones();
			this.mostrar_permisos();
			this.mostrar_secciones_roles()
		}

	}).mount("#app")