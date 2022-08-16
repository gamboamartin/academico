<?php
namespace models;
use base\orm\modelo;
use PDO;

class ac_centro_educativo extends modelo{
    public function __construct(PDO $link){
        $tabla = __CLASS__;
        $columnas = array($tabla=>false, 'im_registro_patronal' => $tabla, 'dp_calle_pertenece' => $tabla);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
    }
}