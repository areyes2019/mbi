<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div id="app">
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo base_url('/inicio'); ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cotizaciones</li>
        </ol>
    </nav>
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cortizaciones</h1>
    </div>
    <?php if (esc(tiene_permisos(session('id_usuario'),'8','2'))): ?>
    <!-- <button class="btn btn-primary btn-sm rounded-0 shadow-none" data-toggle="modal" data-target="#nueva_cotizacion">Generar cotización</button> -->
    <?php endif ?>
	<div class="my-card mt-3">
		<table id="example" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cotizaciones as $cotizacion): ?>
                <tr>
                    <td><?php echo $cotizacion['id_cotizacion'] ?></td>
                    <td><?php echo $cotizacion['hospital'] ?></td>
                    <td><?php echo $cotizacion['responsable'] ?></td>
                    <td><?php echo date('d-m-y', strtotime($cotizacion['created_at'])); ?></td>

                    <td>
                        <?php 
                        $estatus = asignar_estatus($cotizacion['estatus']);
                        if ($estatus): ?>
                            <span class="badge <?php echo $estatus['estilo']." ".$estatus['icon']?> "> <?php echo $estatus['nombre'] ?></span> 
                        <?php endif ?>        
                    </td>
                    <td class="d-flex justify-content-end">
                        <div class="btn-group dropleft">
                            <button class="btn btn-outline-dark btn-sm rounded-0" data-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu rounded-0">
                                <a href="" class="dropdown-item">Enviar por correo</a>
                                <a href="" class="dropdown-item">Vista previa</a>
                                <a href="" class="dropdown-item">Descargar</a>
                                <!--  Editar -->
                                <a href="<?php echo base_url('pagina_cotizador')."/".$cotizacion['slug']."/".$cotizacion['id_cotizacion']; ?> " class="dropdown-item">Editar</a>
                                <?php if (esc(tiene_permisos(session('id_usuario'),'1','4'))): ?>
                                <!--  Eliminar -->
                                <a href="#" class="dropdown-item" @click.prevent = "eliminar_cotizacion(<?php echo $cotizacion['id_cotizacion'] ?>)">Eliminar</button>
                                <?php endif ?>
                            </div>
                        </div> 
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
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
<!-- Modal -->
<div class="modal fade" id="nueva_cotizacion" tabindex="-1" role="dialog" aria-labelledby="empresaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="empresaModalLabel">Seleccionar Empresa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="empresa">Empresa:</label>
        <select class="form-control" id="empresa" v-model="empresa_seleccionada">
            <option value="" selected disabled>Selecciona una empresa...</option>
            <?php foreach ($entidades as $entidad): ?>
            <option value="<?php echo $entidad['id_entidad'] ?>"><?php echo $entidad['razon_social'] ?></option>
            <?php endforeach ?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" @click = "cotizacion_independiente">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog rounded-0">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="modal" style="width:100%">
            <thead>
                <tr>
                    <th>Hospital</th>
                    <th>Dirigida a:</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo $cliente['hospital'] ?></td>
                    <td><?php echo $cliente['titular'] ?></td>
                    <td>
                        <a href="#" @click.prevent = "cotizacion_independiente(<?php echo $cliente['id_cliente'] ?>)" class="btn btn-primary btn-sm rounded-0"><span class="bi-check-lg"></span></button>
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
    $( document ).ready(function() {
        new DataTable('#modal');
        new DataTable('#example');
    });
</script>
<script src="<?php echo base_url('public/js/cotizaciones.js'); ?>"></script>
<?php echo $this->endSection(); ?>