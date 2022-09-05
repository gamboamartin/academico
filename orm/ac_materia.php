<?php
namespace models;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class ac_materia extends modelo{
    public function __construct(PDO $link){
        $tabla = __CLASS__;
        $columnas = array($tabla=>false, 'ac_tipo_asignatura'=>$tabla, 'ac_plan_estudio'=>$tabla);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
    }
    public function alta_bd(): array|stdClass
    {

        $registro = $this->init_data_alta_bd(registro: $this->registro);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al inicializar registro',data: $registro);
        }

        $this->registro = $registro;

        $r_alta_bd =  parent::alta_bd(); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al dar de alta accion',data: $r_alta_bd);
        }

        return $r_alta_bd;
    }

    private function init_data_alta_bd(array $registro){
        if(!isset($registro['codigo'])) {
            $registro['codigo'] = $registro['clave'] . ' ' . $registro['id_asignatura'];
        }

        if(!isset($registro['codigo_bis'])) {
            $registro['codigo_bis'] = $registro['clave'].' ' .$registro['id_asignatura'];
        }

        if(!isset($registro['descripcion_select'])) {
            $registro['descripcion_select'] = $registro['clave'] . ' ' . $registro['descripcion'];
        }
        
        if(!isset($registro['alias'])) {
            $registro['alias'] = $registro['clave'].' ' .$registro['descripcion'];
        }

        return $registro;
    }

}