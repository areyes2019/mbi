<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
    </div>
	<div class="card mt-3 rounded-0">
        <div class="card-body">
            <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario de Entidad</title>
  <!-- Enlace a Bootstrap 5 CSS (CDN) -->
  <link 
    rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
  >
</head>
<body>
<div class="container my-5">
  <div class="row">
    <div class="col-6">
      <div class="card rounded-0">
        <div class="card-header">
          <h2 class="mb-0">Editar de Entidad</h2>
        </div>
        <div class="card-body">
          <form method="post" action="/entidades/update/<?= $entidad['id_entidad'] ?>">
            
            <!-- RFC -->
            <div class="mb-3">
              <label for="rfc" class="form-label">RFC</label>
              <input 
                type="text" 
                class="form-control" 
                id="rfc" 
                name="rfc" 
                placeholder="Ej. ABCD560123FGH" 
                value="<?= esc($entidad['rfc'] ?? '') ?>"
                required
              >
            </div>

            <!-- Razón Social -->
            <div class="mb-3">
              <label for="razon_social" class="form-label">Razón Social</label>
              <input 
                type="text" 
                class="form-control" 
                id="razon_social" 
                name="razon_social"
                placeholder="Ej. Empresa S.A. de C.V." 
                value="<?= esc($entidad['razon_social'] ?? '') ?>"
                required
              >
            </div>

            <!-- Código Postal (cp) -->
            <div class="mb-3">
              <label for="cp" class="form-label">Código Postal</label>
              <input 
                type="number" 
                class="form-control" 
                id="cp" 
                name="cp"
                placeholder="Ej. 12345" 
                value="<?= esc($entidad['cp'] ?? '') ?>"
                required
              >
            </div>

            <!-- Calle -->
            <div class="mb-3">
              <label for="calle" class="form-label">Calle</label>
              <input 
                type="text" 
                class="form-control" 
                id="calle" 
                name="calle"
                placeholder="Ej. Av. Principal" 
                value="<?= esc($entidad['calle'] ?? '') ?>"
                required
              >
            </div>

            <!-- Número Interior (num_int) -->
            <div class="mb-3">
              <label for="num_int" class="form-label">Número Interior</label>
              <input 
                type="number" 
                class="form-control" 
                id="num_int" 
                name="num_int" 
                placeholder="Ej. 10"
                value="<?= esc($entidad['num_int'] ?? '') ?>"
              >
            </div>

            <!-- Número Exterior (num_ext) -->
            <div class="mb-3">
              <label for="num_ext" class="form-label">Número Exterior</label>
              <input 
                type="number" 
                class="form-control" 
                id="num_ext" 
                name="num_ext" 
                placeholder="Ej. 200"
                value="<?= esc($entidad['num_ext'] ?? '') ?>"
              >
            </div>

            <!-- Colonia -->
            <div class="mb-3">
              <label for="colonia" class="form-label">Colonia</label>
              <input 
                type="text" 
                class="form-control" 
                id="colonia" 
                name="colonia"
                placeholder="Ej. Centro"
                value="<?= esc($entidad['colonia'] ?? '') ?>"
              >
            </div>

            <!-- Ciudad -->
            <div class="mb-3">
              <label for="ciudad" class="form-label">Ciudad</label>
              <input 
                type="text" 
                class="form-control" 
                id="ciudad" 
                name="ciudad"
                placeholder="Ej. Ciudad de México"
                value="<?= esc($entidad['ciudad'] ?? '') ?>"
              >
            </div>

            <!-- Estado -->
            <div class="mb-3">
              <label for="estado" class="form-label">Estado</label>
              <input 
                type="text" 
                class="form-control" 
                id="estado" 
                name="estado"
                placeholder="Ej. Estado de México"
                value="<?= esc($entidad['estado'] ?? '') ?>"
              >
            </div>

            <!-- Régimen -->
            <div class="mb-3">
              <label for="regimen" class="form-label">Régimen</label>
              <input 
                type="number" 
                class="form-control" 
                id="regimen" 
                name="regimen"
                placeholder="Ej. 603, 605, etc." 
                value="<?= esc($entidad['regimen'] ?? '') ?>"
              >
            </div>

            <!-- Correo -->
            <div class="mb-3">
              <label for="correo" class="form-label">Correo</label>
              <input 
                type="email" 
                class="form-control" 
                id="correo" 
                name="correo"
                placeholder="Ej. ejemplo@dominio.com"
                value="<?= esc($entidad['correo'] ?? '') ?>"
              >
            </div>

            <!-- Teléfono -->
            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input 
                type="tel" 
                class="form-control" 
                id="telefono" 
                name="telefono"
                placeholder="Ej. 5512345678"
                value="<?= esc($entidad['telefono'] ?? '') ?>"
              >
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </form>    
        </div>
      </div>
    </div> <!-- /col-6 -->
  </div> <!-- /row -->
  
</div>

<!-- Script de Bootstrap 5 (CDN) -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>
</body>

<?php echo $this->endSection(); ?>