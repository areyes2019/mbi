<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido') ?>
<!-- Page Heading -->
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Panel Principal</h1>
    <button class="btn btn-primary rounded-0 btn-sm mt-2" data-toggle="modal" data-target="#nuevo_reporte"><span class="bi bi-filetype-pdf"></span> Nueva Solicitud de Diagnóstico</button>
</div>
<div class="w3-bar w3-black">
  <button class="btn btn-primary btn-sm rounded-0 shadow-none" onclick="openCity('s1')">Ordenes de Diagnóstico</button>
  <button class="btn btn-primary btn-sm rounded-0 shadow-none" onclick="openCity('s2')">Diagnosticos</button>
  <button class="btn btn-primary btn-sm rounded-0 shadow-none" onclick="openCity('s3')">Cotizaciones Previas</button>
  <button class="btn btn-primary btn-sm rounded-0 shadow-none" onclick="openCity('s4')">Cotizaciones</button>
  <button class="btn btn-primary btn-sm rounded-0 shadow-none" onclick="openCity('s5')">Facturas</button>
</div>
<div class="row">
   <div class="col-12">
      <!--  esto lo ve el ingeniero y el vendedor -->
      <div id="s1" class="w3-container stage">
        <div class="card card-body rounded-0 mt-3">
            <h3>Ordenes de Diagnóstico</h3>
            <table id="example" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hospital Santa Maria</td>
                    <td>Elena Santos</td>
                    <td>12/12/2024</td>
                    <td>SD</td>
                    <td>
                        <a class="btn btn-primary btn-circle btn-sm" href="" class="btn btn-sm rounded-0 my-btn-success"><span class="bi bi-pencil"></span></a>
                        <a class="btn btn-danger btn-circle btn-sm" href="" class="btn btn-sm rounded-0 my-btn-danger" onclick="return confirm('Esta eliminación no se puede revertir, ¿Deseas continuar?');"><span class="bi bi-trash3"></span></a>
                    </td>
                </tr>
                <tr>
                    <td>Hospital San José</td>
                    <td>Pedro Baltrierrez</td>
                    <td>12/12/2024</td>
                    <td>Entregada</td>
                    <td>
                        <a class="btn btn-primary btn-circle btn-sm" href="" class="btn btn-sm rounded-0 my-btn-success"><span class="bi bi-pencil"></span></a>
                        <a class="btn btn-danger btn-circle btn-sm" href="" class="btn btn-sm rounded-0 my-btn-danger" onclick="return confirm('Esta eliminación no se puede revertir, ¿Deseas continuar?');"><span class="bi bi-trash3"></span></a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                </tr>
            </tfoot>
        </table>
        </div>
      </div>

      <div id="s2" class="w3-container stage" style="display:none">
         <div class="card card-body rounded-0 mt-3">
            <h3>Diagnosticos</h3>
            <table class="table table-bordered">
               <thead class="thead-light">
                   <tr>
                       <th scope="col">ID</th>
                       <th scope="col">Fecha</th>
                       <th scope="col">Elaborado por</th>
                       <th scope="col">Asignado a</th>
                       <th scope="col">Estatus</th>
                       <th></th>
                   </tr>
               </thead>
               <tbody>
                    <tr>
                       <td>1</td>
                       <td>2024-08-15</td>
                       <td>Juan Pérez</td>
                       <td>María García</td>
                       <td><span class="badge badge-dark">Completado</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                    </tr>
                   <tr>
                       <td>2</td>
                       <td>2024-08-16</td>
                       <td>Ana Gómez</td>
                       <td>Carlos López</td>
                       <td><span class="badge badge-success">En Proceso</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
                   <tr>
                       <td>3</td>
                       <td>2024-08-17</td>
                       <td>Pedro Sánchez</td>
                       <td>Luis Ramírez</td>
                       <td><span class="badge badge-primary">Pendiente</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
               </tbody>
            </table>
         </div>
      </div>

      <div id="s3" class="w3-container stage" style="display:none">
         <div class="card card-body rounded-0 mt-3">
            <h3>Cotizaciones previas</h3>
            <table class="table table-bordered">
               <thead class="thead-light">
                   <tr>
                       <th scope="col">ID</th>
                       <th scope="col">Fecha</th>
                       <th scope="col">Elaborado por</th>
                       <th scope="col">Asignado a</th>
                       <th scope="col">Estatus</th>
                       <th></th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>1</td>
                       <td>2024-08-15</td>
                       <td>Juan Pérez</td>
                       <td>María García</td>
                       <td><span class="badge badge-dark">Completado</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
                   <tr>
                       <td>2</td>
                       <td>2024-08-16</td>
                       <td>Ana Gómez</td>
                       <td>Carlos López</td>
                       <td><span class="badge badge-success">En Proceso</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
                   <tr>
                       <td>3</td>
                       <td>2024-08-17</td>
                       <td>Pedro Sánchez</td>
                       <td>Luis Ramírez</td>
                       <td><span class="badge badge-primary">Pendiente</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
               </tbody>
            </table>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, quis. Aliquam alias libero mollitia nemo quidem amet consectetur cupiditate vero!</p>
         </div>
      </div>
      <div id="s3" class="w3-container stage" style="display:none">
         <div class="card card-body rounded-0 mt-3">
            <h3>Cotizaciones Concretadas</h3>
            <table class="table table-bordered">
               <thead class="thead-light">
                   <tr>
                       <th scope="col">ID</th>
                       <th scope="col">Fecha</th>
                       <th scope="col">Elaborado por</th>
                       <th scope="col">Asignado a</th>
                       <th scope="col">Estatus</th>
                       <th></th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>1</td>
                       <td>2024-08-15</td>
                       <td>Juan Pérez</td>
                       <td>María García</td>
                       <td><span class="badge badge-dark">Completado</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
                   <tr>
                       <td>2</td>
                       <td>2024-08-16</td>
                       <td>Ana Gómez</td>
                       <td>Carlos López</td>
                       <td><span class="badge badge-success">En Proceso</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
                   <tr>
                       <td>3</td>
                       <td>2024-08-17</td>
                       <td>Pedro Sánchez</td>
                       <td>Luis Ramírez</td>
                       <td><span class="badge badge-primary">Pendiente</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
               </tbody>
            </table>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, quis. Aliquam alias libero mollitia nemo quidem amet consectetur cupiditate vero!</p>
         </div>
      </div>
      <div id="s4" class="w3-container stage" style="display:none">
         <div class="card card-body rounded-0 mt-3">
            <h3>Facturas</h3>
            <table class="table table-bordered">
               <thead class="thead-light">
                   <tr>
                       <th scope="col">ID</th>
                       <th scope="col">Fecha</th>
                       <th scope="col">Elaborado por</th>
                       <th scope="col">Asignado a</th>
                       <th scope="col">Estatus</th>
                       <th></th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>1</td>
                       <td>2024-08-15</td>
                       <td>Juan Pérez</td>
                       <td>María García</td>
                       <td><span class="badge badge-dark">Completado</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
                   <tr>
                       <td>2</td>
                       <td>2024-08-16</td>
                       <td>Ana Gómez</td>
                       <td>Carlos López</td>
                       <td><span class="badge badge-success">En Proceso</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
                   <tr>
                       <td>3</td>
                       <td>2024-08-17</td>
                       <td>Pedro Sánchez</td>
                       <td>Luis Ramírez</td>
                       <td><span class="badge badge-primary">Pendiente</span></td>
                       <th>
                          <a href="<?php echo base_url('kardex'); ?>" class="btn btn-sm btn-primary"><span class="bi bi-eye"></span></a>
                       </th>
                   </tr>
               </tbody>
            </table>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, quis. Aliquam alias libero mollitia nemo quidem amet consectetur cupiditate vero!</p>
         </div>
      </div>
      <div id="s5" class="w3-container stage" style="display:none">
         <div class="card card-body rounded-0 mt-3">
            <h3>Facturas</h3>
            <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Monto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2024-08-10</td>
                    <td>Empresa ABC</td>
                    <td>Pagado</td>
                    <td>$1,200.00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>2024-08-11</td>
                    <td>Cliente XYZ</td>
                    <td>Pendiente</td>
                    <td>$850.00</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>2024-08-12</td>
                    <td>Corporación MNO</td>
                    <td>Pagado</td>
                    <td>$2,500.00</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>2024-08-13</td>
                    <td>Empresa DEF</td>
                    <td>En Proceso</td>
                    <td>$1,000.00</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>2024-08-14</td>
                    <td>Cliente UVW</td>
                    <td>Pendiente</td>
                    <td>$600.00</td>
                </tr>
            </tbody>
        </table>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, quis. Aliquam alias libero mollitia nemo quidem amet consectetur cupiditate vero!</p>
         </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="nuevo_reporte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog rounded-0">
        <div class="modal-content rounded-0">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Reporte</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table id="modal" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cliente as $data): ?>
                    <tr class="w-100">
                        <td><?php echo $data['titular'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-circle" href="<?php echo base_url('kardex/'). $data['id_cliente'] ; ?>"  class="my-btn-primary p-1"><span class="bi bi-check"></span></a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
</div>
<script>
function openCity(stageLevel) {
  var i;
  var x = document.getElementsByClassName("stage");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(stageLevel).style.display = "block";  
}
$( document ).ready(function() {
    new DataTable('#modal');
    new DataTable('#example');
});
</script>
<?php echo $this->endSection() ?>