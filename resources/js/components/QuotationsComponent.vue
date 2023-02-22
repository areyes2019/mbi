<template>
    <div class="container">
        <h3 class="mt-3">Cotizaciones</h3>
        
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4 rounded-0">
                <!-- Card Header - Dropdown -->
                    <div class="card-header rounded-0 ">
                      <!-- cotizar a cliente -->
                      <a class="btn rounded-0 btn-danger btn-sm" href="#" @click.prevent="new_qt">
                        <span class="icon-file-plus icon-my text-white"></span> Nueva Cotización
                      </a>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body rounded-0">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>fecha</th>
                                    <th>empresa</th>
                                    <th>Contacto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="data in general_data">
                                    <td>{{data.idQt}}</td>
                                    <td>{{data.created_at}}</td>
                                    <td>{{data.company}}</td>
                                    <td>{{data.name}}</td>
                                    <td>
                                       <button class="btn btn-danger rounded-0 btn-sm" @click="toQuotation(data.slug)">Ver</button>
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
                <h5 class="modal-title" id="staticBackdropLabel">Seleccionar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <table class="table table-bordered" id="cliente">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Contacto</th>
                            <th>Con Fact.</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in customers_data">
                            <td v-text="data.company"></td> 
                            <td v-text="data.name"></td>
                            <td>
                              <label class="switch">
                                <input type="checkbox"  @click="tax = !tax" :id="data.idContact">
                                <span class="slider"></span>
                              </label>
                            </td> 
                            <td class="d-flex justify-content-end">
                              <button class="btn btn-danger btn-sm rounded-0" @click="makeQt(data.idContact)"><span class="bi bi-check-square"></span></button>
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
              axios.get('/quotations_show').then(function(response) {
                me.general_data = response.data;
                me.table();
              })
            },
            toQuotation(data){
              window.location.href = 'quotation_page'+'/'+data;
            },
            //esta funcion abre el modal clientes y muestra la lista de clientes
            new_qt(){
                let me =this;
                let url = '/contacts_list/'+1 
                //cotizacion a cliente
                axios.get(url).then(function(response) {
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.customers_data = response.data;
                    me.mySelect();
                    $('#exampleModal').modal('show');
                })
            },
            //con esta fun enviamos los datos para iniciar la cotizacion
            makeQt(data){
              //Creamos el slug
              let slug = Math.random().toString(36).substring(3);
              let me = this;
              //seleccionamos el tipo de cotización
              axios.post('/quotations_new',{
                'idCustomer':data,
                'slug':slug,
                'invoice':me.tax,
              }).then(function(response) {
                if (response.data == true) {
                  console.log('hecho');
                  window.location.href = 'quotation_page'+'/'+slug;
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