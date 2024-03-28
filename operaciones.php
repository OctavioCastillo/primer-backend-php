<?php

/*$accion = $_GET['accion'];

echo $accion;*/

//include() para importar archivo
include('conn.php'); 

$data = json_decode(file_get_contents('php://input'), true);

//función para verificar que tiene un valor
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    //leer los datos de la tabla de usuarios
    if ($accion == 'leer') {


        $sql = "select * from alumnos where 1"; //where 1 es para no preocuparnos por los where abajo
        $result = $db->query($sql);


        //array donde se van a agregar los alumnos
        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['Id'];
                $item['nombre'] = $fila['nombre'];
                $item['apellido_paterno'] = $fila['apellido_paterno'];
                $item['apellido_materno'] = $fila['apellido_materno'];
                $arrAlumnos[] = $item;
            }
            
            $response["status"] = "Okay";
            $response["mensaje"] = $arrAlumnos;

        } else {
            $response["status"] = "Error";
            $response["mensaje"] = "No hay alumnos registrados";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

//Si yo paso datos json a través del body
if(isset($data)) {

    //obtengo la accion
    $accion = $data["accion"];

    //verifico el tipo de accion
    if($accion=='insertar') {
        
        //obtener datos del body
        $apellido_paterno = $data["apellido_paterno"];
        $apellido_materno = $data["apellido_materno"];
        $nombre = $data["nombre"];

        //insertar a la base de datos
        $qry = "insert into alumnos (apellido_paterno, apellido_materno, nombre) values ('$apellido_paterno', '$apellido_materno', '$nombre')";

        if($db->query($qry)){
            $response["status"] = "Ok";
            $response["mensaje"] = "El registro se creo correctamente";
        } else {
            $response["status"] = "ERROR";
            $response["mensaje"] = "No se pudo guardar el registro";
        }

        header('Content-Type: application/json');
        echo json_encode($response);

    }

    if($accion == 'modificar') {

        $id = $data["Id"];
        $apellido_paterno = $data["apellido_paterno"];
        $apellido_materno = $data["apellido_materno"];
        $nombre = $data["nombre"];

        $qry = "update alumnos set apellido_paterno = '$apellido_paterno', apellido_materno = '$apellido_materno', nombre = '$nombre' where Id = 5";

        if($db->query($qry)){
            $response["status"] = "Ok";
            $response["mensaje"] = "El registro se modificó correctamente";
        } else {
            $response["status"] = "ERROR";
            $response["mensaje"] = "No se pudo modificar el registro";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($accion == 'borrar') {

        $id = $data["id"];

        $qry = "delete from alumnos where Id = $id";

        if($db->query($qry)){
            $response["status"] = "Ok";
            $response["mensaje"] = "El registro se eliminó correctamente";
        } else {
            $response["status"] = "ERROR";
            $response["mensaje"] = "No se pudo eliminar el registro";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}