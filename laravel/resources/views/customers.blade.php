<!--
=========================================================
* Material Dashboard 2 - v3.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/img/favicon.png">
  <title>
    Material Dashboard 2 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="/css/material-dashboard.css?v=3.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-200">
  <aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="" target="_blank">
        <span class="ms-1 font-weight-bold text-white">Administrative Manager</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary " href="/admin/customers">
            <span class="nav-link-text ms-1">Customers</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white  " href="/admin/managers">
            <span class="nav-link-text ms-1">Managers</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white  " href="/admin/restaurants">
            <span class="nav-link-text ms-1">Restaurants</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white  " href="/admin/orders">
            <span class="nav-link-text ms-1">Orders</span>
          </a>
        </li>
      </ul>
    </div>

  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="container">
          <div class="col-md-12">
            <div class="card" style="padding: 20px;">
              <h2>Customers</h2>
              @foreach($customers_list->listCustomers() as $customer)
              <div class="customer" style="border: 1px solid #555; padding: 10px;">
                <p>
                  <b>ID : </b>
                  @php
                  echo $customer->getID();
                  @endphp
                </p>

                <p>
                  <b>Name : </b>
                  @php
                  echo $customer->getName();
                  @endphp
                </p>
                <p>
                  <b>Email : </b>
                  @php
                  echo $customer->getEmail();
                  @endphp
                </p>

                <p><a href="/admin/customers/view/@php echo $customer->getID(); @endphp" style="color: #006aff">View Customer</a></p>
                <p><a href="/admin/customers/delete/@php echo $customer->getID(); @endphp" style="color: #ff0000">Delete Customer</a></p>
                <p><a href="/admin/customers/edit/@php echo $customer->getID(); @endphp" style="color: #006aff">Edit  Customer</a></p>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="/js/core/popper.min.js"></script>
  <script src="/js/core/bootstrap.min.js"></script>
  <script src="/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="/js/plugins/chartjs.min.js"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/js/material-dashboard.min.js?v=3.0.4"></script>
</body>

</html>