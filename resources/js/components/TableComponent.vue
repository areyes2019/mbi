<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Componenttt</div>
                    <button class="btn btn-primary" @click="modal()">Modal</button>
                    <div class="card-body">
                        <table class="table table-bordered" id="example"  style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Puesto</th>
                                    <th>Telefono</th>
                                    <th>Ciudad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Alina Ron</td>
                                    <td>678, Hingtyon part</td>
                                    <td>Gerente</td>
                                    <td>5131351351</td>
                                    <td>Sacramento</td>
                                    <td>California</td>
                                </tr><tr>
                                    <td>Kali Ron</td>
                                    <td>678, Hingtyon part</td>
                                    <td>Gerente</td>
                                    <td>5131351351</td>
                                    <td>Sacramento</td>
                                    <td>California</td>
                                </tr><tr>
                                    <td>Elin Ron</td>
                                    <td>678, Hingtyon part</td>
                                    <td>Gerente</td>
                                    <td>5131351351</td>
                                    <td>Sacramento</td>
                                    <td>California</td>
                                </tr><tr>
                                    <td>Barbara Ron</td>
                                    <td>678, Hingtyon part</td>
                                    <td>Gerente</td>
                                    <td>5131351351</td>
                                    <td>Sacramento</td>
                                    <td>California</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Launch demo modal
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import DataTable from 'datatables.net-bs5'
    export default {
        data(){
            return{

            }
        },
        methods:{
            table(){
                $(document).ready(function () {
                    $('#example').DataTable();
                });
            },
            modal(){
               $('#exampleModal').modal('show'); 
            }
        },
        mounted(){
            this.table();
        }
    }
</script>