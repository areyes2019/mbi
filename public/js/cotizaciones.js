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
      }
    },
    mounted(){
      
    }
}).mount('#app')