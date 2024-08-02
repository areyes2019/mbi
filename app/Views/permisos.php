<?php echo $this->extend('panel_template') ?>
<?php echo $this->section('contenido')?>
<div class="container-fluid" id="app">
	<div class="row column_title">
        <div class="col-md-12">
            <div class="page_title">
            	<p></p>
            	<?php foreach ($usuario as $data):?>
                <h2><?php echo $data['nombre']?></h2>
                <p class="d-none" ref="usuario"><?php echo $data['id'] ?></p>
            	<?php endforeach?>
            </div>
        </div>
    </div>
    <div class="card">
    	<div class="card-body">
    		<table class="table table-bordered">
    			<tr>
    				<th>Módulo</th>
    				<th>Ver</th>
    				<th>Crear</th>
    				<th>Actualizar</th>
    				<th>Eliminar</th>
    			</tr>
    			<tr v-for='data in permisos'>
    					
    				<td>
    					{{data.nombre}}
    				</td>
    				<!--  leer -->
    				<td v-if="data.leer == 1">
    					<label class="switch">
						 	<input type="checkbox" checked :ref="data.id_permiso" @change="cambiar_leer(data.id_permiso)" :value="data.leer">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-else>
    					<label class="switch">
						 	<input type="checkbox" :ref="data.id_permiso" @change="cambiar_leer(data.id_permiso)" :value="data.leer">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<!--  leer -->

    				<!-- crear -->
    				<td v-if="data.crear == 1">
    					<label class="switch">
						 	<input type="checkbox" checked :ref="data.id_permiso" @change="cambiar_crear(data.id_permiso)" :value="data.crear">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-else>
    					<label class="switch">
						 	<input type="checkbox" :ref="data.id_permiso" @change="cambiar_crear(data.id_permiso)" :value="data.crear">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<!-- crear -->
    				<td v-if="data.actualizar == 1">
    					<label class="switch">
						 	<input type="checkbox" checked :ref="data.id_permiso" @change="cambiar_actualizar(data.id_permiso)">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-else>
    					<label class="switch">
						 	<input type="checkbox" :ref="data.id_permiso" @change="cambiar_actualizar(data.id_permiso)">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-if="data.eliminar == 1">
    					<label class="switch">
						 	<input type="checkbox" checked :ref="data.id_permiso" @change="cambiar_eliminar(data.id_permiso)">
						  	<span class="slider"></span>
						</label>
    				</td>
    				<td v-else>
    					<label class="switch">
						 	<input type="checkbox" :ref="data.id_permiso" @change="cambiar_eliminar(data.id_permiso)">
						  	<span class="slider"></span>
						</label>
    				</td>
    				
    			</tr>
    		</table>
		</div>
    </div>
</div>
<script src="<?php echo base_url('public/js/permisos.js'); ?>"></script>
<?php echo $this->endSection()?>