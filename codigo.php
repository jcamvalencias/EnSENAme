<?php
if(isset($_POST["btn_registrar"])){
    include "conexion.php";
    $clave=$_POST['clave'];
    $clave2=$_POST['confirmarClave'];
    if($clave==$clave2){
        $pass=md5($clave);
        $tipoDocumento    = $_POST['tipoDocumento'];
        $numeroDocumento  = $_POST['numeroDocumento'];
        $primerNombre    = $_POST['primerNombre'];
        $segundoNombre    = $_POST['segundoNombre'];
        $primerApellido  = $_POST['primerApellido'];
        $segundoApellido = $_POST['segundoApellido'];
        $idrol = $_POST['idrol'];


        $registrar= mysqli_query($conexion,"INSERT INTO `tb_usuarios` (`ID`, `Tipo_Documento`, `p_nombre`, `s_nombre`, `p_apellido`, `s_apellido`, `Clave`, `id_rol`) 
        VALUES ('$numeroDocumento', '$tipoDocumento', '$primerNombre', '$segundoNombre', '$primerApellido', '$segundoApellido', '$pass', '$idrol');");

        if($registrar){
            echo "usuario registrado con exito";
            echo "<script>window.location='login.php';</script>";
            
        }else{
            echo "error en registrar";
        }
    }
}else{
    echo"<script>window.location='error.php'</script>";
    echo "<script>alert('error')</script>";
}
?>