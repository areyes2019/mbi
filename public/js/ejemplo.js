const {createApp, ref} = Vue

createApp({
	data(){
		return{
			existencias:[],
		}
	},
	methods:{
		mostrar(){
		    var me = this;
		    var url = '/mostrar';
		    axios.get(url)
		      .then(response => {
		        me.lista = response.data;
		    })
		      .catch(error => {
		      console.error(error);
		    });
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
	},
	mounted(){

	}
}).mount('#app')
