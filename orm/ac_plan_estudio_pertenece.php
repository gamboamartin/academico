<?php
namespace models;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class ac_plan_estudio_pertenece extends modelo{
    public function __construct(PDO $link){
        $tabla = __CLASS__;
        $columnas = array($tabla=>false, 'ac_plan_estudio'=>$tabla,'ac_rvoe'=>'ac_plan_estudio',
            'ac_nivel'=>'ac_plan_estudio','ac_centro_educativo'=>$tabla, 'dp_calle_pertenece'=>'ac_centro_educativo',
            'dp_colonia_postal'=>'dp_calle_pertenece', 'dp_calle'=>'dp_calle_pertenece',
            'dp_cp'=>'dp_colonia_postal','dp_colonia'=>'dp_colonia_postal','dp_municipio'=>'dp_cp',
            'dp_estado'=>'dp_municipio','dp_pais'=>'dp_estado');
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
    }

    public function centros_educativos(int $ac_plan_estudio_id): array|stdClass
    {
        if($ac_plan_estudio_id <=0){
            return $this->error->error(mensaje: 'Error $ac_plan_estudio_id debe ser mayor a 0', data: $ac_plan_estudio_id);
        }
        $filtro['ac_plan_estudio.id'] = $ac_plan_estudio_id;
        $r_ac_plan_estudio = $this->filtro_and(filtro: $filtro);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al obtener planteles', data: $r_ac_plan_estudio);
        }
        return $r_ac_plan_estudio;
    }
}