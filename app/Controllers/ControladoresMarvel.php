<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\MarvelModels;

class ControladoresMarvel extends Controller
{
    public function index()
    {
        return view('Inicio');
    }

    public function busqueda()
    {
        $model = new MarvelModels();
        $searchTerm = $this->request->getPost('searchTerm');
        $db = $this->request->getPost('db') ?? 'marvel';
        if ($db === 'marvel') {
            $data['characters'] = $model->ejecutarModelo($searchTerm,1);
        } elseif ($db === 'local') {
            $data['characters'] = $model->ejecutarModelo($searchTerm,5);
        }
        if(empty($data['characters'])){
            $mensaje = 'No se encontraron resultados';
            return redirect()->to(base_url('public'))->with('mensaje', $mensaje);
        }else{
            return view('MarvelView', $data);
        }
    }

    public function insertar()
    {
        $model = new MarvelModels();
        $data = [
            'id' => $this->request->getPost('id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];
        $mensaje = $model->ejecutarModelo($data,2);
        
        return redirect()->to(base_url('public'))->with('mensaje', $mensaje);
    }


    public function eliminar()
    {
        $model = new MarvelModels();
        $Id = $this->request->getPost('id');
        $mensaje = $model->ejecutarModelo($Id,3);

        return redirect()->to(base_url('public'))->with('mensaje', $mensaje);
    }
    public function existe()
    {
        $model = new MarvelModels();
        $Id = $this->request->getPost('id');
        var_dump($Id);
        $existe =$model->ejecutarModelo($Id,4);
        return $existe;
    }
}