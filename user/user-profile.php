<?php
// include central de sesión (autogenerado)
$sessionInclude = __DIR__ . '/../includes/session.php';
if (file_exists($sessionInclude)) {
    require_once $sessionInclude;
} else {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>EnSEÑAme</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">  

  <!-- [Favicon] icon -->
  <link rel="icon" href="../admin/assets/images/favisena.png" type="image/x-icon"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="../admin/assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="../admin/assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="../admin/assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="../admin/assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="../admin/assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="../admin/assets/css/style-preset.css" >

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="../dashboard/index.php" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="../admin/assets/images/logoensename.png" class="img-fluid" alt="">
      </a>
    </div>
    <div class="navbar-content">
    <ul class="pc-navbar">
  <li class="pc-item">
    <a href="../dashboard/index.php" class="pc-link">
      <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
      <span class="pc-mtext">Inicio</span>
    </a>
  </li>     
  
  <li class="pc-item">
    <a href="http://localhost/ense%C3%B1ame/admin/application/usuarios.php" class="pc-link">
      <span class="pc-micon"><i class="ti ti-users"></i></span>
      <span class="pc-mtext">Usuarios</span>
    </a>
  </li>

  <li class="pc-item">
      <a href="../application/user-list.html" class="pc-link">
        <span class="pc-micon"><i class="ti ti-color-swatch"></i></span>
        <span class="pc-mtext">Producto</span>
      </a>
  </li>
  <li class="pc-item">
          <a href="../application/servicio.php" class="pc-link">
            <span class="pc-micon"><i class="ti ti-brand-chrome"></i></span>
            <span class="pc-mtext">Servicio</span>
          </a>
        </li>
</ul>

    </div>
    
  </div>
</nav>

<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="dropdown pc-h-item d-inline-flex d-md-none">
      <a
        class="pc-head-link dropdown-toggle arrow-none m-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ti ti-search"></i>
      </a>
      <div class="dropdown-menu pc-h-dropdown drp-search">
        <form class="px-3">
          <div class="form-group mb-0 d-flex align-items-center">
            <i data-feather="search"></i>
            <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
          </div>
        </form>
      </div>
    </li>
    
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">    
    <li class="dropdown pc-h-item header-user-profile">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        data-bs-auto-close="outside"
        aria-expanded="false"
      >
        <img src="../admin/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
        <span>Camilo</span>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex mb-1">
            <div class="flex-shrink-0">
              <img src="../admin/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1">Camilo</h6>
              <span>Admin</span>
            </div>
            
          </div>
        </div>
        <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="drp-t1"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-1"
              type="button"
              role="tab"
              aria-controls="drp-tab-1"
              aria-selected="true"
              ><i class="ti ti-user"></i> Perfil</button
            >
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="drp-t2"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-2"
              type="button"
              role="tab"
              aria-controls="drp-tab-2"
              aria-selected="false"
              ><i class="ti ti-settings"></i> Configuración</button
            >
          </li>
        </ul>
        <div class="tab-content" id="mysrpTabContent">
          <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
            <a href="logout.php" class="dropdown-item">
              <i class="ti ti-power"></i>
              <span>Logout</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>View Profile</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-power"></i>
              <span>Logout</span>
            </a>
          </div>
          <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
            <a href="#!" class="dropdown-item">
              <i class="ti ti-help"></i>
              <span>Support</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>Account Settings</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-messages"></i>
              <span>Feedback</span>
            </a>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>
 </div>
</header>
<!-- [ Header ] end -->

  <!-- [ Main Content ] start -->

<!-- [ Header ] end -->



  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                <li class="breadcrumb-item" aria-current="page">User Profile</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Registro de perfil de usuario</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">          
            </div>
            <div class="col-md-8">
              <div class="tab-content" id="user-set-tabContent">
                <div class="tab-pane fade show active" id="user-cont-1" role="tabpanel">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-10">
                          <h5>Información personal</h5>
                          <hr class="mb-4">
                          <?php
                          if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $tipoDocumento = $_POST["tipoDocumento"];
                            $numeroDocumento = $_POST["numeroDocumento"];
                            $primerNombre = $_POST["primerNombre"];
                            $segundoNombre = $_POST["segundoNombre"];
                            $primerApellido = $_POST["primerApellido"];
                            $segundoApellido = $_POST["segundoApellido"];
                          }
                          ?>
                        <form action="http://localhost/enseñame/admin/dashboard/index.php" method="post"></form>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="tipoDocumento">Tipo de Documento:                       
                            <select name="tipoDocumento" id="tipoDocumento" required>
                              <option value="">Seleccione</option>
                              <option value="1">TI</option>
                              <option value="2">CC</option>
                              <option value="3">NN</option>
                            </select>
                          </label> 
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="numeroDocumento">Número de Documento:</label>
                              <input type="text" name="numeroDocumento" id="numeroDocumento" required>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="primerNombre">Primer Nombre:</label>
                            <input type="text" name="primerNombre" id="primerNombre" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="segundoNombre">Segundo Nombre:</label>
                            <input type="text" name="segundoNombre" id="segundoNombre" requerid>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="primerApellido">Primer Apellido:</label>
                            <input type="text" name="primerApellido" id="primerApellido" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="segundoApellido">Segundo Apellido:</label>
                            <input type="text" name="segundoApellido" id="segundoApellido">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="clave">Clave:</label>
                            <input type="password" name="clave" id="clave" required>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="confirmarClave">CClave:</label>
                            <input type="password" name="confirmarClave" id="confirmarClave" required>
                          </div>
                        </div>                        
                      </div>
                      
                      <button type="submit" name="btn_registrar" id="btn_registrar" class="btn btn-primary">Registrar</button>
                    </div>
                    </form>
                 </div>
                   <script>
                    function validarFormulario() {
                    const clave = document.getElementById('clave').value;
                    const confirmarClave = document.getElementById('confirmarClave').value;
                    const mensajeError = document.getElementById('mensajeError');

                    if (clave !== confirmarClave) {
                    mensajeError.textContent = "Las claves no coinciden.";
                    return false;
                    } else {
                    mensajeError.textContent = "";
                    return true;
                    }
                    }
                  </script>

                </div>                
                <div class="tab-pane fade" id="user-cont-3" role="tabpanel">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12">
                          <h5>Change Password</h5>
                          <hr class="mb-4">
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-label">Old Password</label>
                            <input type="password" class="form-control">
                          </div>
                          <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control">
                          </div>
                          <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <h5>New password must contain:</h5>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 8 characters</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 lower letter (a-z)</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 uppercase letter (A-Z)</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 number (0-9)</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 special characters</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-end btn-page">
                      <div class="btn btn-outline-secondary">Cancel</div>
                      <div class="btn btn-primary">Save</div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="user-cont-4" role="tabpanel">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12">
                          <h5>Settings</h5>
                          <hr class="mb-4">
                        </div>
                        <div class="col-sm-12">
                          <ul class="list-group list-group-flush">                                                        
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-end btn-page">
                      <div class="btn btn-outline-secondary">Cancel</div>
                      <div class="btn btn-primary">Save</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
      </div>
      <!-- [ Main Content ] end -->
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p>
        </p>
        </div>
        <div class="col-auto my-1">
          <ul class="list-inline footer-link mb-0">
            <li class="list-inline-item"><a href="../dashboard/index.php">Home</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer> <!-- Required Js -->
<script src="../admin/assets/js/plugins/popper.min.js"></script>
<script src="../admin/assets/js/plugins/simplebar.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../admin/assets/js/fonts/custom-font.js"></script>
<script src="../admin/assets/js/pcoded.js"></script>
<script src="../admin/assets/js/plugins/feather.min.js"></script>





<script>layout_change('light');</script>




<script>change_box_container('false');</script>



<script>layout_rtl_change('false');</script>


<script>preset_change("preset-1");</script>


<script>font_change("Public-Sans");</script>

    

  <!-- page js start -->
  <script src="../assets/js/plugins/apexcharts.min.js"></script>
  <script src="../assets/js/plugins/choices.min.js"></script>
  <script>
    (function () {
      var options = {
        series: [30],
        chart: {
          height: 150,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            hollow: {
              margin: 0,
              size: '60%',
              background: 'transparent',
              imageOffsetX: 0,
              imageOffsetY: 0,
              position: 'front',
            },
            track: {
              background: '#ffffff50',
              strokeWidth: '50%',
            },

            dataLabels: {
              show: true,
              name: {
                show: false,
              },
              value: {
                formatter: function (val) {
                  return parseInt(val);
                },
                offsetY: 7,
                color: '#153364',
                fontSize: '20px',
                fontWeight: '700',
                show: true,
              }
            }
          }
        },
        colors: ['#1890ff'],
        fill: {
          type: 'solid',
        },
        stroke: {
          lineCap: 'round'
        },
      };
      var chart = new ApexCharts(document.querySelector("#profile-chart"), options);
      chart.render();
    })();
    new Choices(document.getElementById('pc_product_tag3'), {
      delimiter: ',',
      editItems: true,
      removeItemButton: true
    });
  </script>
  <!-- page js end -->
  <div class="offcanvas pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
    <div class="offcanvas-header bg-primary">
      <h5 class="offcanvas-title text-white">Mantis Customizer</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="pct-body" style="height: calc(100% - 60px)">
      <div class="offcanvas-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse1">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-layout-sidebar f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Theme Layout</h6>
                  <span>Choose your layout</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse1">
              <div class="pct-content">
                <div class="pc-rtl">
                  <p class="mb-1">Direction</p>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="layoutmodertl">
                    <label class="form-check-label" for="layoutmodertl">RTL</label>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse2">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-brush f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Theme Mode</h6>
                  <span>Choose light or dark mode</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse2">
              <div class="pct-content">
                <div class="theme-color themepreset-color theme-layout">
                  <a href="#!" class="active" onclick="layout_change('light')" data-value="false"
                    ><span><img src="../assets/images/customization/default.svg" alt="img"></span><span>Light</span></a
                  >
                  <a href="#!" class="" onclick="layout_change('dark')" data-value="true"
                    ><span><img src="../assets/images/customization/dark.svg" alt="img"></span><span>Dark</span></a
                  >
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse3">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-color-swatch f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Color Scheme</h6>
                  <span>Choose your primary theme color</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse3">
              <div class="pct-content">
                <div class="theme-color preset-color">
                  <a href="#!" class="active" data-value="preset-1"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 1</span></a
                  >
                  <a href="#!" class="" data-value="preset-2"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 2</span></a
                  >
                  <a href="#!" class="" data-value="preset-3"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 3</span></a
                  >
                  <a href="#!" class="" data-value="preset-4"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 4</span></a
                  >
                  <a href="#!" class="" data-value="preset-5"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 5</span></a
                  >
                  <a href="#!" class="" data-value="preset-6"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 6</span></a
                  >
                  <a href="#!" class="" data-value="preset-7"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 7</span></a
                  >
                  <a href="#!" class="" data-value="preset-8"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 8</span></a
                  >
                  <a href="#!" class="" data-value="preset-9"
                    ><span><img src="../assets/images/customization/theme-color.svg" alt="img"></span><span>Theme 9</span></a
                  >
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item pc-boxcontainer">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse4">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-border-inner f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Layout Width</h6>
                  <span>Choose fluid or container layout</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse4">
              <div class="pct-content">
                <div class="theme-color themepreset-color boxwidthpreset theme-container">
                  <a href="#!" class="active" onclick="change_box_container('false')" data-value="false"><span><img src="../assets/images/customization/default.svg" alt="img"></span><span>Fluid</span></a>
                  <a href="#!" class="" onclick="change_box_container('true')" data-value="true"><span><img src="../assets/images/customization/container.svg" alt="img"></span><span>Container</span></a>
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse5">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-xs bg-light-primary">
                    <i class="ti ti-typography f-18"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-1">Font Family</h6>
                  <span>Choose your font family.</span>
                </div>
                <i class="ti ti-chevron-down"></i>
              </div>
            </a>
            <div class="collapse show" id="pctcustcollapse5">
              <div class="pct-content">
                <div class="theme-color fontpreset-color">
                  <a href="#!" class="active" onclick="font_change('Public-Sans')" data-value="Public-Sans"
                    ><span>Aa</span><span>Public Sans</span></a
                  >
                  <a href="#!" class="" onclick="font_change('Roboto')" data-value="Roboto"><span>Aa</span><span>Roboto</span></a>
                  <a href="#!" class="" onclick="font_change('Poppins')" data-value="Poppins"><span>Aa</span><span>Poppins</span></a>
                  <a href="#!" class="" onclick="font_change('Inter')" data-value="Inter"><span>Aa</span><span>Inter</span></a>
                </div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="collapse show">
              <div class="pct-content">
                <div class="d-grid">
                  <button class="btn btn-light-danger" id="layoutreset">Reset Layout</button>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</body>
<!-- [Body] end -->

</html>