<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container-fluid mt-3" id="app">
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb rounded-0">
        <li class="breadcrumb-item"><a href="<?php echo base_url('inicio'); ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('clientes'); ?>">Clientes</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $nombre?></li>
      </ol>
    </nav>
	<div class="my-card">
		<h2>Editar Cliente</h2>
		<hr>
	</div>
	<div class="row">
    	<div class="col-md-6 col-12">
			<div class="card rounded-0">
		            <p class="d-none" ref="cliente"><?php echo $id_cliente ?></p>
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		            <h6 class="m-0 font-weight-bold text-primary"><?php echo $nombre?></h6>
		            <div class="dropdown no-arrow">
		                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
		                </a>
		                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
		                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#datos">Agregar Datos Fiscales</a>
		                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#horarios">Agregar Horarios de Atención</a>
		                    <div class="dropdown-divider"></div>
		                    <a class="dropdown-item" href="#">Something else here</a>
		                </div>
		            </div>
		        </div>
				<div class="card-body" v-for = "data in editar">
					<!--  seccion 1 datos generales -->
					<div class="form-group mt-2">
						<div class="input-group">
					        <div class="input-group-prepend input-group-sm">
					          <div class="input-group-text rounded-0">
					          	<i class="bi bi-person"></i>
					          </div>
					        </div>
							<input type="text" class="form-control rounded-0 form-control-sm shadow-none"   placeholder="Nombre del Dr. o del titular *" v-model="data.titular">
					    </div>
					</div>
					<div class="form-group">
						<div class="input-group">
					        <div class="input-group-prepend input-group-sm">
					          <div class="input-group-text rounded-0">
					          	<i class="bi bi-person"></i>
					          </div>
					        </div>
							<input type="text" class="form-control rounded-0 form-control-sm shadow-none"  placeholder="Nombre del responsable *" v-model="data.responsable">
					    </div>
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
									<input type="text" maxlength="10" class="form-control rounded-0 form-control-sm shadow-none"  placeholder="Teléfono" v-model="data.telefono">
					    		</div>
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
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none"  placeholder="Extención" v-model="data.extencion" >
							    </div>
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
									<input type="text" v-model="data.movil" maxlength="10" class="form-control rounded-0 form-control-sm shadow-none"  placeholder="Teléfono móvil *" id="movil">   
							    </div>
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
									<input type="text" v-model="data.correo" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Correo Elecrtónico">   
							    </div>
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
							<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Dirección *" v-model="data.direccion">
					    </div>
					</div>
					<div class="form-group">
						<div class="input-group mb-2">
					        <div class="input-group-prepend input-group-sm">
					          <div class="input-group-text rounded-0">
					          	<i class="bi bi-geo"></i>
					          </div>
					        </div>
							<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Ubicación" v-model="data.ubicacion">
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
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Laboratorio" v-model="data.laboratorio">
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
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Piso" v-model="data.piso">
							    </div>
							</div>				
						</div>
					</div>	
					<button class="btn btn-primary btn-sm rounded-0" @click = "actualizar_cliente">Actualizar</button>
				</div>
			</div>
    	</div>
    </div>
    
    <!--  Modal agregar horario -->
    <div class="modal fade" id="horarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-lg">
	    	<div class="modal-content rounded-0">
	    		<div class="modal-header">
	  				<h5 class="modal-title">Horarios de Atención</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
	    		</div>
	      		<div class="modal-body p-3">
			        <button class="btn btn-primary btn-sm rounded-0 mb-2" type="button" onclick="agregarCampo()">Agregar Horario</button>
				        <!-- Grupo de campos 1 -->
			            <div class="form-row align-items-end mb-3">
			                <div class="col-md-4">
			                    <label for="dia1">Día de la Semana</label>
			                    <select id="dia1" name="dia1" class="form-control">
			                        <option value="Lunes">Lunes</option>
			                        <option value="Martes">Martes</option>
			                        <option value="Miércoles">Miércoles</option>
			                        <option value="Jueves">Jueves</option>
			                        <option value="Viernes">Viernes</option>
			                        <option value="Sábado">Sábado</option>
			                        <option value="Domingo">Domingo</option>
			                    </select>
			                </div>
			                <div class="col-md-3">
			                    <label for="horaInicio1">De:</label>
			                    <input type="time" id="horaInicio1" name="horaInicio1" class="form-control">
			                </div>
			                <div class="col-md-3">
			                    <label for="horaFin1">A:</label>
			                    <input type="time" id="horaFin1" name="horaFin1" class="form-control">
			                </div>
			            </div>
				        <div id="contenedorCampos">
				        <!-- Los campos dinámicos se agregarán aquí -->
				        </div>
				        <button class="btn btn-primary btn-sm rounded-0">Guardar</button>
	      		</div>
	      	</div>
	    </div>
    </div>
    <!--  Modal agregar horario -->

	<div class="modal fade" id="datos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  	<div class="modal-dialog">
	    	<div class="modal-content rounded-0">
	      		<div class="modal-body">
		      		<h4>Datos Fiscales</h4>
			      	<!-- contacto -->
			      	<!-- Regimen Fiscasl -->
					<div class="form-group">
						<select name="regimen-fiscal" id="regimen-fiscal" style="width:100%">
						    <option value=""></option>
						    <option value="601">601 - General de Ley Personas Morales</option>
						    <option value="603">603 - Personas Morales con Fines no Lucrativos</option>
						    <option value="605">605 - Sueldos y Salarios e Ingresos Asimilados a Salarios</option>
						    <option value="606">606 - Arrendamiento</option>
						    <option value="607">607 - Régimen de Enajenación o Adquisición de Bienes</option>
						    <option value="608">608 - Demás ingresos</option>
						    <option value="609">609 - Consolidación</option>
						    <option value="610">610 - Residentes en el Extranjero sin Establecimiento Permanente en México</option>
						    <option value="611">611 - Ingresos por Dividendos (socios y accionistas)</option>
						    <option value="612">612 - Personas Físicas con Actividades Empresariales y Profesionales</option>
						    <option value="614">614 - Ingresos por Intereses</option>
						    <option value="615">615 - Régimen de los ingresos por obtención de premios</option>
						    <option value="616">616 - Sin obligaciones fiscales</option>
						    <option value="620">620 - Sociedades Cooperativas de Producción que optan por diferir sus ingresos</option>
						    <option value="621">621 - Incorporación Fiscal</option>
						    <option value="622">622 - Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras</option>
						    <option value="623">623 - Opcional para Grupos de Sociedades</option>
						    <option value="624">624 - Coordinados</option>
						    <option value="625">625 - Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas</option>
						    <option value="626">626 - Régimen Simplificado de Confianza</option>
						</select>
					</div>
					<!--  Razon social -->
					<div class="form-group">
						<div class="input-group">
					        <div class="input-group-prepend input-group-sm">
					          <div class="input-group-text rounded-0">
					          	<i class="bi bi-person"></i>
					          </div>
					        </div>
							<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Nombre o razón social *" v-model="form.contacto">
			    		</div>
						<small class="text-danger mt-0"></small>
					</div>
					<div class="row">
						<div class="col">
							<!--  correo  -->
							<div class="form-group">
								<div class="input-group">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-person"></i>
							          </div>
							        </div>
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Correo Elecrtónico *" v-model="form.contacto">
					    		</div>
								<small class="text-danger mt-0"></small>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<!-- RFC -->
								<div class="input-group">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-person"></i>
							          </div>
							        </div>
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" maxlength="12" @input="limpiar_error($event,'contacto')" placeholder="RFC *" v-model="form.contacto">
					    		</div>
								<small class="text-danger mt-0"></small>
							</div>
						</div>
					</div>
					<div class="row"> <!-- row  -->
						<div class="col-6">
							<div class="form-group">
								<!-- Calle  -->
								<div class="input-group">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-person"></i>
							          </div>
							        </div>
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Calle" v-model="form.contacto">
					    		</div>
								<small class="text-danger mt-0"></small>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group">
								<div class="input-group">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-person"></i>
							          </div>
							        </div>
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Num Int *" v-model="form.contacto">
					    		</div>
								<small class="text-danger mt-0"></small>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group">
								<div class="input-group">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-person"></i>
							          </div>
							        </div>
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Num Ext. *" v-model="form.contacto">
					    		</div>
								<small class="text-danger mt-0"></small>
							</div>
						</div>
					</div> <!--  row -->
					<div class="row">
						<div class="col">
							<div class="form-group">
								<div class="input-group">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-person"></i>
							          </div>
							        </div>
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Colonia" v-model="form.contacto">
					    		</div>
								<small class="text-danger mt-0"></small>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<div class="input-group">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-person"></i>
							          </div>
							        </div>
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Código Postal *" v-model="form.contacto">
					    		</div>
								<small class="text-danger mt-0"></small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<div class="input-group">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-person"></i>
							          </div>
							        </div>
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Ciudad *" v-model="form.contacto">
					    		</div>
								<small class="text-danger mt-0"></small>
							</div>
						</div>
						<div class="col-6">
							<select v-model="form.estado"  id="estados" class="form-control">
							  	<option value=""></option>
							  	<option value="AGS">Aguascalientes</option>
						  		<option value="BC">Baja California</option>
						  		<option value="BCS">Baja California Sur</option>
						  		<option value="CAMP">Campeche</option>
						  		<option value="CHIS">Chiapas</option>
						  		<option value="CHIH">Chihuahua</option>
						  		<option value="CDMX">Ciudad de México</option>
						  		<option value="COAH">Coahuila</option>
						  		<option value="COL">Colima</option>
						  		<option value="DGO">Durango</option>
						  		<option value="GTO">Guanajuato</option>
						  		<option value="GRO">Guerrero</option>
						  		<option value="HGO">Hidalgo</option>
						  		<option value="JAL">Jalisco</option>
						  		<option value="MEX">México</option>
						  		<option value="MICH">Michoacán</option>
						  		<option value="MOR">Morelos</option>
						  		<option value="NAY">Nayarit</option>
						  		<option value="NL">Nuevo León</option>
						  		<option value="OAX">Oaxaca</option>
						  		<option value="PUE">Puebla</option>
						  		<option value="QRO">Querétaro</option>
						  		<option value="QR">Quintana Roo</option>
						  		<option value="SLP">San Luis Potosí</option>
						  		<option value="SIN">Sinaloa</option>
						  		<option value="SON">Sonora</option>
						  		<option value="TAB">Tabasco</option>
						  		<option value="TAMPS">Tamaulipas</option>
						  		<option value="TLAX">Tlaxcala</option>
						  		<option value="VER">Veracruz</option>
						  		<option value="YUC">Yucatán</option>
						  		<option value="ZAC">Zacatecas</option>
							</select>
						</div>

					</div>
					<button class="btn btn-primary btn-sm rounded-0">Guardar</button>
	      		</div>
	    	</div>
	  	</div>
	</div>
	</div>
	<script>
		$(document).ready(function() {
		  $('#datos').on('shown.bs.modal', function () {
		    $('#estados').select2({
		      allowClear: true,
		      placeholder: 'Selecciona un estado',
		      dropdownParent: $('#datos')
		    });
		    $('#regimen-fiscal').select2({
		      allowClear: true,
		      placeholder: 'Selecciona el régimen fiscal',
		      dropdownParent: $('#datos')
		    });
		  });
		});

		
	</script>
<script type="text/javascript" src="<?php echo base_url('public/js/clientes.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/form_horarios.js'); ?>"></script>
<?php echo $this->endSection()?>