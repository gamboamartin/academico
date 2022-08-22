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
    let telefono_error = $(".label-error");
    let telefono = '';
    let telefono_regex = new RegExp('[1-9][0-9]{9}');
    telefono_error.hide();
    telefono_txt_fijo.keyup(function () {
        telefono = $(this).val();
        let valido = false;
        let regex_val = telefono_regex.test(telefono);
        let n_car = telefono.length;

        if(n_car<=10 && regex_val){
            valido = true;
        }

        if(!valido){
            telefono_error.show();
        } else {
            telefono_error.hide();
        }

    });
    telefono_txt_movil.keyup(function () {
        telefono = $(this).val();
        let valido = false;
        let regex_val = telefono_regex.test(telefono);
        let n_car = telefono.length;

        if(n_car<=10 && regex_val){
            valido = true;
        }

        if(!valido){
            telefono_error.show();
        } else {
            telefono_error.hide();
        }

    });
});
