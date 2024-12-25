<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\EntidadesModel;
use CodeIgniter\Controller;

class Entidades extends Controller
{
    /**
     * Listado de todas las entidades (Read)
     */
    public function index()
    {
        $entidadesModel = new EntidadesModel();
        $data['entidades'] = $entidadesModel->findAll();

        // Retorna una vista con el listado de entidades
        // Ajusta la ruta de la vista según tu estructura
        return view('entidades', $data);
    }

    /**
     * Muestra el formulario para crear una nueva entidad (Create - parte 1)
     */
    public function create()
    {
        // Retorna la vista del formulario de creación
        // Ajusta la ruta de la vista según tu estructura
        return view('nueva_entidad');
    }

    /**
     * Procesa el formulario y guarda la nueva entidad (Create - parte 2)
     */
    public function store()
    {
        // Instanciamos el modelo
        $entidadesModel = new EntidadesModel();

        // Tomamos los datos del formulario (método POST)
        // Ajusta los nombres de los campos si difieren en tu formulario
        $data = [
            'razon_social' => $this->request->getPost('razon_social'),
            'rfc' => $this->request->getPost('rfc'),
            'cp'           => $this->request->getPost('cp'),
            'calle'        => $this->request->getPost('calle'),
            'num_int'      => $this->request->getPost('num_int'),
            'num_ext'      => $this->request->getPost('num_ext'),
            'colonia'      => $this->request->getPost('colonia'),
            'ciudad'       => $this->request->getPost('ciudad'),
            'estado'       => $this->request->getPost('estado'),
            'regimen'      => $this->request->getPost('regimen'),
            'correo'       => $this->request->getPost('correo'),
            'telefono'     => $this->request->getPost('telefono'),
        ];

        // Inserta en la BD. Si se quiere usar validación
        // se puede encapsular en un if($entidadesModel->insert($data)) { ... }
        $entidadesModel->insert($data);

        // Redirige al listado general después de crear
        return redirect()->to('/entidades');
    }

    /**
     * Muestra el detalle de una entidad específica (Read - opcional)
     */
    public function show($id)
    {
        $entidadesModel = new EntidadesModel();
        $data['entidad'] = $entidadesModel->find($id);

        if (!$data['entidad']) {
            // Maneja el caso si no existe la entidad
            throw new \CodeIgniter\Exceptions\PageNotFoundException("No se encontró la entidad con ID: $id");
        }

        return view('editar_entidad', $data);
    }

    /**
     * Muestra el formulario de edición para una entidad específica (Update - parte 1)
     */
    public function edit($id)
    {
        $entidadesModel = new EntidadesModel();
        $data['entidad'] = $entidadesModel->find($id);

        if (!$data['entidad']) {
            // Maneja el caso si no existe la entidad
            throw new \CodeIgniter\Exceptions\PageNotFoundException("No se encontró la entidad con ID: $id");
        }

        return view('entidades/edit', $data);
    }

    /**
     * Procesa el formulario de edición y actualiza la entidad (Update - parte 2)
     */
    public function update($id)
    {
        $entidadesModel = new EntidadesModel();

        // Verificamos que la entidad exista
        $entidad = $entidadesModel->find($id);
        if (!$entidad) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("No se encontró la entidad con ID: $id");
        }

        // Tomamos los datos del formulario (método POST)
        $data = [
            'razon_social' => $this->request->getPost('razon_social'),
            'cp'           => $this->request->getPost('cp'),
            'rfc'           => $this->request->getPost('rfc'),
            'calle'        => $this->request->getPost('calle'),
            'num_int'      => $this->request->getPost('num_int'),
            'num_ext'      => $this->request->getPost('num_ext'),
            'colonia'      => $this->request->getPost('colonia'),
            'ciudad'       => $this->request->getPost('ciudad'),
            'estado'       => $this->request->getPost('estado'),
            'regimen'      => $this->request->getPost('regimen'),
            'correo'       => $this->request->getPost('correo'),
            'telefono'     => $this->request->getPost('telefono'),
        ];

        // Actualiza en la BD
        $entidadesModel->update($id, $data);

        // Redirige al listado general después de actualizar
        return redirect()->to('/entidades');
    }

    /**
     * Elimina una entidad (Delete)
     */
    public function delete($id)
    {
        $entidadesModel = new EntidadesModel();

        // Verificamos que la entidad exista
        $entidad = $entidadesModel->find($id);
        if (!$entidad) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("No se encontró la entidad con ID: $id");
        }

        // Eliminamos de la BD
        $entidadesModel->delete($id);

        // Redirige al listado general después de eliminar
        return redirect()->to('/entidades');
    }
}
