<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<style>
    #customAlert {
      position: fixed;
      bottom: -100px; /* Posiciona fuera de la pantalla inicialmente */
      right: 20px;
      opacity: 0;
      transition: bottom 0.7s ease, opacity 0.5s ease;
    }
</style>
<div id="app" class="container-fluid mb-4">
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb rounded-0">
        <li class="breadcrumb-item"><a href="<?php echo base_url('inicio'); ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('clientes'); ?>">Clientes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nuevo Cliente</li>
      </ol>
    </nav>
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Registrar Nuevo Clietne</h1>
    </div>
    <hr>
    <div class="row">
    	<div class="col-md-6 col-12">
			<div class="card rounded-0">
				<div class="card-body">
					<h5 class="m-0">Datos generales</h5>
        			<small>* Datos obligatorios</small>
						<!--  seccion 1 datos generales -->
						<div class="form-group mt-2">
							<div class="input-group">
						        <div class="input-group-prepend input-group-sm">
						          <div class="input-group-text rounded-0">
						          	<i class="bi bi-hospital"></i>
						          </div>
						        </div>
								<input type="text" class="form-control rounded-0 form-control-sm shadow-none"  @input="limpiar_error($event,'hospital')" placeholder="Nombre de la institución *" v-model="form.hospital" name="hospital">
						    </div>
							<small class="text-danger mt-0">{{errores.hospital}}</small>
						</div>
						<div class="form-group mt-2">
							<div class="input-group">
						        <div class="input-group-prepend input-group-sm">
						          <div class="input-group-text rounded-0">
						          	<i class="bi bi-person"></i>
						          </div>
						        </div>
								<input type="text" class="form-control rounded-0 form-control-sm shadow-none"  @input="limpiar_error($event,'titular')" placeholder="Nombre del Dr. o del titular *" v-model="form.titular" name="titular">
						    </div>
							<small class="text-danger mt-0">{{errores.titular}}</small>
						</div>
						<div class="form-group">
							<div class="input-group">
						        <div class="input-group-prepend input-group-sm">
						          <div class="input-group-text rounded-0">
						          	<i class="bi bi-person"></i>
						          </div>
						        </div>
								<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'responsable')" placeholder="Nombre del responsable *" v-model="form.responsable" name="titular">
						    </div>
							<small class="text-danger mt-0">{{errores.responsable}}</small>
						</div>
						<div class="row">
							<div class="col-8">
								<div class="form-group">
									<div class="input-group mb-2">
								        <div class="input-group-prepend input-group-sm">
								          <div class="input-group-text rounded-0">
								          	<i class="bi bi-telephone"></i>
								          </div>
								        </div>
										<input type="text" maxlength="10" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'telefono')" placeholder="Teléfono" v-model="form.telefono" name="telefono">
						    		</div>
									<small class="text-danger">{{errores.telefono}}</small>
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<div class="input-group mb-2">
								        <div class="input-group-prepend input-group-sm">
								          <div class="input-group-text rounded-0">
								          	<i class="bi bi-telephone-plus"></i>
								          </div>
								        </div>
										<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'extencion')" placeholder="Extención" v-model="form.extencion" name="extencion">
								    </div>
									<small class="text-danger">{{errores.extencion}}</small>
								</div>		
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group">
									<div class="input-group mb-2">
								        <div class="input-group-prepend input-group-sm">
								          <div class="input-group-text rounded-0">
								          	<i class="bi bi-phone"></i>
								          </div>
								        </div>
										<input type="text" v-model="form.movil" maxlength="10" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'movil')" placeholder="Teléfono móvil *" id="movil" name="telefono">   
								    </div>
									<small class="text-danger">{{errores.movil}}</small>
								</div>				
							</div>
							<div class="col">
								<div class="form-group">
									<div class="input-group mb-2">
								        <div class="input-group-prepend input-group-sm">
								          <div class="input-group-text rounded-0">
								          	<i class="bi bi-envelope"></i>
								          </div>
								        </div>
										<input type="text" v-model="form.correo" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Correo Elecrtónico" name="correo">   
								    </div>
									<small class="text-danger">{{errores.correo}}</small>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-2">
						        <div class="input-group-prepend input-group-sm">
						          <div class="input-group-text rounded-0">
						          	<i class="bi bi-signpost-split"></i>
						          </div>
						        </div>
								<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Dirección *" v-model="form.direccion" name="direccion">
						    </div>
						</div>
						<div class="form-group">
							<div class="input-group mb-2">
						        <div class="input-group-prepend input-group-sm">
						          <div class="input-group-text rounded-0">
						          	<i class="bi bi-geo"></i>
						          </div>
						        </div>
								<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Ubicación GPS" v-model="form.ubicacion" name="direccion">
						    </div>
						</div>
						<div class="form-group">
							<div class="input-group mb-2">
						        <div class="input-group-prepend input-group-sm">
						          <div class="input-group-text rounded-0">
						          	<i class="bi bi-building"></i>
						          </div>
						        </div>
								<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Facultad" v-model="form.facultad" name="direccion">
						    </div>
						</div>
						<div class="row">
							<div class="col-8">
								<div class="form-group">
									<div class="input-group mb-2">
								        <div class="input-group-prepend input-group-sm">
								          <div class="input-group-text rounded-0">
								          	<i class="bi bi-hospital"></i>
								          </div>
								        </div>
										<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Laboratorio" v-model="form.laboratorio" name="direccion" />
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<div class="input-group mb-2">
								        <div class="input-group-prepend input-group-sm">
								          <div class="input-group-text rounded-0">
								          	<i class="bi bi-building"></i>
								          </div>
								        </div>
										<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Piso" v-model="form.piso" name="extencion">
								    </div>
								</div>				
							</div>
						</div>	
					<button class="btn btn-primary btn-sm rounded-0" @click = "enviar_form">Guardar</button>
				</div>
			</div>
    	</div>
    </div>
	<div id="customAlert" class="alert alert-primary" role="alert">
	    Este es un alert de éxito.
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('public/js/clientes.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<?php echo $this->endSection('contenido')?>
