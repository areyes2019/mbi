const { createApp, ref } = Vue

  createApp({
    data() {
      return {
        empresa_seleccionada:"",
      }
    },
    methods:{
      cotizacion_independiente(){
        var id = this.empresa_seleccionada;
        window.location.href = "/cotizacion_independiente/"+id;
      },
      eliminar_cotizacion(data){
        var url = '/eliminar_cotizacion/'+data;
        if (confirm('¿En verdad deseas eliminar esta cotización? Esta acción ya no se puede revocar')) {
          axios.get(url).then((response)=>{
            if (response.data==1) {
              window.location.href = "/cotizaciones";
            }
          })
        }
      },
    },
    mounted(){
      
    }
}).mount('#app')