<?php
namespace links\secciones;
use config\generales;
use gamboamartin\errores\errores;
use gamboamartin\system\links_menu;
use PDO;
use stdClass;

class link_ac_plan_estudio extends links_menu {
    public stdClass $links;

    public function link_ac_plan_estudio_pertenece_alta_bd(int $ac_plan_estudio_id, PDO $link): string
    {

        $link = $this->link_con_id(accion:'alta_plan_estudio_pertenece_bd',link: $link, registro_id: $ac_plan_estudio_id,
            seccion:  'ac_plan_estudio');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar link', data: $link);
        }

        return $link;
    }
    
    public function link_ac_plan_estudio_pertenece_modifica_bd(int $ac_plan_estudio_id,
                                                               int $ac_plan_estudio_pertenece_id, PDO $link): string
    {
        $params['ac_plan_estudio_pertenece_id'] = $ac_plan_estudio_pertenece_id;
        $link = $this->link_con_id(accion:'modifica_plan_estudio_pertenece_bd',link: $link, registro_id: $ac_plan_estudio_id,
            seccion:  'ac_plan_estudio',params: $params);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar link', data: $link);
        }

        return $link;
    }

}
