const {createApp,ref} = Vue
createApp({
	data(){
		return{
			permisos:[],
			checked:true,
			unchecked:false,
		}
	},
	methods:{
		ver_permisos(){
			var me = this;
			var id = this.$refs.usuario.innerHTML;
			var url = "/ver_permisos/"+id;
			axios.get(url).then(function (response){
				me.permisos = response.data;
			})
		},
		cambiar_leer(data){
			var valor =  this.$refs[data][0].value;
			var cambio = "";
			var url = "/actualizar_permiso"
			if (valor == 1) {
				cambio = 0;
			}else if(valor == 0){
				cambio = 1;
			};

			//var estado = this.checked = !this.checked;
			axios.post(url,{
				'permiso':cambio,
				'id':data,
				'tipo':1
			}).then(function (response){
				if (response.data==1) {
					/*var title = "Hecho";
			        var message = "Se ha actualizado el permiso de lectura";
			        toaster(title,message);*/
					//window.location.reload();
				}
			})
			me.ver_permisos();
		},
		cambiar_crear(data){
			var valor =  this.$refs[data][1].value;
			//alert(valor);
			var cambio = "";
			var url = "/actualizar_permiso"
			if (valor == 1) {
				cambio = 0;
			}else{
				cambio = 1;
			};

			//var estado = this.checked = !this.checked;
			axios.post(url,{
				'permiso':cambio,
				'id':data,
				'tipo':2
			}).then(function (response){
				var title = "Hecho";
		        var message = "Se ha actualizado el permiso de insertar";
		        toaster(title,message);
			})
		},
		cambiar_actualizar(data){
			var valor =  this.$refs[data][0].value;
			var cambio = "";
			var url = "/actualizar_permiso"
			if (valor == 1) {
				cambio = 0;
			}else{
				cambio = 1;
			};

			//var estado = this.checked = !this.checked;
			axios.post(url,{
				'permiso':cambio,
				'id':data,
				'tipo':3
			}).then(function (response){
				if (response.data == 1) {
					var title = "Hecho";
			        var message = "Se ha actualizado el permiso de actualizar";
			        toaster(title,message);
				}
			})
		},
		cambiar_eliminar(data){
			var valor =  this.$refs[data][0].value;
			var cambio = "";
			var url = "/actualizar_permiso"
			if (valor == 1) {
				cambio = 0;
			}else{
				cambio = 1;
			};

			//var estado = this.checked = !this.checked;
			axios.post(url,{
				'permiso':cambio,
				'id':data,
				'tipo':4
			}).then(function (response){
				var title = "Hecho";
			    var message = "Se ha actualizado el permiso de eliminar";
			    toaster(title,message);
			})
		}
	},
	mounted(){
		this.ver_permisos();
	}
}).mount('#app');