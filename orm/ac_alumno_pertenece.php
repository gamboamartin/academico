<?php
namespace models;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class ac_alumno_pertenece extends modelo{
    public function __construct(PDO $link){
        $tabla = __CLASS__;
        $columnas = array($tabla=>false, 'ac_alumno'=>$tabla, 'ac_centro_educativo'=>$tabla,
            'dp_calle_pertenece'=>'ac_centro_educativo','dp_colonia_postal'=>'dp_calle_pertenece',
            'dp_calle'=>'dp_calle_pertenece',
            'dp_cp'=>'dp_colonia_postal','dp_colonia'=>'dp_colonia_postal','dp_municipio'=>'dp_cp',
            'dp_estado'=>'dp_municipio','dp_pais'=>'dp_estado');
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
    }

    public function alta_bd(): array|stdClass
    {
        if(!isset($this->registro['codigo'])){
            $this->registro['codigo'] = $this->registro['ac_centro_educativo_id'].' - '.$this->registro['ac_alumno_id'];
        }

        $r_alta_bd = parent::alta_bd();
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar registro', data: $r_alta_bd);
        }

        return $r_alta_bd;
    }

    public function planteles(int $ac_alumno_id): array|stdClass
    {
        if($ac_alumno_id <=0){
            return $this->error->error(mensaje: 'Error $ac_alumno_id debe ser mayor a 0', data: $ac_alumno_id);
        }
        $filtro['ac_alumno.id'] = $ac_alumno_id;
        $r_ac_alumno = $this->filtro_and(filtro: $filtro);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al obtener planteles', data: $r_ac_alumno);
        }
        return $r_ac_alumno;
    }

}