<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\academico\controllers;


use gamboamartin\system\links_menu;
use gamboamartin\system\system;
use gamboamartin\template_1\html;
use html\ac_centro_educativo_html;
use html\ac_grado_html;
use html\ac_nivel_html;
use html\ac_plan_estudio_html;
use models\ac_centro_educativo;
use models\ac_grado;
use models\ac_nivel;
use models\ac_plan_estudio;
use PDO;
use stdClass;

class controlador_ac_grado extends system {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){

        $modelo = new ac_grado(link: $link);
        $html_ = new ac_grado_html($html);
        $obj_link = new links_menu($this->registro_id);
        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link, paths_conf: $paths_conf);

        $this->titulo_lista = 'Grado';
    }


}
