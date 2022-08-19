<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 0.48.13
 * @verclass 1.0.0
 * @created 2022-07-25
 * @final En proceso
 *
 */
namespace gamboamartin\academico\controllers;


use gamboamartin\template_1\html;
use PDO;
use stdClass;


class controlador_org_sucursal extends \gamboamartin\organigrama\controllers\controlador_org_sucursal {

    public function __construct(PDO $link,  stdClass $paths_conf = new stdClass()){

        $html_base = new html();
        parent::__construct(link: $link, html: $html_base);

        $this->titulo_lista = 'Sucursales';

    }


}
