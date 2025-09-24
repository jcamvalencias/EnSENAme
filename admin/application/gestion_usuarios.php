<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // tu código aquí
}
?>
<?php
if (isset($_POST['btn_eliminar'])) {
    include '../conexion.php';
    $doc = mysqli_real_escape_string($conexion, $_POST['doc']);

    $eliminar = mysqli_query($conexion, "DELETE FROM usuarios WHERE documento = '$doc'")
        or die("Error al eliminar: " . mysqli_error($conexion));

    echo "<script>alert('Registro eliminado con éxito');</script>";
    echo "<script>window.location='dashboard.php?mod=gestion_usuario';</script>";
}

if (isset($_POST['btn_actualizar'])) {
    include 'conexion.php';

    $tipoDocumento = $_POST['tipoDocumento'] ?? '';
    $numeroDocumento = $_POST['numeroDocumento'] ?? '' ;
    $primerNombre = $_POST['primerNombre']  ?? '';
    $segundoNombre = $_POST['segundoNombre']  ?? '';
    $primerApellido = $_POST['primerApellido'] ?? '' ;
    $segundoApellido = $_POST['segundoApellido'] ?? '';
    $idrol = $_POST['idrol'] ?? '';

    $actualizar = mysqli_query($conexion, "UPDATE `tb_usuarios` SET `Tipo_Documento` = '$tipoDocumento',
    `p_nombre` = '$primerNombre',`s_nombre` = '$segundoNombre',`p_apellido` = '$primerApellido',`s_apellido` 
    = '$segundoApellido', `idrol` = '$idrol' WHERE `ID` = '$numeroDocumento'") or die("Error al enviar la actualización: " . mysqli_error($conexion));

    echo "<script>alert('Registro actualizado con éxito');</script>";
    echo "<script>window.location='http://localhost/enséñame/admin/application/gestion_usuarios.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion usuario</title>
</head>
<body>
        <center>
            <a href="http://localhost/enseñame/admin/application/user-profile.html">Crear</a> | <a href="http://localhost/enseñame/admin/application/gestion_usuarios.php">Gestión</a>
            <br><br>
            <h1>Consultar usuarios</h1>
            <form action="http://localhost/ense%C3%B1ame/admin/application/gestion_usuarios.php" method="post" class="">
                <input type="text" placeholder="Buscar por nombre" name="txt_nom" class="bg-light border-0.5" style="border-radius: 5px;">
                <button type="submit" name="btn_buscar" class="btn btn-primary">Buscar</button>
            </form>
            <br>

            <?php
                if(isset($_POST['btn_buscar'])){
                include "../../conexion.php";
                    $dato = $_POST['primerNombre'] ?? '';
                    $consulta = mysqli_query($conexion,"SELECT * FROM tb_usuarios WHERE p_nombre 
                    LIKE '%$dato%'") or die ($conexion."Error en la consulta");
?>      
                        <table border="1" class="table table-bordered table-responsive" id="dataTable">
                            <tr class="bg-gradient-primary" style="color: white;">
                                <td>Tipo documento</td>
                                <td>Documento</td>
                                <td>Primer Nombre</td>
                                <td>Segundo Nombre</td>
                                <td>Primer Apellido</td>
                                <td>Segundo Apellido</td>
                                <td>Rol</td>
                                <td>Modificar</td>
                                <td>Eliminar</td>
                            </tr>
                        
                        <?php
                        
                        while($row = mysqli_fetch_array($consulta)){
                        ?>
                        <tr>
                            <?php
$tipoDocumento = isset($_POST["tipoDocumento"]) ? $_POST["tipoDocumento"] : "";
$numeroDocumento = isset($_POST["numeroDocumento"]) ? $_POST["numeroDocumento"] : "";
$primerNombre = isset($_POST["primerNombre"]) ? $_POST["primerNombre"] : "";
$segundoNombre = isset($_POST["segundoNombre"]) ? $_POST["segundoNombre"] : "";
$primerApellido = isset($_POST["primerApellido"]) ? $_POST["primerApellido"] : "";
$segundoApellido = isset($_POST["segundoApellido"]) ? $_POST["segundoApellido"] : "";
$idrol = isset($_POST["idrol"]) ? $_POST["idrol"] : "";
?>
                            <td>
                                <center>
                                    <form action="application/gestion_usuario.php" method="post">
                                        <input type="text" name="tipoDocumento" value="<?php echo $row['tipoDocumento']; ?>" hidden>
                                            <button type="submit" name="btn_modificar" style="background-color:#ccc; border: 0px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                </svg>
                                            </button>
                                    </form>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <form action="dashboard.php?mod=gestion_usuario" method="post">
                                        <input type="text" name="doc" value="<?php echo $row['documento']; ?>" hidden>
                                            <button type="submit" style="background-color:#ccc; border: 0px;" name="btn_eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                </svg>
                                            </button>
                                    </form>
                                </center>
                            </td>
                        </tr>
                        
                            <?php
                        }
                    }else{
                        echo "Ingrese datos";
                    }
                        ?>
                        </table>
                    
                
            
        </center>
                   

</body>
</html>

<?php
    if(isset($_POST['btn_modificar'])){
?>
<center>
    <h1>Modificar Usuario</h1>

    <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12 d-lg-block bg-login-image text-center" style="align-content: center;"><img src="img/EducaSex.png" alt="" style="border radius: 30px;"></div>
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Crea una cuenta!</h1>
                            </div>
                            <form action="../codigo.php" method="post" class="user">
                                <div class="form-group">
                                    <label>Tipo de Documento</label>
                                    <select name="Tipo_documento" class="form-control" id="" required>
                                    <option value="">Seleccione</option>
                                    <option value="TI">TI</option>
                                    <option value="CC">CC</option>
                                    <option value="RC">RC</option>
                                </select>
                                </div>
                                

                                <div class="form-group">
                                    <input type="num" class="form-control form-control-user" name="numero_documento" placeholder="Documento" required pattern="^[0-9]{7,11}$" title="Minimo 8 números, maximo 11">
                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="txt_PN" placeholder="Primer Nombre" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="txt_SN" placeholder="Segundo Nombre">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="txt_PA" placeholder="Primer Apellido" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="txt_SA" placeholder="Segundo Apellido" required>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="Password" class="form-control form-control-user" name="clave" placeholder="Contraseña" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Mínimo 8 caracteres, al menos 1 número, 1 minúscula y 1 mayúscula.">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="Password" class="form-control form-control-user" id="c_clave" name="c_clave" placeholder="Confirmar contraseña" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Rol</label>
                                    <select name="Cmb_rol" class="form-control" id="" placeholder="Id_rol" required>
                                        <option value="">Seleccione</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Operario</option>
                                        <option value="3">Asesor</option>
                                    </select>
                                </div>
                                
                                <input type="submit" name="BtnRegistrar" value="Registrarse" class="btn btn-primary btn-user btn-block">

                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Olvidaste la contraseña?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="index.php">Ya tienes cuenta? Inicia sesión!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</center>
<?php
    }
?>


