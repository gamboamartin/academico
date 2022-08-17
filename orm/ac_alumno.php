<?php
namespace models;
use base\orm\modelo;
use PDO;

class ac_alumno extends modelo{
    public function __construct(PDO $link){
        $tabla = __CLASS__;
        $columnas = array($tabla=>false,'ac_estado_alumno'=>$tabla,'ac_turno'=>$tabla,'dp_calle_pertenece'=>$tabla,
            'dp_estado'=>$tabla,'adm_estado_civil'=>$tabla,'adm_genero'=>$tabla, 'adm_idioma'=>$tabla);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
    }
}