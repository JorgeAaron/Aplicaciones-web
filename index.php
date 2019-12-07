
<?php

// Iniciamos o retomamos la sesión

if(!isset($_SESSION)) {
  session_start();
  //session_destroy();

    if(isset($_SESSION['usuarioId'])) header('Location: index.php');

 }

// Incluimos la conexión a la BD
include("conn/connLocalhost.php");
include("includes/utils.php");

// Validamos que el formulario se haya enviado
if(isset($_POST['sent'])) {
  // validamos campos vacios
  foreach ($_POST as $calzon => $caca) {
    if($caca == "") $error[] = "The field $calzon is required";
  }

  // Continuamos con la validación siempre y cuando estemos libres de errores
  if(!isset($error)) {
    // Armamos la consulta con datos sanitizados
    $queryLoginUser = sprintf("SELECT idUsuario, Nivel, Nombre, Correo,Direccion FROM usuario WHERE Correo = '%s' AND Contraseña = '%s'",
        mysqli_real_escape_string($connLocalhost, trim($_POST['Correo'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['Contraseña']))
    );

    // Ejecutamos el query
    $resQueryLoginUser = mysqli_query($connLocalhost, $queryLoginUser) or trigger_error("The query for user validation has failed");

    //Evaluamos el resultado, si es exitoso, creamos los indices de sesión
    if(mysqli_num_rows($resQueryLoginUser)) {
      // Hacemos un fetch del resultset
      $userData = mysqli_fetch_assoc($resQueryLoginUser);

      // Definimos los indices de sesión
      $_SESSION['usuarioId'] = $userData['idUsuario'];
        $_SESSION['usuarioNivel'] = $userData['Nivel'];
          $_SESSION['usuarioNombre'] = $userData['Nombre'];
      $_SESSION['usuarioCorreo'] = $userData['Correo'];
        $_SESSION['usuarioCorreo'] = $userData['Contraseña'];
      $_SESSION['UsuarioDireccion'] = $userData['Direccion'];

      // Una vez definidos los indices de sesion realizamos una redirección hacia Control Panel

if ($_SESSION['usuarioNivel']==1) {
  header("Location: index_admin.php?login=true");
}if ($_SESSION['usuarioNivel']==2) {
  header("Location: index_usr.php?login=true");
}if ($_SESSION['usuarioNivel']==3) {
  header("Location: index_proveedor.php?login=true");
}


    }
    else {
      $error[] = "The credentials provided were incorrect... please try again!";
    }

  }

}




?>







<!DOCTYPE html>
<html lang="en">




    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Site Metas -->
    <title>Inicio</title>
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


  <script type="text/javascript">
  <!--
  function MM_jumpMenuGo(objId,targ,restore){ //v9.0
    var selObj = null;  with (document) {
    if (getElementById) selObj = getElementById(objId);
    if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
    if (restore) selObj.selectedIndex=0; }
  }
  //-->
  </script>

</head>
<body>

    <div id="wrapper">
      <header class="market-header header">
          <div class="container-fluid">
              <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
                  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                  </button>
                  <a class="navbar-brand" href="marketing-index.html"><img src="images/version/market-logo.png" alt=""></a>
                  <div class="collapse navbar-collapse" id="navbarCollapse">
                      <ul class="navbar-nav mr-auto">
                          <li class="nav-item">
                              <a class="nav-link" href="marketing-index.html">Inicio</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="categoria.php">Categorias</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="marketing-category.html">Compras</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="marketing-contact.html">Contactanos</a>
                          </li>
                      </ul>

                  </div>
              </nav>
          </div><!-- end container-fluid -->
      </header><!-- end market-header -->

        <section id="cta" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 align-self-center">
                        <h2>A digital marketing blog</h2>
                        <p class="lead"> Aenean ut hendrerit nibh. Duis non nibh id tortor consequat cursus at mattis felis. Praesent sed lectus et neque auctor dapibus in non velit. Donec faucibus odio semper risus rhoncus rutrum. Integer et ornare mauris.</p>
                        <a href="#" class="btn btn-primary">Try for free</a>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="newsletter-widget text-center align-self-center">
                            <h3>Inicia sesion</h3>
                            <?php
                              if(isset($error)) printMsg($error, "error");
                              if(isset($_GET['loggedOut'])) printMsg("You have logged out succesfully from the system.", "exito");
                              if(isset($_GET['authError'])) printMsg("You are not authorized to access this content.", "error");
                            ?>
                            <form class="form-inline" method="post" action="index.php">
                                <input type="text" name="Correo" placeholder="Coloca tu correo" value= "<?php if(isset($_POST['Correo'])) echo $_POST['Correo']; ?>" required class="form-control" />
                                <input type="password" name="Contraseña" placeholder="contraseña" requiered class="form-control" />

                                <input type="submit" value="Iniciar sesion" name ="sent" class="btn btn-default btn-block" />
                                <br>
                                <p style ="fontfont-size: 10px;">En caso de no tener un cuenta cree una</p>

                            </form>
                            <a type="button" style ="background: #f9ca27 !important;"class="btn btn-warning" href="registro_usr.php" >Registrarse</a>
                          <!--  <a type="button" style ="background: #9CDED5 !important;"class=" btn btn-primary" href="#" >Link</a> -->
                        </div><!-- end newsletter -->
                    </div>
                </div>
            </div>
        </section>

        <section class="section lb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <div class="blog-custom-build">
                                <div class="blog-box wow fadeIn">
                                    <div class="post-media">
                                        <a href="marketing-single.html" title="">
                                            <img src="upload/market_blog_01.jpg" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span></span>
                                            </div>
                                            <!-- end hover -->
                                        </a>
                                    </div>
                                    <!-- end media -->
                                    <div class="blog-meta big-meta text-center">
                                        <div class="post-sharing">
                                            <ul class="list-inline">
                                                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                            </ul>
                                        </div><!-- end post-sharing -->
                                        <h4><a href="marketing-single.html" title="">You can learn how to make money with your blog and videos</a></h4>
                                        <p>Aenean interdum arcu blandit, vehicula magna non, placerat elit. Mauris et pharetratortor. Suspendissea sodales urna. In at augue elit. Vivamus enimcerat elicerat eli nibh, maximus ac felis nec, maximus tempor odio.</p>
                                        <small><a href="marketing-category.html" title="">Make Money</a></small>
                                        <small><a href="marketing-single.html" title="">24 July, 2017</a></small>
                                        <small><a href="#" title="">by Jack</a></small>
                                        <small><a href="#" title=""><i class="fa fa-eye"></i> 2291</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->

                                <hr class="invis">

                                <div class="blog-box wow fadeIn">
                                    <div class="post-media">
                                        <a href="marketing-single.html" title="">
                                            <img src="upload/market_blog_02.jpg" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span></span>
                                            </div>
                                            <!-- end hover -->
                                        </a>
                                    </div>
                                    <!-- end media -->
                                    <div class="blog-meta big-meta text-center">
                                        <div class="post-sharing">
                                            <ul class="list-inline">
                                                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                            </ul>
                                        </div><!-- end post-sharing -->
                                        <h4><a href="marketing-single.html" title="">The way to reach hundreds of thousands of customers is through the SEO</a></h4>
                                        <p>Aenean interdum arcu blandit, vehicula magna non, placerat elit. Mauris et pharetratortor. Suspendissea sodales urna. In at augue elit. Vivamus enimcerat elicerat eli nibh, maximus ac felis nec, maximus tempor odio.</p>
                                        <small><a href="marketing-category.html" title="">Marketing</a></small>
                                        <small><a href="marketing-single.html" title="">21 July, 2017</a></small>
                                        <small><a href="#" title="">by Jack</a></small>
                                        <small><a href="#" title=""><i class="fa fa-eye"></i> 666</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->

                                <hr class="invis">

                                <div class="blog-box wow fadeIn">
                                    <div class="post-media">
                                        <a href="marketing-single.html" title="">
                                            <img src="upload/market_blog_03.jpg" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span></span>
                                            </div>
                                            <!-- end hover -->
                                        </a>
                                    </div>
                                    <!-- end media -->
                                    <div class="blog-meta big-meta text-center">
                                        <div class="post-sharing">
                                            <ul class="list-inline">
                                                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                            </ul>
                                        </div><!-- end post-sharing -->
                                        <h4><a href="marketing-single.html" title="">Ways to reach the world through mobile phones</a></h4>
                                        <p>Aenean interdum arcu blandit, vehicula magna non, placerat elit. Mauris et pharetratortor. Suspendissea sodales urna. In at augue elit. Vivamus enimcerat elicerat eli nibh, maximus ac felis nec, maximus tempor odio.</p>
                                        <small><a href="marketing-category.html" title="">Technology</a></small>
                                        <small><a href="marketing-single.html" title="">20 July, 2017</a></small>
                                        <small><a href="#" title="">by Martin</a></small>
                                        <small><a href="#" title=""><i class="fa fa-eye"></i> 441</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->

                                <hr class="invis">

                                <div class="blog-box wow fadeIn">
                                    <div class="post-media">
                                        <a href="marketing-single.html" title="">
                                            <img src="upload/market_blog_04.jpg" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span></span>
                                            </div>
                                            <!-- end hover -->
                                        </a>
                                    </div>
                                    <!-- end media -->
                                    <div class="blog-meta big-meta text-center">
                                        <div class="post-sharing">
                                            <ul class="list-inline">
                                                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                            </ul>
                                        </div><!-- end post-sharing -->
                                        <h4><a href="marketing-single.html" title="">Would you like to work as a freelancer for lifetime?</a></h4>
                                        <p>Aenean interdum arcu blandit, vehicula magna non, placerat elit. Mauris et pharetratortor. Suspendissea sodales urna. In at augue elit. Vivamus enimcerat elicerat eli nibh, maximus ac felis nec, maximus tempor odio.</p>
                                        <small><a href="marketing-category.html" title="">Technology</a></small>
                                        <small><a href="marketing-single.html" title="">20 July, 2017</a></small>
                                        <small><a href="#" title="">by Martin</a></small>
                                        <small><a href="#" title=""><i class="fa fa-eye"></i> 8934</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->

                                <hr class="invis">

                                <div class="blog-box wow fadeIn">
                                    <div class="post-media">
                                        <a href="marketing-single.html" title="">
                                            <img src="upload/market_blog_05.jpg" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span></span>
                                            </div>
                                            <!-- end hover -->
                                        </a>
                                    </div>
                                    <!-- end media -->
                                    <div class="blog-meta big-meta text-center">
                                        <div class="post-sharing">
                                            <ul class="list-inline">
                                                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                            </ul>
                                        </div><!-- end post-sharing -->
                                        <h4><a href="marketing-single.html" title="">Ten golden rules to be followed for a real team work</a></h4>
                                        <p>Aenean interdum arcu blandit, vehicula magna non, placerat elit. Mauris et pharetratortor. Suspendissea sodales urna. In at augue elit. Vivamus enimcerat elicerat eli nibh, maximus ac felis nec, maximus tempor odio.</p>
                                        <small><a href="marketing-category.html" title="">Technology</a></small>
                                        <small><a href="marketing-single.html" title="">19 July, 2017</a></small>
                                        <small><a href="#" title="">by Martin</a></small>
                                        <small><a href="#" title=""><i class="fa fa-eye"></i> 451</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->

                                <hr class="invis">

                                <div class="blog-box wow fadeIn">
                                    <div class="post-media">
                                        <a href="marketing-single.html" title="">
                                            <img src="upload/market_blog_06.jpg" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span></span>
                                            </div>
                                            <!-- end hover -->
                                        </a>
                                    </div>
                                    <!-- end media -->
                                    <div class="blog-meta big-meta text-center">
                                        <div class="post-sharing">
                                            <ul class="list-inline">
                                                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                            </ul>
                                        </div><!-- end post-sharing -->
                                        <h4><a href="marketing-single.html" title="">Thanks to the Internet, there is no limit to what you will just try!</a></h4>
                                        <p>Aenean interdum arcu blandit, vehicula magna non, placerat elit. Mauris et pharetratortor. Suspendissea sodales urna. In at augue elit. Vivamus enimcerat elicerat eli nibh, maximus ac felis nec, maximus tempor odio.</p>
                                        <small><a href="marketing-category.html" title="">Technology</a></small>
                                        <small><a href="marketing-single.html" title="">19 July, 2017</a></small>
                                        <small><a href="#" title="">by Martin</a></small>
                                        <small><a href="#" title=""><i class="fa fa-eye"></i> 192</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->
                            </div>
                        </div>

                        <hr class="invis">

                        <div class="row">
                            <div class="col-md-12">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="sidebar">
                            <div class="widget">
                                <h2 class="widget-title">Recent Posts</h2>
                                <div class="blog-list-widget">
                                    <div class="list-group">
                                        <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="w-100 justify-content-between">
                                                <img src="upload/small_07.jpg" alt="" class="img-fluid float-left">
                                                <h5 class="mb-1">5 Beautiful buildings you need to before dying</h5>
                                                <small>12 Jan, 2016</small>
                                            </div>
                                        </a>

                                        <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="w-100 justify-content-between">
                                                <img src="upload/small_08.jpg" alt="" class="img-fluid float-left">
                                                <h5 class="mb-1">Let's make an introduction for creative life</h5>
                                                <small>11 Jan, 2016</small>
                                            </div>
                                        </a>

                                        <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="w-100 last-item justify-content-between">
                                                <img src="upload/small_09.jpg" alt="" class="img-fluid float-left">
                                                <h5 class="mb-1">Did you see the most beautiful sea in the world?</h5>
                                                <small>07 Jan, 2016</small>
                                            </div>
                                        </a>
                                    </div>
                                </div><!-- end blog-list -->
                            </div><!-- end widget -->

                            <div id="" class="widget">
                                <h2 class="widget-title">Advertising</h2>
                                <div class="banner-spot clearfix">
                                    <div class="banner-img">
                                        <img src="upload/banner_03.jpg" alt="" class="img-fluid">
                                    </div><!-- end banner-img -->
                                </div><!-- end banner -->
                            </div><!-- end widget -->

                            <div class="widget">
                                <h2 class="widget-title">Instagram Feed</h2>
                                <div class="instagram-wrapper clearfix">
                                    <a class="" href="#"><img src="upload/small_09.jpg" alt="" class="img-fluid"></a>
                                    <a href="#"><img src="upload/small_01.jpg" alt="" class="img-fluid"></a>
                                    <a href="#"><img src="upload/small_02.jpg" alt="" class="img-fluid"></a>
                                    <a href="#"><img src="upload/small_03.jpg" alt="" class="img-fluid"></a>
                                    <a href="#"><img src="upload/small_04.jpg" alt="" class="img-fluid"></a>
                                    <a href="#"><img src="upload/small_05.jpg" alt="" class="img-fluid"></a>
                                    <a href="#"><img src="upload/small_06.jpg" alt="" class="img-fluid"></a>
                                    <a href="#"><img src="upload/small_07.jpg" alt="" class="img-fluid"></a>
                                    <a href="#"><img src="upload/small_08.jpg" alt="" class="img-fluid"></a>
                                </div><!-- end Instagram wrapper -->
                            </div><!-- end widget -->

                            <div class="widget">
                                <h2 class="widget-title">Popular Categories</h2>
                                <div class="link-widget">
                                    <ul>
                                        <li><a href="#">Marketing <span>(21)</span></a></li>
                                        <li><a href="#">SEO Service <span>(15)</span></a></li>
                                        <li><a href="#">Digital Agency <span>(31)</span></a></li>
                                        <li><a href="#">Make Money <span>(22)</span></a></li>
                                        <li><a href="#">Blogging <span>(66)</span></a></li>
                                        <li><a href="#">Entertaintment <span>(11)</span></a></li>
                                        <li><a href="#">Video Tuts <span>(87)</span></a></li>
                                    </ul>
                                </div><!-- end link-widget -->
                            </div><!-- end widget -->
                        </div><!-- end sidebar -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <h2 class="widget-title">Recent Posts</h2>
                            <div class="blog-list-widget">
                                <div class="list-group">
                                    <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/small_04.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">5 Beautiful buildings you need to before dying</h5>
                                            <small>12 Jan, 2016</small>
                                        </div>
                                    </a>

                                    <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/small_05.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">Let's make an introduction for creative life</h5>
                                            <small>11 Jan, 2016</small>
                                        </div>
                                    </a>

                                    <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 last-item justify-content-between">
                                            <img src="upload/small_06.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">Did you see the most beautiful sea in the world?</h5>
                                            <small>07 Jan, 2016</small>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- end blog-list -->
                        </div><!-- end widget -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <h2 class="widget-title">Popular Posts</h2>
                            <div class="blog-list-widget">
                                <div class="list-group">
                                    <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/small_01.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">Banana-chip chocolate cake recipe with customs</h5>
                                            <span class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </span>
                                        </div>
                                    </a>

                                    <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/small_02.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">10 practical ways to choose organic vegetables</h5>
                                            <span class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </span>
                                        </div>
                                    </a>

                                    <a href="marketing-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 last-item justify-content-between">
                                            <img src="upload/small_03.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">We are making homemade ravioli, nice and good</h5>
                                            <span class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- end blog-list -->
                        </div><!-- end widget -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <h2 class="widget-title">Popular Categories</h2>
                            <div class="link-widget">
                                <ul>
                                    <li><a href="#">Marketing <span>(21)</span></a></li>
                                    <li><a href="#">SEO Service <span>(15)</span></a></li>
                                    <li><a href="#">Digital Agency <span>(31)</span></a></li>
                                    <li><a href="#">Make Money <span>(22)</span></a></li>
                                    <li><a href="#">Blogging <span>(66)</span></a></li>
                                    <li><a href="#">Entertaintment <span>(11)</span></a></li>
                                    <li><a href="#">Video Tuts <span>(87)</span></a></li>
                                </ul>
                            </div><!-- end link-widget -->
                        </div><!-- end widget -->
                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-md-12 text-center">
                        <br>
                        <br>
                        <div class="copyright">&copy; Markedia. Design: <a href="http://html.design">HTML Design</a>.</div>
                    </div>
                </div>
            </div><!-- end container -->
        </footer><!-- end footer -->

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
