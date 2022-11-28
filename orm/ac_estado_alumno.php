<?php
namespace gamboamartin\academico\models;
use base\orm\modelo;
use PDO;

class ac_estado_alumno extends modelo{
    public function __construct(PDO $link){
        $tabla = 'ac_estado_alumno';
        $columnas = array($tabla=>false);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;
    }
}