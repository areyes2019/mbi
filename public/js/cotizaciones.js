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
        
        linea:[
          { detalles: ''} // Fila inicial
        ],
        //para el formulario independiente
        detalle_inner:"",
        cantidad:"1",
        partida:"1",
        articulo_ind:"",
        precio_ind:"",
        fields:[],
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
        cantidad_ind:"",
        descuento:"",
        disabled:0,
        costo:"",
        servicio:"",
        condiciones:"",
        entrega:"",
        garantia:"",
        moneda:"",
        baseUrl: window.location.origin + '/',
        entidades:"",
        metodo_pago:"",
        usoCFDI:"",
        entidad:"",
        clave_prod:"",
        listaConceptos:[
          { clave: 'G01', descripcion: 'Adquisición de mercancías' },
          { clave: 'G02', descripcion: 'Devoluciones, descuentos o bonificaciones' },
          { clave: 'G03', descripcion: 'Gastos en general' },
          { clave: 'I01', descripcion: 'Construcciones' },
          { clave: 'I02', descripcion: 'Mobiliario y equipo de oficina para inversiones' },
          { clave: 'I03', descripcion: 'Equipo de transporte' },
          { clave: 'I04', descripcion: 'Equipo de cómputo y accesorios' },
          { clave: 'I05', descripcion: 'Dados, troqueles, moldes, matrices y herramental' },
          { clave: 'I06', descripcion: 'Comunicaciones telefónicas' },
          { clave: 'I07', descripcion: 'Comunicaciones satelitales' },
          { clave: 'I08', descripcion: 'Otra maquinaria y equipo' },
          { clave: 'D01', descripcion: 'Honorarios médicos, dentales y hospitalarios' },
          { clave: 'D02', descripcion: 'Gastos médicos por incapacidad o discapacidad' },
          { clave: 'D03', descripcion: 'Gastos funerales' },
          { clave: 'D04', descripcion: 'Donativos' },
          { clave: 'D05', descripcion: 'Intereses reales pagados por créditos hipotecarios' },
          { clave: 'D06', descripcion: 'Aportaciones voluntarias al SAR' },
          { clave: 'D07', descripcion: 'Primas de seguros de gastos médicos' },
          { clave: 'D08', descripcion: 'Gastos de transportación escolar obligatoria' },
          { clave: 'D09', descripcion: 'Depósitos en cuentas para el ahorro, primas de pensiones' },
          { clave: 'D10', descripcion: 'Pagos por servicios educativos (colegiaturas)' },
          { clave: 'S01', descripcion: 'Sin efectos fiscales' },
          { clave: 'CP01', descripcion: 'Pagos' },
          { clave: 'CN01', descripcion: 'Nómina' }
        ],
        listaMetodosPago:[
          { clave: '01', descripcion: 'Efectivo' },
          { clave: '02', descripcion: 'Cheque nominativo' },
          { clave: '03', descripcion: 'Transferencia electrónica de fondos' },
          { clave: '04', descripcion: 'Tarjeta de crédito' },
          { clave: '05', descripcion: 'Monedero electrónico' },
          { clave: '06', descripcion: 'Dinero electrónico' },
          { clave: '08', descripcion: 'Vales de despensa' },
          { clave: '12', descripcion: 'Dación en pago' },
          { clave: '13', descripcion: 'Pago por subrogación' },
          { clave: '14', descripcion: 'Pago por consignación' },
          { clave: '15', descripcion: 'Condonación' },
          { clave: '17', descripcion: 'Compensación' },
          { clave: '23', descripcion: 'Novación' },
          { clave: '24', descripcion: 'Confusión' },
          { clave: '25', descripcion: 'Remisión de deuda' },
          { clave: '26', descripcion: 'Prescripción o caducidad' },
          { clave: '27', descripcion: 'A satisfacción del acreedor' },
          { clave: '28', descripcion: 'Tarjeta de débito' },
          { clave: '29', descripcion: 'Tarjeta de servicios' },
          { clave: '30', descripcion: 'Aplicación de anticipos' },
          { clave: '99', descripcion: 'Por definir' }
        ],

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
      mostrar_entidades(){
          axios.get('/mostrar_entidades').then((response)=>{
            this.entidades = response.data;
          })
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
      agregar_por_diagnostico(cotizacion){
        axios.post('/agregar_articulo',{
          'servicio':this.servicio,
          'cotizacion':cotizacion
        }).then((response)=>{

        })
      },
      agregar_ind(data){
        var cotizacion = this.$refs.id_cotizacion.innerHTML;
        axios.post('/agregar_articulo_ind/'+data,{
          'id_cotizacion':cotizacion,
          'cantidad':this.cantidad,
          'partida':this.partida,
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
      },
      mostrar_detalle(){
        var cotizacion = this.$refs.id_cotizacion.innerHTML;
        axios.get("/mostrar_detalles/"+cotizacion).then((response)=>{
          this.detalles = response.data;
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
      cambiar_moneda(data){
        axios.post('/cambiar_moneda',{
          'moneda': this.moneda,
          'cotizacion':data
        }).then((response)=>{
          if (response.data == 1) {
            location.reload();
          }
        })
      },
      agregar_condiciones(data){
        axios.post('/agregar_condiciones',{
          'condiciones':this.condiciones,
          'entrega':this.entrega,
          'garantia':this.garantia,
          'cotizacion':data
        }).then((response)=>{
           if (response.data == 1) {
            $.notify('Se agregaron las condiciones de esta cotización');
            $('#condiciones').modal('hide');
            location.reload();
           }
        })
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
          this.detalle_inner = data;
        })
      },
      enviar_cotizacion(data){
        axios.get('/enviar_pdf/'+data).then((response)=>{
          if (response.data == 1) {
            $.notify('Correo enviado al cliente');
          }
        })
      },
      accion(cotizacion,accion){
        axios.post('/aceptar_rechazar',{
          'cotizacion':cotizacion,
          'accion':accion
        }).then((response)=>{
          if (response.data==1) {
            location.reload();
          }
        })
      },
      generar_factura(data,cliente){
        axios.post('/facturar',{
            'metodo_pago':this.metodo_pago,
            'uso_cfdi':this.usoCFDI,
            'entidad':this.entidad,
            'cotizacion':data,
            'cliente':cliente,
            'clave_prod':this.clave_prod
        }).then((response)=>{
            if (response.data == 1) {
              $.notify('Se genero la factura');
            }
        })
      },
      agregarFila() {
            // Agregar una nueva fila con campos vacíos
            this.linea.push({ detalles: ''});
      },
      eliminarFila(index) {
            // Eliminar la fila en el índice especificado
            this.linea.splice(index, 1);
      },
      submitForm() {
          axios.post('/agregar_inner',{
            'detalles':this.linea,
            'id_detalle':this.detalle_inner

          }).then((response)=>{
            if (response.data == 1) {
              $('#agregar_refacciones').modal('hide');
              this.linea = [{ nombre: '', marca: '', modelo: '', costo: '' }];
              this.mostrar_general();
            }
          })
      },
    },
    mounted(){
      this.mostrar_lineas();
      this.mostrar_detalle();
      this.mostrar_entidades();
    }
}).mount('#app')