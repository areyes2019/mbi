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
                    <a class="nav-link my-link-nav text-primary" v-if="status < 3" href="" @click.prevent="openModal">Agregar Artículos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my-link-nav" href="" @click.prevent="sendMail"><span class="bi bi-send"></span> Enviar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my-link-nav" :href="'/get_quotation_pdf/'+customer+'/'+id+'/down'"><span class="bi bi-download"></span> Descargar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link my-link-nav" href="#" @click.prevent="approved"><span class="bi bi-file-earmark-ruled"></span>Facturar</a>
                </li>
                <li class="nav-item"><a href="" class="nav-link text-danger" v-if="status==0">Marcar como Enviada</a></li>
                <li class="nav-item d-flex align-items-center" v-if="status < 3">
                    <div class="dropdown">
                      <a href="#" class="nav-link my-link-nav" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Generar Pago
                      </a>

                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li class="d-flex justify-content-between align-items-center p-3">
                            <input type="text" v-model="payment">
                            <a href="#" @click.prevent="add_payment" class="btn btn-sm btn-danger rounded-0"><span class="bi bi-check-square"></span></a>
                        </li>
                      </ul>
                    </div>
                </li>
                 <li class="nav-item d-flex align-items-center dropstart" v-if="status < 3">
                    <div class="dropdown">
                      <a href="#" class="nav-link my-link-nav" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Agregar Descuento
                      </a>

                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li class="p-3">
                            <label for="">Agrega un porcentaje</label>
                            <div class="menu-fields d-flex justify-content-between align-items-center ">
                                <input type="text" ref="money" v-model="money" width="48" placeholder="%">
                                <a class="btn btn-danger btn-sm rounded-0 " @click.prevent="addDiscount()"><span class="bi bi-check-square"></span></a>
                            </div>
                        </li>
                      </ul>
                    </div>
                </li>
                <li class="nav-item"><a href="" class="nav-link text-danger" v-if="quotation.status==2">Generar orden de Trabajo</a></li>
                <li class="nav-item"><a href="" class="nav-link text-danger" v-if="status==3">Generar orden de Trabajo</a></li>
                <!--
                    0 Borrador
                    1 Enviada
                    2 Pago parcial
                    3 Pago total
                    4 Cerrar
                -->
              </ul>
            </div>
          </div>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box-std p-3">
                    <div class="row">
                        <div class="col-md-5">
                            <div v-for="customer in customers">
                                <div class="mb-3" v-for="item in quotation">
                                    <p class="m-0">No: <span>{{item.idQt}}</span></p>
                                    <p class="m-0">Fecha: <span>{{item.created_at}}</span></p>
                                </div>
                                
                                <p class="m-0">Para: <span>{{customer.company}}</span></p>
                                <p class="m-0">Con Att.: <span>{{customer.name}}</span></p>
                                <p class="m-0"><strong>{{customer.email}}</strong></p>
                                <p class="m-0">Tipo:
                                    <strong v-if="customer.type == 0">Cliente Regular</strong>
                                    <strong v-else="customer.type == 1">Distribuidor</strong>
                                </p>
                            </div>
                            <h5 class="mt-1" v-if="status==0"><span class="badge bg-secondary">Borrador</span></h5>
                            <h5 class="mt-1" v-else-if="status==1"><span class="badge bg-primary">Enviada</span></h5>
                            <h5 class="mt-1" v-else-if="status==2"><span class="badge bg-success">Anticipo Pagado</span></h5>
                            <h5 class="mt-1" v-else-if="status==3"><span class="badge bg-success">Pago Total</span></h5>
                            <h5 class="mt-1" v-else-if="status==4"><span class="badge bg-danger">Cerrada</span></h5>
                            <h5 class="mt-1" v-else="status==5"><span class="badge bg-dark">Facturada</span></h5>
                            <p class="m-0 p-0 text-primary" v-if="tax==1">Con Factura</p>
                            <p class="m-0 p-0 text-danger" v-if="tax==0">Sin Factura</p>
                            <h4 v-if="total.advance_payment == total.total">PAGADO</h4>
                            <h4>Anticipo sugerido ${{total.advance}}</h4>
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
                                    <td v-if="status < 3">
                                        <input type="number" :value="line.quantity"  :id="line.id" @change="addQuantity(line.id)" :disabled = "disabled == 1">
                                    </td>
                                    <td v-if="status == 3">{{line.quantity}}</td>
                                    <td v-else-if="status == 4">{{line.quantity}}</td>
                                    <td>{{line.name}}</td>
                                    <td>{{line.model}}</td>
                                    <td>{{line.unit_price}}</td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <p class="m-0">{{line.total}}</p>
                                            <a v-if="status < 3" href="" @click.prevent="deleteLine(line.id)">X</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th >Importe</th>
                                    <td>${{total.amount}}</td>
                                </tr>
                                <tr  v-if="total.discount > 0">
                                    <th colspan="3"></th>
                                    <th>Dcto. <strong>{{total.percent}}%</strong></th>
                                    <td class="d-flex justify-content-between">${{total.discount}}<a href="#" @click.prevent="delete_discount(1)" v-if="status < 3"><span class="bi bi-x-circle-fill"></span></a></td>
                                </tr>
                                <tr>
                                    <th colspan="3"></th>
                                    <th>IVA</th>
                                    <td>
                                        <div>
                                            <p class="m-0">${{total.tax}}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3"></th>
                                    <th>Total</th>
                                    <td>${{total.total}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3"></th>
                                    <th v-if="total.balance == 0">Pago Total</th>
                                    <th v-else>Anticipo</th>
                                    <td>${{total.payment}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3"></th>
                                    <th>Saldo</th>
                                    <td class="d-flex justify-content-between">${{total.balance}} <a v-if="status < 3" href="#" @click.prevent="payment_modal(total.balance)"><span class="bi bi-check-square"></span></a></td>
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

        <!-- modal tipo de ingreso-->
        <div class="modal fade" id="payment_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-body">
                    <div class="body-warning">
                        <center><span class="bi bi-exclamation-diamond warning-icon"></span>
                        <p class="m-0 warning-title">¡Hola!</p>
                        <p class="m-0 warning-text">Puedes meter esta cotizacion a contabilidad</p>
                        <p class="m-0 warning-ref text-danger">¿Desas continuar?</p>
                        </center>
                    </div>
                </div>
              <div class="modal-footer">
                <center>
                    <button class="btn btn-danger rounded-0 btn-sm mt-3"  @click="total_payment(1)">Elaborado Local</button>
                    <button class="btn btn-primary rounded-0 btn-sm mt-3" @click="total_payment(2)">Elaborado Foraneo</button>
                    <button class="btn btn-secondary rounded-0 btn-sm mt-3" @click="total_payment(3)">Venta Mecanismos</button>
                </center>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
   export default{
        props:['id','slug','customer','type'],
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
                total_pay:"",
            }
        },
        methods:{
            openModal(){
                var me = this;
                axios.get('/articles_show').then(function(response) {
                    me.articles = response.data;
                    me.table();
                    $('#addArticle').modal('show');
                })
            },
            addArticle(item){
                //console.log(this.id);
                var quantity =this.$refs[item][0].value;
                var me = this;
                var url = "/quotations_add_line";
                axios.post(url,{
                    'idQt':me.id,//id de cotizacion
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
                var url = "/quotations_show_lines/"+me.id;
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
            tax_free(){
                var me = this;
                if (this.tax==false) {
                    this.tax = 0;
                }else{
                    this.tax = 1;
                }
                var url = "/tax_add";
                axios.post(url,{
                    'id':me.id,
                    'tax':me.tax
                }).then(function(response){
                    me.showTotals();
                    me.getQuotation();
                })
            },
            deleteQuotation(){
                var me = this;
                var url = "/quotation_delete/";
                if (window.confirm("¿Realmente quieres eliminar esta cotización?")) {
                    axios.get(url+me.id).then(function(response){
                        if (response.data = 1) {
                            alert('Registro elminado');
                            window.history.back();   
                            //window.location.href = "/quotations";
                        }else{
                            alert('No se elmino el registro');
                        }
                    })
                }
            },
            showTotals(){
                var me = this;
                var url = "/show_totals/"+ this.id;
                axios.get(url).then(function(response){                   
                    me.total = response.data;
                })
            },
            addQuantity(line){
                //console.log(number);
                var number = $("#"+line).val();
                var me = this;
                var url = '/add_quantity/'+line;
                axios.post(url,{
                    'quantity':number,
                    'id':me.id
                }).then(function(response){
                    me.showDetails();
                    me.showTotals();
                })
            },
            deleteLine(line){
                var me = this;
                var url = '/delete_line';
                axios.post(url,{
                    'id_qt':me.id,
                    'id_line':line
                }).then(function(response){
                    me.showDetails();
                    me.showTotals();
                })
            },
            addDiscount(){
                
                var discount = "";
                var discount = this.$refs.money.value;

                var me = this;
                var url = '/add_discount';
                var id = this.id;
                var slug = this.slug;
                axios.post(url,{
                    'id':id,
                    'slug':slug,
                    'discount':discount,
                }).then(function(response){
                    
                    if (response.data == 0) {
                        var warning_text = "No puedes asignar descuentos sin tener artículos agreagados";
                        me.warning_modal(warning_text);
                    }else{
                        me.percent = response.data;
                        me.showDetails();
                        me.showTotals();
                        me.money = "";
                    }
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
            total_payment(data){
                //el data es el tipo de trasacción

                /*
                    1 elaborado local
                    2 elaborado foraneo
                    3 venta mecanismos
                */

                var me = this;
                var url = '/total_payment';
                var amount = this.total_pay;
                axios.post(url,{
                    'id':me.id,
                    'type':data,
                    'amount':amount,
                }).then(function(response){
                    $('#payment_modal').modal('hide');
                    window.location.reload();
                })
                
            },
            add_accounting(data){
                var me = this;
                var url = '/add_accounting';
                axios.post(url,{
                    'id':me.id,
                    'type':data
                }).then(function(response){
                        window.location.reload();
                        /*me.showTotals();
                        me.showDetails();
                        var title = "Felicidades";
                        var message = "Has ha contabilizado esta cotización";
                        toaster(title,message);
                        $('#payment_modal').modal('hide');*/
                })
            },
            payment_modal(data){
                this.total_pay = data; //aki esta el valor
                $('#payment_modal').modal('show');
            },
            warning_modal(data){
                this.warning = data;
                $('#modal_warning').modal('show');
            },

        },
        mounted(){
            this.showCutomerData();
            this.getQuotation();
            this.showTotals();
            this.showDetails();
        }
   }
</script>