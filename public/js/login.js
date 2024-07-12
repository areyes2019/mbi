const {createApp,ref} = Vue
	createApp({
		data(){
			return{
				msg:"saludo"
			}
		},
		methods:{
			nueva_cuenta(){
				var me = this;
				var url = "/nueva_cuenta"
				axios.post(url,{
					
				}).then(function (response){})
			}

		},
		mounted(){

		}
}).mount('#app')