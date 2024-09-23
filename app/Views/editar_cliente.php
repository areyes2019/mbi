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
		<h2>Editar Cliente: <?php echo $nombre?></h2>
		<hr>
	</div>
	<div class="row">
    	<div class="col-md-6 col-12">
			<div class="card rounded-0">
		    <p class="d-none" ref="cliente"><?php echo $id_cliente ?></p>
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		            <h6 class="m-0 font-weight-bold text-primary"></h6>
		            <div class="dropdown no-arrow">
		                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
		                </a>
		                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
		                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#agregar_datos_fiscales" v-if="<?php echo $si_hay_datos ?> == 0" ><span class="bi bi-receipt-cutoff"></span> Agregar Datos Fiscales</a>
		                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#actualizar_datos_fiscales" @click="mostrar_datos_fiscales('<?php echo $id_cliente ?>')" v-if="<?php echo $si_hay_datos ?> == 1" ><span class="bi bi-pencil"></span> Actualizar Datos Fiscales</a>
		                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#horarios" v-if="vista==0" ><span class="bi bi-plus-circle"></span> Agregar Horarios de Atención</a>
		                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modificar_horarios" v-else><span class="bi bi-pencil"></span> Modificar Horarios de Atención</a>
		                    <div class="dropdown-divider"></div>
		                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#equipos"><span class="bi bi-gear"></span> Agregar Equipos</a>
		                </div>
		            </div>
		        </div>
				<div class="card-body" v-for = "data in editar">
					<!--  seccion 1 datos generales -->
					<div class="form-group mt-2">
						<div class="input-group">
					        <div class="input-group-prepend input-group-sm">
					          <div class="input-group-text rounded-0">
					          	<i class="bi bi-hospital"></i>
					          </div>
					        </div>
							<input type="text" class="form-control rounded-0 form-control-sm shadow-none"   placeholder="Nombre de hospital o institución *" v-model="data.hospital">
					    </div>
					</div>
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
					<div class="form-group">
						<div class="input-group mb-2">
					        <div class="input-group-prepend input-group-sm">
					          <div class="input-group-text rounded-0">
					          	<i class="bi bi-geo"></i>
					          </div>
					        </div>
							<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Facultad" v-model="data.facultad">
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
    	<div class="col-md-4 col-12">
    			<div class="card rounded-0" v-if="vista > 0">
    				<div class="card-header bg-primary rounded-0">
    					<p class="m-0 card-title text-white">Horarios de Atención</p>
    				</div>
    				<div class="card-body">
    					<table class="table">
    						<tr>
    							<th>Dia</th>
    							<th>De:</th>
    							<th>A:</th>
    							<th></th>
    						</tr>
    						<tr v-for="hora in horarios">
    							<td>{{hora.dia}}</td>
    							<td>{{formatTo12Hour(hora.hora_inicio)}}</td>
    							<td>{{formatTo12Hour(hora.hora_fin)}}</td>
    							<td>
    								<a href="#" @click.prevent="eliminar_horario(hora.id_horario)"><span class="bi bi-x-lg"></span></a>
    							</td>
    						</tr>
    					</table>
    					<button class="btn btn-primary btn-sm rounded-0 shadow-none" data-toggle="modal" data-target="#horarios">Agregar horario</button>
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
			    		<form @submit.prevent="enviarDatos" id="myForm">
		            <button type="button" class="btn btn-primary mt-3 mb-4" @click="agregarCampo">Agregar Horario</button>
		            <div v-for="(campo, index) in campos" :key="index" class="form-row align-items-end mb-3">
		                <div class="col-md-4">
		                    <select v-model="campo.dia" class="form-control" :name="'dia' + (index + 1)">
		                        <option v-for="dia in diasSemana" :key="dia" :value="dia">{{ dia }}</option>
		                    </select>
		                </div>
		                <div class="col-md-3">
		                    <input type="time" v-model="campo.horaInicio" class="form-control" :name="'horaInicio' + (index + 1)">
		                </div>
		                <div class="col-md-3">
		                    <input type="time" v-model="campo.horaFin" class="form-control" :name="'horaFin' + (index + 1)">
		                </div>
		                <div class="col-md-2">
		                    <button type="button" class="btn btn-danger" @click="eliminarCampo(index)">Eliminar</button>
		                </div>
		            </div>
		            <br><br>
		            <button type="submit" class="btn btn-success">Enviar</button>
		        	</form>    
	      		</div>
	      	</div>
	    </div>
    </div>
    <!--  Modal agregar horario -->

     <!--  Modal modificar horario -->
    <div class="modal fade" id="modificar_horarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-lg">
	    	<div class="modal-content rounded-0">
	    		<div class="modal-header">
	  				<h5 class="modal-title">Modificar Horarios</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
	    		</div>
      		<div class="modal-body p-3">
      			<div class="row" v-for = "tiempo in horarios">
	      			<div class="col-md-4 mb-2">
				    		<select name="" id="" class="form-select" v-model="tiempo.dia">
				    				<option v-for="dia_dos in diasSemana" :key="dia_dos" :value="dia_dos">{{dia_dos}}</option>
				    		</select>
	      			</div>
	      			<div class="col-md-3 mb-2">
				    		<input type="time" class="form-control" v-model="tiempo.hora_inicio">
	      			</div>
			    		<div class="col-md-3 mb-2">
				    		<input type="time" class="form-control" v-model="tiempo.hora_fin">
	      			</div>
	      			<div class="col-md-2 mb-2">
	      				<button class="btn btn-primary btn-sm rounded-0" @click="actualizar_hora(tiempo.id_horario)"><span class="bi bi-check"></span></button>
	      			</div>
      			</div>
      		</div>
	      	</div>
	    </div>
    </div>
    <!--  Modal modificar horario -->


    <!--  Modal agregar datos fiscales -->
    <div class="modal fade" id="agregar_datos_fiscales" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content rounded-0">
              <div class="modal-body">
                  <h4>Datos Fiscales</h4>
                  <!-- contacto -->
                  <!-- Regimen Fiscasl -->
                  <div class="form-group">
	                  	<select class="selectpicker form-control" id="picker_agregar" data-live-search="true" v-model="regimen" style="width: 100%;">
	                  		<option disabled selected value=""> Selecciona el régimen... </option>
	                  		<?php foreach ($regimenes as $regimen): ?>
	                      <option :value='<?php echo $regimen['codigo'] ?>'><?php echo $regimen['codigo'] ?> - <?php echo $regimen['nombre'] ?></option>
	                      <?php endforeach ?>
								    	</select>
                      <small class="text-danger">{{errores.regimen}}</small>                      
                  </div>
                  <!--  Razon social -->
                  <div class="form-group">
                      <div class="input-group">
                          <div class="input-group-prepend input-group-sm">
                            <div class="input-group-text rounded-0">
                              <i class="bi bi-person"></i>
                            </div>
                          </div>
                          <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'nombre')" placeholder="Nombre o razón social *" v-model="nombre" name="empresa">
                      </div>
                      <small class="text-danger mt-0">{{errores.nombre}}</small>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'correo')" placeholder="Correo Elecrtónico" v-model="correo" name="correo">
                              </div>
                              <small class="text-danger mt-0">{{errores.correo}}</small>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" maxlength="13" @input="limpiar_error($event,'rfc')" placeholder="RFC *" v-model="rfc" name="rfc">
                              </div>
                              <small class="text-danger mt-0">{{errores.rfc}}</small>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Calle" v-model="calle">
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Num Int *" v-model="numero_ext" name="int">
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Num Ext. *" v-model="numero_int" name="ext">
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Colonia" v-model="colonia">
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'cp')" placeholder="Código Postal *" v-model="cp" name="zip">
                              </div>
                              <small class="text-danger mt-0">{{errores.cp}}</small>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Ciudad *" v-model="ciudad">
                              </div>
                              <small class="text-danger mt-0"></small>
                          </div>
                      </div>
                      <div class="col-6">
                          <select v-model="estado"  id="estados" class="form-control">
                              <option value=""></option>
                              <option v-for="estado in estados" :key="estado" :value="estado.abreviatura">{{ estado.nombre}}</option>
                          </select>
                      </div>

                  </div>
                  <button class="btn btn-primary btn-sm rounded-0" @click = "agregar_direccion_fiscal">Guardar</button>
              </div>
          </div>
      </div>
    </div>
    <!--  Agregar datos fiscales -->

    <!--  actualizar datos fiscales -->
    <div class="modal fade" id="actualizar_datos_fiscales" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content rounded-0">
              <div class="modal-body" v-for = "fiscales in editar_datos_fiscales">
                  <h4>Datos Fiscales</h4>
                  <!-- contacto -->
                  <!-- Regimen Fiscasl -->
                  <div class="form-group">
                  		<select class="form-select rounded-0" v-model="fiscales.regimen" >
	                  		<?php foreach ($regimenes as $data): ?>
	                      <option :value='<?php echo $data['codigo'] ?>'><?php echo $data['codigo'] ?> - <?php echo $data['nombre'] ?></option>
	                      <?php endforeach ?>
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
                          <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Nombre o razón social *" v-model="fiscales.nombre">
                      </div>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Correo Elecrtónico *" v-model="fiscales.correo">
                              </div>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" maxlength="12" @input="limpiar_error($event,'contacto')" placeholder="RFC *" v-model="fiscales.rfc">
                              </div>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Calle" v-model="fiscales.calle">
                              </div>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Num Int *" v-model="fiscales.numero_ext">
                              </div>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Num Ext. *" v-model="fiscales.numero_int">
                              </div>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Colonia" v-model="fiscales.colonia">
                              </div>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Código Postal *" v-model="fiscales.cp">
                              </div>
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
                                  <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Ciudad *" v-model="fiscales.ciudad">
                              </div>
                          </div>
                      </div>
                      <div class="col-6">
                          <select v-model="fiscales.estado"  id="estados" class="custom-select custom-select-sm rounded-0">
                              <option v-for="estado in estados" :key="estado" :value="estado.abreviatura">{{ estado.nombre}}</option>
                          </select>
                      </div>

                  </div>
                  <button class="btn btn-primary btn-sm rounded-0" @click = "actualizar_datos_fiscales">Guardar</button>
              </div>
          </div>
      </div>
    </div>
    <!--  actualizar datos fiscales -->
    
    <!--  Modal agregar equipos -->
    <div class="modal fade" id="equipos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">		
	  	<div class="modal-dialog modal-lg">
	    	<div class="modal-content rounded-0">
	    		<div class="modal-header">
	  				<h5 class="modal-title">Agregar Equipos</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
	    		</div>
      		<div class="modal-body p-3">
				      <div class="form-group">
				        <label for="equipo">Equipo</label>
				        <input type="text" class="form-control rounded-0  shadow-none" @input="limpiar_error_equipo($event,'equipo')" id="equipo" v-model="formulario.equipo" placeholder="Ingrese el nombre del equipo">
				        <small class="text-danger mt-0">{{errores.equipo}}</small>
				      </div>
				      <div class="row">
					      <div class="col">
						      <div class="form-group">
						        <label for="marca">Marca</label>
						        <input type="text" class="form-control rounded-0  shadow-none" @input="limpiar_error_equipo($event,'marca')" id="marca" v-model="formulario.marca" placeholder="Ingrese la marca">
						        <small class="text-danger mt-0">{{errores.marca}}</small>
						      </div>
					      </div>
					      <div class="col">
						      <div class="form-group">
						        <label for="modelo">Modelo</label>
						        <input type="text" class="form-control rounded-0  shadow-none" @input="limpiar_error_equipo($event,'modelo')" id="modelo" v-model="formulario.modelo" placeholder="Ingrese el modelo">
						        <small class="text-danger mt-0">{{errores.modelo}}</small>
						      </div>
					      </div>
				      </div>
				      <div class="row">
				      	<div class="col">
						      <div class="form-group">
						        <label for="inventario">Inventario</label>
						        <input type="text" class="form-control rounded-0  shadow-none" @input="limpiar_error_equipo($event,'inventario')" id="inventario" v-model="formulario.inventario" placeholder="Ingrese el número de inventario">
						        <small class="text-danger mt-0">{{errores.inventario}}</small>
						      </div>
				      	</div>
				      	<div class="col">
						      <div class="form-group">
						        <label for="noSerie">No. de Serie</label>
						        <input type="text" class="form-control rounded-0 shadow-none" @input="limpiar_error_equipo($event,'serie')" id="noSerie" v-model="formulario.noSerie" placeholder="Ingrese el número de serie">
						        <small class="text-danger mt-0">{{errores.serie}}</small>
						      </div>
				      	</div>
				      </div>
				      <div class="form-group">
				        <label for="foto">Foto</label>
				        <input type="file" class="form-control-file" id="foto" @change="subir_imagen" accept="image/jpeg, image/png">
				        <small class="text-danger mt-0">{{errores.imagen}}</small>
				      </div>
				      <button class="btn btn-primary rounded-0 btn-sm" @click="agregar_equipo" >Enviar</button>
	      	</div>
	    	</div>
    </div>
    <!--  Modal modificar horario -->
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('public/js/editar_cliente.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/form_horarios.js'); ?>"></script>
<?php echo $this->endSection()?>