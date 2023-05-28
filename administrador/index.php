<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_u.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Administrador</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<div class="container-fluid">
  <div class="row align-items-start gutter">
    <!--<div class="col-3 border mb-4">
      
    </div>-->
    <div class="container-fluid">
      <div class="row flex-nowrap">
          <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
              <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                  <a href="index.html" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                      <span class="fs-5 d-none d-sm-inline">Menu</span>
                  </a>
                  <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                      <li class="nav-item">
                          <a href="#" class="nav-link align-middle px-0">
                              <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Perfil</span>
                          </a>
                      </li>
                      <li>
                          <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                              <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Rutinas</span> </a>
                          <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                              <li class="w-100">
                                  <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Ver rutinas</span></a>
                              </li>
                              <li>
                                  <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Agregar rutinas</span></a>
                              </li>
                          </ul>
                      </li>
                      <li>
                          <a href="#" class="nav-link px-0 align-middle">
                              <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Entrenamiento</span></a>
                      </li>
                      <li>
                          <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                              <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Ejercicios</span></a>
                          <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                              <li class="w-100">
                                  <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Ver ejercicios</span></a>
                              </li>
                              <li>
                                  <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Agregar ejercicios</span></a>
                              </li>
                          </ul>
                      </li>
                      <li>
                          <a href="#" class="nav-link px-0 align-middle">
                              <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Cerrar sesion</span> </a>
                      </li>
                  </ul>
                  <hr>
                  <div class="dropdown pb-4">
                      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                          <img src="profile.jpg" alt="hugenerd" width="30" height="30" class="rounded-circle">
                          <span class="d-none d-sm-inline mx-1">
                            <?php echo $_SESSION['id_usuario']; ?>
                          </span>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                          <li><a class="dropdown-item" href="#">Perfil</a></li>
                          <li>
                              <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="col py-3">
            <?php  if(isset($_SESSION['id_usuario'])): ?>
              <p class="bienvenida" style="font-size: 80px; text-align:center">Bienvenido <?php echo $_SESSION['id_usuario']; ?></p> 
            <?php endif; ?>
            <div class="d-flex justify-content-center">
            <img class="img-fluid mx-auto" src="../assets/img/imagen8.jpg" alt="nada" style="width:60%;">
            </div>
          </div>
      </div>
  </div>
  </div>
</div>
</div>
</body>
</html>