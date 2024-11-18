const { createApp, ref } = Vue

  createApp({
    data() {
      return {
        articulos:[],
        lista:[],
        totales:{},
        independiente:[],
        diagnostico:{},
        refacciones:{},
        detalles:{},
        cantidad:"1",
        anticipo:"",
        sub_total:"",
        iva:"",
        total:"",
        saldo:"",
        display:"",
        hide:"",
        pago:"",
        saldo:"",
        sugerido:"",
        utilidad:"",
        articulo_ind:"",
        cantidad_ind:"",
        precio_ind:"",
        descuento:"",
        disabled:0,
        costo:""
      }
    },
    methods:{
      mostrar_articulos(){
        var me = this;
        var url = '/mostrar_articulos';
        axios.get(url)
          .then(response => {
            me.lista = response.data;
            me.tabla();
        })
          .catch(error => {
          console.error(error);
        });
      },
      add_articulo(data){    
        var me = this;
        var cantidad = this.$refs[data][0].value;
        var articulo = data //this.$refs.articulo.value;
        var cotizacion = this.$refs.id_cotizacion.innerHTML;
        var descuento = this.$refs.descuento.innerHTML;
        axios.post('/agregar_articulo',{
          'id_articulo':articulo,
          'cantidad':cantidad,
          'id_cotizacion':cotizacion,
          'descuento':descuento
        }).then(function (response){
            if (response.data == 1) {
              alert('Este producto ya agregado')
            }else{
              me.mostrar_lineas();
            }
        })
      },
      agregar_ind(data){
        if (this.articulo_ind && this.precio_ind) {    
          var cotizacion = this.$refs.id_cotizacion.innerHTML;
          axios.post('/agregar_articulo_ind/'+data,{
            'id_cotizacion':cotizacion,
            'descripcion':this.articulo_ind,
            'p_unitario':this.precio_ind
          }).then((response)=>{
              if (response.data.status == "success"){
                $.notify('Se agregó el concepto');
                this.mostrar_lineas();
                this.mostrar_detalle();
                this.articulo_ind = "";
                this.precio_ind="";
                $('#agregar_articulo').modal('hide');
              }
          })
        }else{
          alert("No puedes dejar campos vacios");
        }
      },
      mostrar_detalle(){
        var cotizacion = this.$refs.id_cotizacion.innerHTML;
        var url = '/mostrar_detalles/'+cotizacion;
        axios.get(url).then((response)=>{
          this.detalles = response.data.detalles;
          this.totales = response.data.totales;
        })
      },
      modificar_cantidad(data){
        var me = this;
        var url = "/modificar_cantidad";
        var cantidad = this.$refs[data][0].value;
        var descuento = this.$refs.descuento.innerHTML;
        axios.post(url,{
          'id':data,
          'cantidad':cantidad,
          'descuento':descuento
        }).then(function (response){
          me.mostrar_lineas();
          $('#pago').collapse('hide');
        })

      },
      mostrar_collapse(){
        $('#pago').collapse('show');
      },
      mostrar_lineas(){
        var cotizacion = this.$refs.id_cotizacion.innerHTML;
        axios.get('/mostrar_detalles/'+cotizacion).then((response)=>{
            this.independiente = response.data;
        })
      },
      borrar_linea_detalle(data){
  
        if (confirm("¿Realmente quieres borrar esta linea?")) {
            axios.get('/borrar_linea_detalle/'+data).then((response)=> {
                if (response.data==1) {
                  $.notify('Registro eliminado');
                  this.mostrar_lineas();
                  this.mostrar_detalle();
                }
            })
        }
      },
      agregar_pago(){
        var me = this;
        var cotizacion = this.$refs.id_cotizacion.innerHTML;
        axios.post('/pago',{
          'pago':me.anticipo,
          'id':cotizacion
        }).then(function (response){
            me.mostrar_lineas();
            me.anticipo = "";
        })
        $("#pago").collapse('hide');

      },
      descargar_img(){
        var cotizacion = this.$refs.id_cotizacion.innerHTML;
        html2canvas(document.querySelector("#ticket")).then(canvas => {
        canvas.toBlob(function(blob) {
          window.saveAs(blob, 'TK-'+cotizacion+'.jpg');
        });
        });
      },
      entregada(data){
        var title = "Hecho";
        var message = "Se ha realizado la accion";
        toaster(title,message);
        /*var me = this;
        var url = "/marcar_entregado"
        axios.post(url,{
          'id':data    
        }).then(function (response){
        });*/
      },
      tabla(){
        $( document ).ready(function() {
          new DataTable('#articulos');
        });
      },
      agregar_diagnostico_modal(data){
        axios.get('/ver_diagnostico_kardex/'+ data).then((response)=>{
          this.diagnostico = response.data.diagnostico;
          this.refacciones = response.data.refacciones;
        })
      },
      enviar_cotizacion(data){
        axios.get('/enviar_pdf/'+data).then((response)=>{
          if (response.data == 1) {
            $.notify('Correo enviado al cliente');
          }
        })
      }
    },
    mounted(){
      this.mostrar_lineas();
      this. mostrar_detalle();
    }
}).mount('#app')