<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div id="app" class="container-fluid mb-4">
	<h1 class="h3 mb-4 text-gray-800">Ordenes de Servicio</h1>
	<nav aria-label="breadcrumb">
    <ol class="breadcrumb rounded-0">
      <li class="breadcrumb-item"><a href="<?php echo base_url('inicio'); ?>">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Ordenes de servicio</li>
    </ol>
  </nav>
  <div class="card">
  	<div class="card-body">
  		<div class="mobile">
        <ul class="list-group">
            <?php foreach ($resultado as $mis_tareas): ?>
            <li class="list-group-item">
                <?php 
                $estatus = asignar_estatus($mis_tareas['estatus']);
                if ($estatus): ?>
                    <span class="badge <?php echo $estatus['estilo']." ".$estatus['icon']?> "> <?php echo $estatus['nombre'] ?></span> 
                <?php endif ?>
                <br>
                <?php
                $fecha_original = $mis_tareas['created_at'];
                $fecha_formateada = date("d-m-Y", strtotime($fecha_original));
                echo $fecha_formateada;
                ?>
                <p class="m-0"><strong>Hospital</strong></p>
                <?php echo $mis_tareas['hospital'] ?>
                <p class="m-0"><strong>Generado por:</strong></p>
                <?php echo $mis_tareas['generado_nombre'] ?>
                <br>
                <span v-if="<?php echo $mis_tareas['tipo'] ?> == 1" class="badge badge-pill badge-custom-yellow "><?php echo $mis_tareas['tipo_txt'] ?></span>
                <span v-else-if="<?php echo $mis_tareas['tipo'] ?> == 2" class="badge badge-pill badge-custom-orange "><?php echo $mis_tareas['tipo_txt'] ?></span>
                <span v-else-if="<?php echo $mis_tareas['tipo'] ?> == 3" class="badge badge-pill badge-custom-blue "><?php echo $mis_tareas['tipo_txt'] ?></span>
                <span v-else-if="<?php echo $mis_tareas['tipo'] ?> == 4" class="badge badge-pill badge-custom-aqua "><?php echo $mis_tareas['tipo_txt'] ?></span>
                <br>
                <?php if (esc(tiene_permisos(session('id_usuario'),'1','4'))): ?>
                <!--  Eliminar -->
                <button class="btn btn-danger btn-sm shadow-none mr-1" @click = "eliminar_kardex(<?php echo $mis_tareas['id_kardex'] ?>)"><span class="bi bi-trash3"></span></button>
                <?php endif ?>

                <?php if (esc(tiene_permisos(session('id_usuario'),'1','2'))|| esc(es_super_admin())): ?>    
                <!--  Editar -->
                <button  class="btn btn-primary btn-sm shadow-none mr-1" @click = "editar_kardex('<?php echo $mis_tareas['id_kardex'] ?>')"><span class="bi bi-pencil"></span></button>
                <?php endif ?>

                <?php if (esc(tiene_permisos(session('id_usuario'),'1','1'))|| esc(es_super_admin())): ?>
                <!--  Vista Rápida -->
                <button class="btn btn-success btn-sm shadow-none"@click="ver_doc('<?php echo $mis_tareas['slug'] ?>')" data-toggle="modal" data-target="#ver_doc"><span class="bi bi-eye"></span></button>
                <?php endif ?>
            </li>
            <?php endforeach ?>        
        </ul>
    </div>
    <div class="main-pc">        
        <table id="personal" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Clientess</th>
                    <th>Elaborado por:</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Tipo</th>
                    <th>Asignado a:</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $mis_tareas): ?>
                <tr>
                    <td><?php echo $mis_tareas['id_kardex'] ?></td>
                    <td><?php echo $mis_tareas['hospital'] ?></td>
                    <td><?php echo $mis_tareas['generado_nombre'] ?></td>
                    <td>
                        <?php
                        $fecha_original = $mis_tareas['created_at'];
                        $fecha_formateada = date("d-m-Y", strtotime($fecha_original));
                        echo $fecha_formateada;
                        ?>
                    </td>
                    <td>
                        <?php 
                        $estatus = asignar_estatus($mis_tareas['estatus']);
                        if ($estatus): ?>
                            <span class="badge <?php echo $estatus['estilo']." ".$estatus['icon']?> "> <?php echo $estatus['nombre'] ?></span> 
                        <?php endif ?>


                    </td>
                    <td>
                        <?php if ($mis_tareas['tipo']==1): ?>
                        <span class="badge badge-danger"><?= $mis_tareas['tipo_txt']?></span>
                        <?php endif ?>
                        <?php if ($mis_tareas['tipo']==2): ?>
                        <span class="badge badge-warning text-dark"><?= $mis_tareas['tipo_txt']?></span>
                        <?php endif ?>
                        <?php if ($mis_tareas['tipo']==3): ?>
                        <span class="badge badge-primary"><?= $mis_tareas['tipo_txt']?></span>
                        <?php endif ?>
                        <?php if ($mis_tareas['tipo']==4): ?>
                        <span class="badge badge-success"><?= $mis_tareas['tipo_txt']?></span>
                        <?php endif ?>

                    </td>
                    <td><strong><?php echo $mis_tareas['nombre']." ".$mis_tareas['apellidos'] ?></strong></td> <!--  asignado a: -->
                    <td>

                        <div class="btn-group dropleft">
                            <button class="btn btn-outline-dark btn-sm rounded-0" data-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu rounded-0">
                                <?php if (esc(tiene_permisos(session('id_usuario'),'1','2'))|| esc(es_super_admin())): ?>    
                                <!--  Editar -->
                                <a href="<?php echo base_url('/kardex/'.$mis_tareas['slug']); ?>" class="dropdown-item">Editar</a>
                                <?php endif ?>

                                <?php if (esc(tiene_permisos(session('id_usuario'),'1','1'))|| esc(es_super_admin())): ?>
                                <!--  Vista Rápida -->
                                <a href="#" class="dropdown-item" @click.prevent="ver_doc('<?php echo $mis_tareas['slug'] ?>')" data-toggle="modal" data-target="#ver_doc">Vista Rápida</a>
                                <?php endif ?>

                                <?php if (esc(tiene_permisos(session('id_usuario'),'1','4'))|| esc(es_super_admin())): ?>
                                <!--  Eliminar -->
                                <a href="#" class="dropdown-item" @click.prevent = "eliminar_kardex(<?php echo $mis_tareas['id_kardex'] ?>)">Eliminar</a>
                                <?php endif ?>
                                
                            </div>
                        </div> 
                    </td>
                </tr>
                <?php endforeach ?>        
            </tbody>
        	</table>
    	</div>		
  	</div>
  </div>
</div> 
<script type="text/javascript">
	$( document ).ready(function() {
    new DataTable('#personal');
	});
</script>   
<?php echo $this->endSection('contenido')?>
