<?php

class TarjetasApiController{

    private $model;
    private $view;

    function __construct(){
        $this->model = new Model();
        $this->view = new ApiView();
    }

    function getTarjetas($params = null){
        $dniLogueado = $this->helper->checklogin();
        $tarjetas = $this->model->getTarjetas($dniLogueado);
        if($tarjetas){
            return $this->view->response($tarjetas, 200);
        }
        else {
            return $this->view->response("No hay tarjetas", 400);
        }
    }


    function getDatosPorFecha(){ //Esta funcion iria en Otro controlador llamado ActividadesApiController
        if(isset($_POST['fecha1']) && ($_POST['fecha2'])){
            $fecha1 = $_POST['fecha1'];
            $fecha2 = $_POST['fecha2'];
            $datos = $this->model->getDatosPorFechas($fecha1, $fecha2);
            if($datos){
                return $this->view->respose($datos, 200);

            }
            else{ return $this->view->respose("No se encontro informacion ", 500);
            }
        }
    }


    function deleteTarjeta($params = null){
        $idTarjeta = $params[":ID"];
        $tarjeta = $this->model->getTarjeta($idTarjeta);
        if($tarjeta){
            $this->model->deleteTarjeta();
            return $this->view->response("La Tarjeta ha sido borrada", 200);

        }
        else{
            return $this->view->response("No se puede eliminar algo que no existe", 400);
        }
    }
}