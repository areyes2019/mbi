const {createApp, ref} = Vue

createApp({
	data(){
		return{
			
		}
	},
	methods:{
		descargar_factura(data){
			axios.post('descargar_factura',{
				'id':data
			}).then((response)=>{

			})
		},
		enviar_factura(){

		}
	},
	mounted(){

	}
}).mount('#app')
