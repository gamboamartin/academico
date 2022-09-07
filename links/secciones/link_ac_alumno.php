<?php
namespace links\secciones;
use config\generales;
use gamboamartin\errores\errores;
use gamboamartin\system\links_menu;
use stdClass;

class link_ac_alumno extends links_menu {
    public stdClass $links;
    

    
    public function link_ac_alumno_pertenece_alta_bd(int $ac_alumno_id): string
    {

        $link = $this->link_con_id(accion:'alta_alumno_pertenece_bd', registro_id: $ac_alumno_id,seccion:  'ac_alumno');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar link', data: $link);
        }

        return $link;
    }

}
