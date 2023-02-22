<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link my-link-nav text-primary" href="" @click.prevent="openModal">Agregar Artículos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my-link-nav" href="" @click.prevent="sendMail"><span class="bi bi-send"></span> Enviar</a>
                </li>
                <li class="nav-item">
                    <a  :href="'/order_pdf/'+supplier+'/'+order" class="nav-link my-link-nav"><span class="bi bi-download"></span> Descargar</a>
                </li>
                <li class="nav-item"><a href="" class="nav-link text-danger" v-if="status==0">Marcar como pagada</a></li>
                <li class="nav-item d-flex align-items-center">
                    <div class="dropdown">
                      <a href="#" class="nav-link my-link-nav" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Vicular Oferta
                      </a>

                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li class="d-flex justify-content-between align-items-center p-3">
                            <input type="text" v-model="payment">
                            <a href="#" @click.prevent="add_payment" class="btn btn-sm btn-danger rounded-0"><span class="bi bi-check-square"></span></a>
                        </li>
                      </ul>
                    </div>
                </li>

                <!--
                    0 Borrador
                    1 Enviada
                    2 Pagada
                    3 Recibida
                    5 En Stock
                -->
              </ul>
            </div>
          </div>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box-std p-3">
                    <div class="row">
                        <h4>Cn Att: {{name}}</h4>
                        <div class="col-md-5">
                            <h5 class="mt-1" v-if="status==0"><span class="badge bg-secondary">Borrador</span></h5>
                            <h5 class="mt-1" v-if="status==1"><span class="badge bg-primary">Enviada</span></h5>
                            <h5 class="mt-1" v-if="status==2"><span class="badge bg-success">Pagada</span></h5>
                            <h5 class="mt-1" v-if="status==3"><span class="badge bg-danger">Recibida</span></h5>
                            <h5 class="mt-1" v-if="status==4"><span class="badge bg-dark">En Stock</span></h5>
                        </div>
                    </div>
                </div>
                <div class="card-box-std p-3 mt-3">
                    <div class="card-box-std p-3" v-if="lines == 0">
                        <p>No hay articulos en tu cotización</p>
                    </div>
                    <div class="table-container" v-if="lines != 0">
                        
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>CANT.</th>
                                    <th>ARTÍCULO</th>
                                    <th>MODELO</th>
                                    <th>P/UNITARIO</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="line in lines">
                                    <td>
                                        <input type="number" :value="line.quantity"  :id="line.id" @change="addQuantity(line.idOrder)" :disabled = "disabled == 1">
                                    </td>
                                    <td>{{line.name}}</td>
                                    <td>{{line.model}}</td>
                                    <td>{{line.unit_price}}</td>
                                    
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <p class="m-0">{{line.total}}</p>
                                            <a href="" @click.prevent="deleteLine(line.idDetail)" :class="[display]">X</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th >Total</th>
                                    <td>${{total.sub_total}}</td>
                                </tr>
                            </tfoot>
                    </table>
                    </div>
                    <a href="#" @click.prevent="deleteQuotation"><span class="bi bi-trash"></span> Eliminar</a>
                    <a href="#" class="ml-3" @click.prevent="deleteQuotation"><span class="bi bi-receipt"></span> Ver Ticket</a>
                </div>
            </div>            
        </div>

        <!-- modal agregar articulo del catalogo -->
        <div class="modal fade" id="addArticle" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content rounded-0 ">
                    <div class="modal-header  rounded-0">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Articulos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="my-sm-table" id="articles_table">
                            <thead>
                                <tr>
                                    <th class="p-2">Sello</th>
                                    <th class="p-2">Modelo</th>
                                    <th class="p-2">Cant.</th>
                                    <th class="p-2"><span class="bi bi-check-square"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="list in articles">
                                    <td>{{list.name}}</td>
                                    <td>{{list.model}}</td>
                                    <td >
                                        <input type="number" min="1" value="1" :ref="list.idArticle" size="5">
                                    </td>
                                    <td>
                                        <a href="" @click.prevent="addArticle(list.idArticle)"><span class="bi bi-plus-circle-dotted"></span></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- agregar articulo del catalogo -->

        <!-- Advertencia doble articulo -->
        <div class="modal fade" id="modal_warning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-body">
                    <div class="body-warning">
                        <center><span class="bi bi-exclamation-diamond warning-icon"></span>
                        <p class="m-0 warning-title">¡Opss!</p>
                        <p class="m-0 warning-text">{{warning}}</p>
                        <p class="m-0 warning-ref text-danger">¿Desas continuar?</p>
                        </center>
                    </div>
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
   export default{
        props:['supplier','name','order','slug'],
        data(){
            return{
                percent:"",
                money:"",
                quotation:[],
                articles:[],
                lines:[],
                customers:[],
                display:"",
                disabled:0,
                tax:"",
                status:"",
                total:[],
                payment:"",
                warning:"",
            }
        },
        methods:{
            openModal(){
                var me = this;
                axios.get('/articles_show_providers/'+me.supplier).then(function(response) {
                    me.articles = response.data;
                    me.table();
                    $('#addArticle').modal('show');
                })
            },
            addArticle(item){
                //console.log(this.id);
                var quantity =this.$refs[item][0].value;
                var me = this;
                var url = "/order_add_line";
                axios.post(url,{
                    'id_order':me.order,//id de cotizacion
                    'quantity':quantity,//cantidad
                    'article':item,//id de articulo
                }).then(function(response){
                    if (response.data==1) {
                        var warning_text = "Este articulo ya esta agregado";
                        me.warning_modal(warning_text)
                    }
                    me.showDetails();
                    me.showTotals();
                }).catch(function(errors){

                });
                

            },
           getQuotation(){
                var me = this;
                var url = "/quotation/"+me.slug;
                axios.get(url).then(function(response){
                    me.quotation = response.data;
                    me.status = response.data[0].status;
                    var payment = response.data[0].invoice;
                    me.tax = response.data[0].with_tax
                    
                })
            },
            showDetails(){
                var me = this;
                var url = "/order_show_line/"+me.order;
                axios.get(url).then(function(response){
                    me.lines = response.data;
                })
            },
            showCutomerData(){
                var me = this;
                var url = "/quotation_customer/"+ me.customer
                axios.get(url).then(function(response){
                    me.customers=response.data;
                })
            },
            change_status(data){
                var status="";
                if (data==2) {
                    if (window.confirm("¿Realmente quieres cambiar el etatus?. Esta acción ya no se puede revertir")) {
                        var status = 2;
                        this.status_fun(2);
                    }
                    
                }else if (data==3) {
                    if (window.confirm("¿Realmente quieres cambiar el etatus?. Esta acción ya no se puede revertir")) {
                        var status = 3;
                        this.status_fun(3);
                    }
                }else if (data==4) {
                    if (window.confirm("¿Realmente quieres cambiar enviar a facturación?. Una vez enviada la cotización, se cierra")) {
                        var status = 4;
                        this.status_fun(4);
                    }
                }
            },
            status_fun(data){
                var me = this;
                var url = "/change_status/"+this.slug;
                axios.post(url,{
                    'status':data
                }).then(function(response){
                    if (response.data == 1) {
                        me.getQuotation(); 
                    }
                }).catch(function(errors){

                });
            },
            deleteQuotation(){
                var me = this;
                var url = "/quotation_delete/";
                if (window.confirm("¿Realmente quieres eliminar esta cotización?")) {
                    axios.get(url+me.id).then(function(response){
                        if (response.data = 1) {
                            alert('Registro elminado');   
                            window.location.href = "/quotations/";
                        }else{
                            alert('No se elmino el registro');
                        }
                    })
                }
            },
            showTotals(){
                var me = this;
                var url = "/order_totals/"+ this.order;
                axios.get(url).then(function(response){                   
                    me.total.sub_total = response.data;
                    var tax = response.data /100 *16;
                    me.total.tax = tax;
                    me.total.total = response.data + tax;
                })
            },
            addQuantity(line){
                //console.log(line);
                var number = $("#"+line).val();
                var me = line;
                var url = '/add_quantity_order/';
                axios.post(url,{
                    'quantity':number,
                    'id':line
                }).then(function(response){
                    me.showDetails();
                    me.showTotals();
                })
            },
            deleteLine(line){
                var me = this;
                var url = '/delete_order_line';
                axios.post(url,{
                    'id_line':line
                }).then(function(response){
                    if (response.data == 1) {
                        me.showDetails();
                        me.showTotals();
                    }
                })
            },
            addDiscount(data){
                
                var discount = "";
                
                if (data==1) {
                    //el descuento es en dinero
                    var discount = this.$refs.money.value;
                }else if(data==2){
                    //el descuento es en porcentaje
                    var discount = this.$refs.percent.value;
                }

                var me = this;
                var url = '/add_discount';
                var id = this.id;
                var slug = this.slug;
                axios.post(url,{
                    'id':id,
                    'slug':slug,
                    'discount':discount,
                    'type':data,
                }).then(function(response){
                    me.percent = response.data;
                    me.showDetails();
                    me.showTotals();
                    me.percent = "";
                    me.money = "";
                })
            },
            table(){
                this.$nextTick(() => {
                    $('#articles_table').DataTable();
                });
            },
            delete_discount(data){
                var me = this;
                var url = '/delete_discount';
                axios.post(url,{
                    'slug':me.slug,
                    'id':data
                }).then(function(response){
                    me.showDetails();
                    me.showTotals();
                })
            },
            add_payment(){
                var me = this;
                var url = '/add_payment';
                axios.post(url,{
                    'slug':me.slug,
                    'payment':me.payment
                }).then(function(response){
                    if (response.data==0) {
                        var warning_text = "El pago introducido es superior al monto de la cotización";
                        me.warning_modal(warning_text);
                    }else{
                        me.showDetails();
                        me.showTotals();
                    }
                })
            },
            warning_modal(data){
                this.warning = data;
                $('#modal_warning').modal('show');
            },
            pdf(){
                var me = this;
                var url = '/order_pdf/'+me.supplier+'/'+me.order;
                axios.get(url).then(function(response){

                })
            }


        },
        mounted(){
            //this.showCutomerData();
            //this.getQuotation();
            this.showTotals();
            this.showDetails();
        }
   }
</script>