<?php echo $this->extend('Panel/panel_template') ?>
<?php echo $this->section('contenido') ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
   <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
           class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
<div class="w3-bar w3-black">
  <button class="w3-bar-item w3-button" onclick="openCity('s1')">Ordenes de Diagnóstico</button>
  <button class="w3-bar-item w3-button" onclick="openCity('s2')">Diagnosticos</button>
  <button class="w3-bar-item w3-button" onclick="openCity('s3')">Precotizaciones</button>
</div>
<div class="row">
   <div class="col-12">
      <div id="s1" class="w3-container stage">
        <div class="card card-body rounded-0 mt-3">
            <h3>Ordenes de Diagnóstico</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, quis. Aliquam alias libero mollitia nemo quidem amet consectetur cupiditate vero!</p>
        </div>
      </div>

      <div id="s2" class="w3-container stage" style="display:none">
         <div class="card card-body rounded-0 mt-3">
            <h3>Diagnostico</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, quis. Aliquam alias libero mollitia nemo quidem amet consectetur cupiditate vero!</p>
         </div>
      </div>

      <div id="s3" class="w3-container stage" style="display:none">
         <div class="card card-body rounded-0 mt-3">
            <h3>Ordenes de Diagnostico</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, quis. Aliquam alias libero mollitia nemo quidem amet consectetur cupiditate vero!</p>
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
</script>
<?php echo $this->endSection() ?>