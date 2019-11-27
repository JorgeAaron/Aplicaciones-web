
<?php

include("conn/connLocalhost.php");
echo "se hizo";
print_r($connLocalhost);

if(isset($_POST['sent'])) {

  // Validacion de cajas vacias
  foreach ($_POST as $calzon => $caca) {
    if($caca == "" && $calzon != "nombre") $error[] = "The field $calzon is required";
  }

  // Validacion de password coincidentes
  if($_POST['contraseña'] != $_POST['contraseña1']) $error[] = "The password doesn't match";

  // Validación de email existente
  // Primero determinamos que solo se ejecute la validación cuando tenemos la certeza de que se capturó un email
  if(isset($_POST['correo']) && isset($_POST['correo']) != "") {
    $queryValidateEmail = sprintf("SELECT id FROM usuario WHERE email = '%s'",
      mysqli_real_escape_string($connLocalhost, trim($_POST['correo']))
    );

    // Ejecutamos el Query y obtenemos un recordset debido a que el query es de tipo SELECT
    $resQueryValidateEmail = mysqli_query($connLocalhost, $queryValidateEmail) or trigger_error("error_msg");

    // Contamos cuantos registros fueron devueltos por la consulta anterior, si obtenemos un numero distinto de 0 quiere decir que el correo ya está siendo utilizado
    if(mysqli_num_rows($resQueryValidateEmail) != 0) {
      $error[] = "The email is already in use...";
    }
  }

  // Inserción del nuevo usuario en la base de datos, solamente se ejecutará cuando NO EXISTAN ERRORES
  if(!isset($error)) {
    // Definimos el query a ejecutar
    $queryUserAdd = sprintf("INSERT INTO usuario (nivel, nombre, correo, contraseña, Direccion) VALUES ( '%s', '%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($connLocalhost,trim($_POST['nivel'])),
        mysqli_real_escape_string($connLocalhost,trim($_POST['nombre'])),
        mysqli_real_escape_string($connLocalhost,trim($_POST['correo'])),
        mysqli_real_escape_string($connLocalhost,trim($_POST['contraseña'])),
        mysqli_real_escape_string($connLocalhost,trim($_POST['direccion']))

    );

    // Ejecutamos el query y cachamos el resultado
    $resQueryUserAdd = mysqli_query($connLocalhost, $queryUserAdd) or trigger_error("The user insert query failed...");

    // Redireccionamos al usuario si todo salio bien
    if($resQueryUserAdd) {
      echo "se agrego ala base";
    }
  }

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Site Metas -->
    <title>Markedia - Marketing Blog Template</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Design fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- FontAwesome Icons core CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- Animate styles for this template -->
    <link href="css/animate.css" rel="stylesheet">

    <!-- Responsive styles for this template -->
    <link href="css/responsive.css" rel="stylesheet">

    <!-- Colors for this template -->
    <link href="css/colors.css" rel="stylesheet">

    <!-- Version Marketing CSS for this template -->
    <link href="css/version/marketing.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
   <div>
     <div class="newsletter-widget text-center align-self-center">
                            <h3>Registro Administrador</h3>

                            <form class="form-inline" method="post">
                                <input type="text" name="correo" placeholder="Coloca tu correo" required class="form-control" />

                                 <input type="text" name="nombre" placeholder="Nombre completo" required class="form-control" />

                                <input type="password" name="contraseña" placeholder="contraseña" requiered class="form-control" />
                                <input type="password" name="contraseña1" placeholder="repite contraseña" requiered class="form-control" />

                                 <input type="text" name="direccion" placeholder="Direccion" required class="form-control" />

                                <select required class="form-control" name="nivel">
                                    <option  value=1>Administrador</option>
                                    <option value=2>Ditribuidor</option>
                                    <option value=3>Usuario</option>
                                    </select>


                                <input type="submit" name="sent" value="Iniciar sesion" class="btn btn-default btn-block" />

                            </form>
                        </div><!-- end newsletter -->
                    </div>

        <div class="dmtop">Scroll to Top</div>



    </div><!-- end wrapper -->

    <!-- Core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/custom.js"></script>

</body>
</html>
