function Insertar_U(){

    var num_empleado = document.getElementById('num_empleado').value.trim();                                            
    var nombre = document.getElementById('nombre').value.trim();             
    var apellidop = document.getElementById('apellidop').value.trim();                                            
    var apellidom = document.getElementById('apellidom').value.trim();                                            
    var rol = document.getElementById('rol').value; 
    var telefono = document.getElementById('telefono').value.trim();
    var correo = document.getElementById('correo').value.trim();
    var status = document.getElementById('status').value;

    
    if (
        num_empleado === "" ||
        nombre === "" ||
        apellidop === "" ||
        apellidom === "" ||
        telefono === "" ||
        correo === "" ||
        rol === "0" ||
        status === "0"
    ) {
        $('#respuesta').html("Todos los campos son obligatorios");
        return; 
    }

    var nombre_c = nombre + " " + apellidop + " " + apellidom;


     $.ajax({
        url: 'add_docentes.php',
        type: 'POST',
        data: {
            num_empleado: num_empleado,
            nombre_c: nombre_c,
            rol: rol,
            telefono: telefono,
            correo: correo,
            status: status,
          
        },
        success: function(res){
            $('#respuesta').html(res);
        }
    });
}


function Insertar_T(){

let diasSeleccionados = document.querySelectorAll('.diaCheck:checked');

if (diasSeleccionados.length === 0) {
$('#respuesta').html("Debes seleccionar al menos un día");
return;
}

let horarios = [];

for (let check of diasSeleccionados) {

let dia = check.value;
let cont = document.getElementById('horas_' + dia);

let horai = cont.querySelector('.horai').value;
let horaf = cont.querySelector('.horaf').value;

if (horai >= horaf) {
$('#respuesta').html("Error en horario de " + dia);
return;
}

horarios.push({
dia: dia,
inicio: horai,
fin: horaf
});
}

let formData = new FormData();

formData.append('nombre_taller', document.getElementById('nombre_taller').value);
formData.append('docente_id', document.getElementById('docente_id').value);
formData.append('periodo', document.getElementById('periodo').value);
formData.append('grupo', document.getElementById('grupo').value);
formData.append('cantidad_inscritos', document.getElementById('cantidad_inscritos').value);
formData.append('anio', document.getElementById('anio').value);
formData.append('status', document.getElementById('status').value);
formData.append('comentarios', document.getElementById('comentarios').value);

formData.append('horarios', JSON.stringify(horarios));

$.ajax({
url: 'add_talleres.php',
type: 'POST',
data: formData,
processData: false,
contentType: false,
success: function(res){
$('#respuesta').html(res);
}
});
}




function Insertar_A() {

    var nombre_alumno = $('#nombre_alumno').val().trim();
    var apellidop = $('#apellidop').val().trim();
    var apellidom = $('#apellidom').val().trim();
    var curp = $('#curp').val().trim();
    var matricula = $('#matricula').val().trim();
    var cuatrimestre = $('#cuatrimestre').val();
    var grupo = $('#grupo').val();
    var carrera = $('#carrera').val();
     var telefono = $('#telefono').val();
    var correo = $('#correo').val().trim();
    var password = $('#password').val().trim();

    if (
        nombre_alumno === "" ||
        apellidop === "" ||
        apellidom === "" ||
        curp === "" ||
        matricula === "" ||
        cuatrimestre === "" ||
        grupo === "" ||
        carrera === "" ||
        telefono === "" ||
        correo === "" ||
        password === ""
    ) {
        $('#respuesta').html("Todos los campos son obligatorios");
        return;
    }

    var nombre_completo = nombre_alumno + " " + apellidop + " " + apellidom;

    $.ajax({
        url: 'add_alumnos.php',
        type: 'POST',
        data: {
            nombre_completo: nombre_completo,
            curp: curp,
            matricula: matricula,
            cuatrimestre: cuatrimestre,
            grupo: grupo,
            carrera: carrera,
            telefono: telefono,
            correo: correo,
            password: password
        },
        success: function(res){
            $('#respuesta').html(res);
        }
    });
}




function Inscripcion(id_taller){
    
    var id_alumno  = document.getElementById('id_alumno_' + id_taller).value;    
    var docente_id = document.getElementById('docente_id_' + id_taller).value; 
    var status     = document.getElementById('status_' + id_taller).value;    

    
    var datos4 = "id_taller="+id_taller+"&id_alumno="+id_alumno+"&docente_id="+docente_id+"&status="+status;

    
    $.ajax({
        url: 'inscripcion.php',
        type: 'POST',
        data: datos4,
    })
    .done(function(res){
        
        $('#respuesta_' + id_taller).html(res);

       
        setTimeout(function(){
            location.reload();
        }, 2000);
    })
    .fail(function(){
         
        $('#respuesta_' + id_taller).html("<span style='color:red;'>Error al conectar con el servidor</span>");
    });
}


 function Liberacion(id_inscripcion){
           
            var id_inscripcion = document.getElementById('id_inscripcion_' + id_inscripcion).value;    
            var status = document.getElementById('status_' + id_inscripcion).value;    

            var datos5 = "id_inscripcion="+id_inscripcion+"&status="+status;

            $.ajax({
                url: 'liberacion.php',
                type: 'POST',
                data: datos5,
            })
            .done(function(res){
                $('#respuesta').html(res);
            })
        }








