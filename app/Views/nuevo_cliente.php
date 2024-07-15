<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div id="app">
<div class="container-fluid">
	<div class="row column_title">
        <div class="col-md-12">
            <div class="page_title">
                <h2>Nuevo Cliente</h2>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-6">
		    <div class="card card-body rounded-0 p-4">
		    	<form action="#" @submit.prevent="enviar_form" :class="[display_form_one]">
					<!-- Datos del cliente -->
					<h5 class="mt-0">Datos del cliente</h5>
					<div class="form-group">
						<div class="input-group mb-2">
					        <div class="input-group-prepend input-group-sm">
					          <div class="input-group-text rounded-0">
					          	<i class="bi bi-building"></i>
					          </div>
					        </div>
							<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Nombre de la Empresa" v-model="form.empresa">
					    </div>
						<small class="text-danger">{{errores.empresa}}</small>
					</div>
					<!-- contacto -->
					<div class="row">
						<div class="col">
							<div class="form-group">
								<div class="input-group mb-2">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-person"></i>
							          </div>
							        </div>
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Nombre del contacto" v-model="form.contacto">
					    		</div>
								<small class="text-danger">{{errores.contacto}}</small>
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
									<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Correo" v-model="form.correo">
							    </div>
								<small class="text-danger">{{errores.correo}}</small>
							</div>		
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<div class="input-group mb-2">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-telephone"></i>
							          </div>
							        </div>
									<input type="text" v-model="form.fijo" maxlength="10" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Telefono fijo">   
							    </div>
								<small class="text-danger">{{errores.fijo}}</small>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<div class="input-group mb-2">
							        <div class="input-group-prepend input-group-sm">
							          <div class="input-group-text rounded-0">
							          	<i class="bi bi-phone"></i>
							          </div>
							        </div>
									<input type="text" v-model="form.movil"  maxlength="10" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Telefono móvil">   
							    </div>
								<small class="text-danger">{{errores.movil}}</small>
							</div>
						</div>
						
					</div>
					<hr>
					<h5>Dirección</h5>
					<!-- contacto -->
					<div class="row mt-1 mb-3">
					    <div class="col-lg-5 col-sm-12">
							<div class="input-group mb-2">
					        	<div class="input-group-prepend input-group-sm">
					          		<div class="input-group-text rounded-0">
					          			<i class="bi bi-signpost"></i>
					          		</div>
					        	</div>
					      		<input type="text" class="form-control form-control-sm rounded-0 shadow-none" id="email" placeholder="Calle"  v-model="form.calle">
					    	</div>
					    </div>
					     <div class="col">
							<div class="input-group mb-2">
					        	<div class="input-group-prepend input-group-sm">
					          		<div class="input-group-text rounded-0">
					          			<i class="bi bi-hash"></i>
					          		</div>
					        	</div>
					      		<input type="text" class="form-control form-control-sm rounded-0 shadow-none" id="email" placeholder="Numero ext."  v-model="form.ext">
					    	</div>
					    </div>
					     <div class="col">
							<div class="input-group mb-2">
					        	<div class="input-group-prepend input-group-sm">
					          		<div class="input-group-text rounded-0">
					          			<i class="bi bi-hash"></i>
					          		</div>
					        	</div>
					      		<input type="text" class="form-control form-control-sm rounded-0 shadow-none" id="email" placeholder="Numero int."  v-model="form.int">
					    	</div>
					    </div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<input type="text" v-model="form.colonia" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Colonia">
								<small class="text-danger d-none">No pude ir vacio</small>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<input type="text" v-model="form.ciudad" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Cidudad">
								<small class="text-danger d-none">No pude ir vacio</small>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<select v-model="form.estado" class="form-control form-control-sm rounded-0" id="estados">
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
					</div>	
					<div class="form-group">
						<div class="input-group mb-2">
					        <div class="input-group-prepend input-group-sm">
					          <div class="input-group-text rounded-0">
					          	<i class="bi bi-geo"></i>
					          </div>
					        </div>
							<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Ubicación" v-model="form.ubicacion">
					    </div>
					</div>				
					<div class="form-group d-flex align-items-center">
						<button type="submit" value="Guardar" class="btn btn-danger rounded-0">Guardar</button>
					</div>
				</form>
				<form action="#" @submit.prevent="enviar_form" :class="[display_form]">
					<!-- Datos del cliente -->
					<h5 class="mt-0">Datos Fiscales</h5>
					<p class="mt-3"><strong>¿Es la dirección fiscal la misma de domicilio del cliente?</strong></p>
					<div class="d-flex justify-content-between">
						<div class="form-group">
							<label for="one" class="mr-2">Sí, es la misma dirección</label>
							<input type="radio" id="one" value="1" v-model="picked" / @change="direccion_fiscal()">
						</div>
						<div class="form-group">
							<label for="two" class="mr-2">No, es diferente dirección</label>
							<input type="radio" id="two" value="2" v-model="picked" @change="direccion_fiscal()"/>
						</div>

					</div>
					<!-- contacto -->
					<div class="form-group">
						<label for="">Regimen Fiscal</label>
						<select name="regimen-fiscal" id="regimen-fiscal" class="form-control form-control-sm rounded-0">
						    <option value="601">General de Ley Personas Morales</option>
						    <option value="603">Personas Morales con Fines no Lucrativos</option>
						    <option value="605">Sueldos y Salarios e Ingresos Asimilados a Salarios</option>
						    <option value="606">Arrendamiento</option>
						    <option value="607">Régimen de Enajenación o Adquisición de Bienes</option>
						    <option value="608">Demás ingresos</option>
						    <option value="609">Consolidación</option>
						    <option value="610">Residentes en el Extranjero sin Establecimiento Permanente en México</option>
						    <option value="611">Ingresos por Dividendos (socios y accionistas)</option>
						    <option value="612">Personas Físicas con Actividades Empresariales y Profesionales</option>
						    <option value="614">Ingresos por Intereses</option>
						    <option value="615">Régimen de los ingresos por obtención de premios</option>
						    <option value="616">Sin obligaciones fiscales</option>
						    <option value="620">Sociedades Cooperativas de Producción que optan por diferir sus ingresos</option>
						    <option value="621">Incorporación Fiscal</option>
						    <option value="622">Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras</option>
						    <option value="623">Opcional para Grupos de Sociedades</option>
						    <option value="624">Coordinados</option>
						    <option value="625">Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas</option>
						    <option value="626">Régimen Simplificado de Confianza</option>
						</select>
					</div>
					<div :class="['row', 'mt-1', 'mb-3', display]">
					    <div class="col-lg-5 col-sm-12">
							<div class="input-group mb-2">
					        	<div class="input-group-prepend input-group-sm">
					          		<div class="input-group-text rounded-0">
					          			<i class="bi bi-signpost"></i>
					          		</div>
					        	</div>
					      		<input type="text" class="form-control form-control-sm rounded-0 shadow-none" id="email" placeholder="Calle"  v-model="form.calle">
					    	</div>
					    </div>
					     <div class="col">
							<div class="input-group mb-2">
					        	<div class="input-group-prepend input-group-sm">
					          		<div class="input-group-text rounded-0">
					          			<i class="bi bi-hash"></i>
					          		</div>
					        	</div>
					      		<input type="text" class="form-control form-control-sm rounded-0 shadow-none" id="email" placeholder="Numero ext."  v-model="form.ext">
					    	</div>
					    </div>
					     <div class="col">
							<div class="input-group mb-2">
					        	<div class="input-group-prepend input-group-sm">
					          		<div class="input-group-text rounded-0">
					          			<i class="bi bi-hash"></i>
					          		</div>
					        	</div>
					      		<input type="text" class="form-control form-control-sm rounded-0 shadow-none" id="email" placeholder="Numero int."  v-model="form.int">
					    	</div>
					    </div>
					</div>
					<div :class="['row', display]">
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<input type="text" v-model="form.colonia" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Colonia">
								<small class="text-danger d-none">No pude ir vacio</small>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<input type="text" v-model="form.ciudad" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Cidudad">
								<small class="text-danger d-none">No pude ir vacio</small>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<select v-model="form.estado" class="form-control form-control-sm rounded-0" id="estados_2">
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
					</div>
					<div class="row">
							<div class="col">
								<div class="form-group">
									<div class="input-group mb-2">
								        <div class="input-group-prepend input-group-sm">
								          <div class="input-group-text rounded-0">
								          	<i class="bi bi-hash"></i>
								          </div>
								        </div>
										<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="RFC" v-model="form.ubicacion">
								    </div>
								</div>				
							</div>
							<div class="col">
								<div class="form-group">
									<div class="input-group mb-2">
								        <div class="input-group-prepend input-group-sm">
								          <div class="input-group-text rounded-0">
								          	<i class="bi bi-hash"></i>
								          </div>
								        </div>
										<input type="text" class="form-control rounded-0 form-control-sm shadow-none" placeholder="Código Postal" v-model="form.ubicacion">
								    </div>
								</div>
							</div>
						</div>	
					<div class="form-group d-flex align-items-center">
						<button type="submit" value="Guardar" class="btn btn-danger rounded-0">Guardar</button>
					</div>
				</form>
				<button class="btn btn-primary rounded-0 mr-2" @click="modal_fiscal">Agregar Datos Fiscales</button>
		    </div>
		    <div class="modal fade" id="datos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
			    <div class="modal-content rounded-0">
			      <div class="modal-body">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			        <h4 class="text-center">¿Deseas agregar los datos fiscales?</h4>
			        <div class="d-flex justify-content-between">
			        	<a href="<?php echo base_url('/clientes');?>" class="btn btn-sm btn-primary rounded-0">No, lo haré mas tarde</a>
			        	<button class="btn btn-sm btn-success rounded-0" @click="agregar_direccion_fiscal">Sí, deseo agregarlos</button>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
    	</div>
    </div>
</div>
</div>
<script>
	$(document).ready(function() {
    	$('#estados').select2({
    		placeholder: "Estado",
    		allowClear: true
    	});
    	$('#estados_2').select2({
    		placeholder: "Estado",
    		allowClear: true
    	});
	});
</script>
<script type="text/javascript" src="<?php echo base_url('public/js/clientes.js'); ?>"></script>
<?php echo $this->endSection('contenido')?>
