<?php
namespace links\secciones;

use gamboamartin\errores\errores;
use gamboamartin\system\links_menu;
use PDO;
use stdClass;

class link_ac_alumno extends links_menu {
    public stdClass $links;
    


    
    public function link_ac_alumno_pertenece_alta_bd(int $ac_alumno_id, PDO $link): string
    {

        $link_alta_bd = $this->link_con_id(accion: 'alta_alumno_pertenece_bd', link: $link, registro_id: $ac_alumno_id, seccion: 'ac_alumno');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar link', data: $link_alta_bd);
        }

        return $link_alta_bd;
    }

}
