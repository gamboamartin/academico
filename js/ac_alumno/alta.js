function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}
let url = getAbsolutePath();

let direcciones_js = url+'js/direcciones.js';

document.write('<script src="'+direcciones_js+'"></script>');

let session_id = getParameterByName('session_id');

$( document ).ready(function() {
    let telefono_txt_fijo = $("input[name=telefono_fijo]");
    let telefono_txt_movil = $("input[name=telefono_movil]");
    let telefono_error_fijo = $(".label-error-fijo");
    let telefono_error_movil = $(".label-error-movil");
    let telefono = '';
    let telefono_regex = new RegExp('[1-9][0-9]{9}');

    telefono_error_fijo.hide();
    telefono_txt_fijo.keyup(function () {
        telefono = $(this).val();
        let valido = false;
        let regex_val = telefono_regex.test(telefono);
        let n_car = telefono.length;

        if(n_car<=10 && regex_val){
            valido = true;
        }

        if(!valido){
            telefono_error_fijo.show();
        } else {
            telefono_error_fijo.hide();
        }

    });

    telefono_error_movil.hide();
    telefono_txt_movil.keyup(function () {
        telefono = $(this).val();
        let valido = false;
        let regex_val = telefono_regex.test(telefono);
        let n_car = telefono.length;

        if(n_car<=10 && regex_val){
            valido = true;
        }

        if(!valido){
            telefono_error_movil.show();
        } else {
            telefono_error_movil.hide();
        }

    });

    let txt_correo = $("input[name=correo]");
    let correo_regex = new RegExp('[a-z0-9!#$%&\'*+=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&\'*+=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?');
    let correo_error = $(".label-error-correo");

    correo_error.hide();
    txt_correo.change(function () {
        let correo = $(this).val();
        let valido = false;
        let regex_val = correo_regex.test(correo);
        let n_car = correo.length;

        if(n_car > 0 && regex_val){
            valido = true;
        }

        if(!valido){
            correo_error.show();
        } else {
            correo_error.hide();
        }
    });
});
