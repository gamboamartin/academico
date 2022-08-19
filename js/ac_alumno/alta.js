function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}
let url = getAbsolutePath();

let direcciones_js = url+'js/direcciones.js';

document.write('<script src="'+direcciones_js+'"></script>');

let session_id = getParameterByName('session_id');