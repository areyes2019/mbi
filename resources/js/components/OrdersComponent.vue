<template>
    <div class="container">
        <h3 class="mt-3">Pedidos a Proveedor</h3>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4 rounded-0">
                <!-- Card Header - Dropdown -->
                    <div class="card-header rounded-0 ">
                      <!-- cotizar a cliente -->
                      <a class="btn rounded-0 btn-danger btn-sm" href="#" @click.prevent="new_qt">
                        <span class="icon-file-plus icon-my text-white"></span> Nuevo Pedido
                      </a>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body rounded-0">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Fecha</th>
                                    <th>Proveedor</th>
                                    <th>Vinculada a</th>
                                    <th>Monto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="data in general_data ">
                                    <td>{{data.idOrder}}</td>
                                    <td>{{new Date(data.created_at).toLocaleDateString()}}</td>
                                    <td>{{data.company}}</td>
                                    <td>{{data.link}}</td>
                                    <td>{{data.total}}</td>
                                    <td>
                                       <button class="btn btn-danger rounded-0 btn-sm" @click="toOrder(data.slug)">Ver</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Cotizar a cliente-->
        <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded-0">
              <div class="modal-header rounded-0 bg-color">
                <h5 class="modal-title" id="staticBackdropLabel">Seleccionar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <table class="table table-bordered" id="cliente">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Contacto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in customers_data">
                            <td v-text="data.company"></td> 
                            <td v-text="data.name"></td>
                            <td class="d-flex justify-content-end">
                              <button class="btn btn-danger btn-sm rounded-0" @click="makeOrder(data.idContact)"><span class="bi bi-check-square"></span></button>
                            </td>

                        </tr>
                    </tbody>
                </table>
              </div>
              
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import datatable from 'datatables.net-bs5'
    export default {
        data(){
            return{
                general_data:[],
                customers_data:[],
                tax:""

               
            }
        },
        methods:{
            getData(){
              var me = this;
              axios.get('/orders_show').then(function(response) {
                var date = new Date(response.data[0].created_at);
                me.general_data = response.data;
                me.table();
              })
            },
            toOrder(data){
              window.location.href = '/order_page/'+data;
            },
            //esta funcion abre el modal clientes y muestra la lista de clientes
            new_qt(){
                let me =this;
                let url = '/contacts_list/'+2 
                //cotizacion a cliente
                axios.get(url).then(function(response) {
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.customers_data = response.data;
                    me.mySelect();
                    $('#exampleModal').modal('show');
                })
            },
            //con esta fun enviamos los datos para iniciar la cotizacion
            makeOrder(data){
              //Creamos el slug
              let slug = Math.random().toString(36).substring(3);
              let me = this;
              //seleccionamos el tipo de cotización
              axios.post('/order_new',{
                'idSupplier':data,
                'slug':slug,
              }).then(function(response) {
                if (response.data == true) {
                  console.log('hecho');
                  window.location.href = 'order_page'+'/'+slug;
                }
              });
                       
            },
            
            mySelect(){
              this.$nextTick(() => {
                $('#cliente').DataTable();
              });
            },
            table(){
              $(function(){
                $('#mytable').DataTable();
              });
            },
            toQuotation(data){
              window.location.href = 'quotation_page'+'/'+data;
            },
            has_tax(data){
              this.tax = $("#"+data).val();
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>