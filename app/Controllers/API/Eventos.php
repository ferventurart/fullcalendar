<?php

namespace App\Controllers\API;

use App\Models\EventoModel;
use CodeIgniter\RESTful\ResourceController;

class Eventos extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new EventoModel());
    }

    public function index()
    {
        try {
            $parametros = $this->request->getPost();

            if (is_array($parametros)) :
                if (isset($parametros['start']) && isset($parametros['end'])) :
                    $eventos = $this->model
                        ->where("start >=", $parametros['start'])
                        ->where("end <=", $parametros['end'])
                        ->findAll();

                    return $this->respond($eventos);
                endif;
            endif;

            return $this->respond(array());
        } catch (\Exception $e) {
            return $this->failServerError("Ocurrio un error en el servidor de eventos");
        }
    }

    public function create()
    {
        try {

            if ($this->request->isAJAX()) :
                $evento = $this->request->getJSON();
                $evento = $this->setDefaultValues($evento);

                if ($this->model->insert($evento)) :
                    $evento->id = $this->model->insertID();
                    return $this->respondCreated($evento);
                else :
                    return $this->failValidationError($this->model->validation->listErrors());
                endif;
            endif;

            return $this->failForbidden("El servidor de eventos no soporta tu peticion");
        } catch (\Exception $e) {
            return $this->failServerError("Ocurrio un error en el servidor de eventos");
        }
    }

    
    public function edit($id = null)
    {
        try {
            if ($id == null)
                return $this->failNotFound($id);

            $data = $this->model->find($id);

            if ($data == null)
                return $this->failNotFound("No se ha encontrado un registro con el id {$id}");

            return $this->respond($data);
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->failServerError("Ocurrio un error en el servidor");
        }
    }

    public function update($id = null)
    {
        try {
            if ($this->request->isAJAX()) :
                if ($id == null)
                    return $this->failNotFound($id);

                $data = $this->model->find($id);

                if ($data == null)
                    return $this->failNotFound("No se ha encontrado un registro con el id {$id}");

                $edit = $this->request->getJSON();
                $edit = $this->setDefaultValues($edit);

                if ($this->model->update($id, $edit)) :
                    $edit->id = $id;
                    return $this->respondUpdated(["updated" => $edit]);
                else :
                    return $this->fail($this->model->validation->listErrors());
                endif;
            endif;
            return $this->failForbidden("El servidor de eventos no soporta tu peticion");
        } catch (\Exception $e) {
            return $this->failServerError("Ocurrio un error en el servidor");
        }
    }


    public function delete($id = null)
    {
        try {
            if ($this->request->isAJAX()) :
                if ($id == null)
                    return $this->failNotFound($id);

                $data = $this->model->find($id);

                if ($data == null)
                    return $this->failNotFound("No se ha encontrado un registro con el id {$id}");

                $this->model->delete(['id' => $id]);

                return $this->respondDeleted(["deleted" => $data]);
            endif;
            return $this->failForbidden("El servidor de eventos no soporta tu peticion");
        } catch (\Exception $e) {
            return $this->failServerError("Ocurrio un error en el servidor");
        }
    }

    private function setDefaultValues($data)
    {
        if (!property_exists($data, 'allDay')) :
            $data->allDay = 0;
        endif;
        return $data;
    }
}
