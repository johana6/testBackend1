<?php

session_start();

include('conexion.php');

$sql = new ConnectionMaster();
$sql->Conectar();


$ciudades = array();
$buscador = array();

$ciudades1 = array();

/////////////CIUDADES  DE RESERVA///////////////////

if (isset($_GET['consulta_ciudad'])) {


    if (isset($_GET['ciudadOrigen'])) {
        
        $ciudad = $_GET['ciudadOrigen'];
        
        $cadena = "SELECT ciudad_destino_id as id, ciudades.nombre,trayectos.id as trayectoid  FROM aerolineawendy.trayectos 
JOIN ciudades ON trayectos.ciudad_destino_id=ciudades.ID where trayectos.ciudad_origen_id='$ciudad' group by nombre";
    } else {
        $cadena = "SELECT * FROM aerolineawendy.ciudades";
    }
    
    
    $result = $sql->Consultar($cadena);
    $num_r = $sql->Contar_filas($result);
    if ($num_r > 0) {
        while ($row = $sql->Resultados($result)) {
            $rowArray['id'] = $row['id'];
            $rowArray['nombre'] = $row['nombre'];
            $rowArray['trayectoid'] = $row['trayectoid'];

            array_push($ciudades, $rowArray);
        }
        echo json_encode($ciudades, JSON_UNESCAPED_UNICODE);
    }
}

////////////////CONSULTA CIUDAD FILTRO
if (isset($_GET['ciudadConsulta'])) {

    
    if (isset($_GET['ciudadOrigenConsulta'])) {
        
        $ciudad = $_GET['ciudadOrigenConsulta'];
        
         $cadena = "SELECT * FROM aerolineawendy.ciudades WHERE id !='$ciudad'";
    } else {
         $cadena = "SELECT * FROM aerolineawendy.ciudades";
    }
    
    
    $result = $sql->Consultar($cadena);
    $num_r = $sql->Contar_filas($result);
    if ($num_r > 0) {
        while ($row = $sql->Resultados($result)) {
            $rowArray['id'] = $row['id'];
            $rowArray['nombre'] = $row['nombre'];

            array_push($ciudades, $rowArray);
        }
        echo json_encode($ciudades, JSON_UNESCAPED_UNICODE);
    }
}


////////////////CONSULTA DE VUELOS

if (isset($_POST['ciudadOrigenConsulta']) && isset($_POST['ciudadOrigenConsultaDestino'])) {

    
    $ciudadOrigenConsulta=$_POST['ciudadOrigenConsulta'];
    $ciudadOrigenConsultaDestino=$_POST['ciudadOrigenConsultaDestino'];
    $fechaInicial=$_POST['fechaInicial'];
    $fechaFinal=$_POST['fechaFinal'];
    
    
    $cadena1 = "SELECT * FROM aerolineawendy.consultavuelos WHERE ciudad_origen_id='1' AND ciudad_destino_id='4'";
    
    $result1 = $sql->Consultar($cadena1);
    $num_r = $sql->Contar_filas($result);
    if ($num_r > 0) {
        
        
        while ($row1 = $sql->Resultados($result1)) {
            $rowArray1['fecha_salida'] = $row1['fecha_salida'];
            $rowArray1['duracion'] = $row1['duracion'];
            $rowArray1['ciudadOrigen'] = $row1['ciudadOrigen'];
            $rowArray1['ciudadDestino'] = $row1['ciudadDestino'];

            array_push($ciudades1, $rowArray1);
        }
        echo json_encode($ciudades1, JSON_UNESCAPED_UNICODE);
    }
}


////////////////CONSULTA DE DESCUENTOS
if(isset($_GET['ciudadDDestino'])){
    
    $ciudadDDestino=$_GET['ciudadDDestino'];
    
    $cadena = "SELECT * FROM aerolineawendy.consultaimpuestos WHERE ciudad_destino_id='$ciudadDDestino'";
    
    
    $result = $sql->Consultar($cadena);
    $num_r = $sql->Contar_filas($result);
    if ($num_r > 0) {
        
        
        while ($row = $sql->Resultados($result)) {
            $rowArray['id'] = $row['id'];
            $rowArray['descripcion'] = $row['descripcion'];

            array_push($ciudades, $rowArray);
        }
        echo json_encode($ciudades, JSON_UNESCAPED_UNICODE);
    }
   
}


//////////INSERTAR TIQUETE//////////////


if(isset($_GET['ciudadOrigenI'])){
    
    $ciudadOrigenI=$_GET['ciudadOrigenI'];
    $ciudadDestinoI=$_GET['ciudadDestinoI'];
    $nombresI=$_GET['nombresI'];
    $apellidosI=$_GET['apellidosI'];
    $cedulaI=$_GET['cedulaI'];
    $telefonoI=$_GET['telefonoI'];
    $fechaNacimientoI=$_GET['fechaNacimientoI'];
    $celularI=$_GET['celularI'];
    $correoI=$_GET['correoI'];
    
    
    $insert = "INSERT INTO aerolineawendy.tiquete (nombres,apellidos,fechaNacimiento,cedula,telefono,celular,correoElectronico) VALUES ('$nombresI','$apellidosI','$apellidosI','$cedulaI','$telefonoI','$celularI','$correoI')";
    
    $insertInto=("INSERT INTO aerolineawendy.tiquete_trayecto  (id_tiquete,id_trayecto) VALUES (1,2)");
    
    $result1 = $sql->Consultar($cadena);
    $result2 = $sql->Consultar($insertInto);
    
    
    $num_r = $sql->Contar_filas($result);
    if ($num_r > 0) {
        
        
        while ($row = $sql->Resultados($result)) {
            $rowArray['id'] = $row['id'];
            $rowArray['descripcion'] = $row['descripcion'];

            array_push($ciudades, $rowArray);
        }
        echo json_encode($ciudades, JSON_UNESCAPED_UNICODE);
    }
   
}


