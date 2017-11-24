var bitacoras;

$(document).ready(function (){
    bitacoras = $('#bitacoras').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/bitacora/list_bitacoras",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });
});
function truncate_bitacoras(){
    $.ajax({
        url : "http://localhost/parque/index.php/bitacora/truncate_bitacoras",
        type: "GET",
        dataType: "JSON",
        success: function (data){
            swal({
                title: "Éxito",
                text: "Se eliminaron todas las bitacoras.",
                type: "success"
            });
            reload_bitacoras();
        },
        error: function (jqXHR, textStatus, errorThrown){
            swal({
                title: "Error",
                text: "¡Ha ocurrido un error!",
                type: "error"
            });
        }
    });
}

function reload_bitacoras(){
    bitacoras.ajax.reload(null,false);
}