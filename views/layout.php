<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <!-- cambie el icono del navegador -->
    <link rel="shortcut icon" href="<?= asset('images/ico_mujer.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">


    <!-- fuentes de google -->
     <!-- Añadir en el head del layout.php -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>
      Compras de Maria
    </title>

    <style>
    /* Estilos para la página de bienvenida */
    body {
        background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);
        font-family: 'Poppins', sans-serif;
        color: #4a4a4a;
        min-height: 100vh;
    }

    /* Título principal */
    h1, .title {
        color: #c2185b;
        font-size: 3.2rem;
        font-weight: 600;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 0.5rem;
    }

    /* Subtítulo */
    .subtitle {
        color: #7b1fa2;
        font-size: 1.2rem;
        margin-bottom: 1.8rem;
    }

    /* Mensaje de bienvenida */
    .welcome-message {
        background-color: #fff;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 5px solid #ec407a;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    /* Contenedor de características */
    .features-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin: 2rem 0;
    }

    /* Tarjetas de características */
    .feature-card {
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 15px;
        padding: 1.5rem;
        flex: 1 1 250px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Iconos de características */
    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .icon-organization {
        background-color: #e3f2fd;
    }
    .icon-organization i {
        color: #42a5f5;
    }

    .icon-priorities {
        background-color: #fff8e1;
    }
    .icon-priorities i {
        color: #ffca28;
    }

    .icon-reminders {
        background-color: #e8f5e9;
    }
    .icon-reminders i {
        color: #66bb6a;
    }

    .icon-time {
        background-color: #fce4ec;
    }
    .icon-time i {
        color: #ec407a;
    }

    .feature-icon i {
        font-size: 1.5rem;
    }

    /* Títulos de características */
    .feature-title {
        color: #424242;
        font-weight: 600;
        margin-bottom: 0.8rem;
    }

    /* Botón principal */
    .btn-primary, .btn-comenzar {
        background: linear-gradient(to right, #ec407a, #c2185b);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 500;
        color: white;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 5px 15px rgba(236, 64, 122, 0.3);
        transition: all 0.3s ease;
    }

    .btn-primary:hover, .btn-comenzar:hover {
        background: linear-gradient(to right, #d81b60, #ad1457);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(236, 64, 122, 0.4);
        color: white;
    }

    /* Imagen */
    .img-shopping {
        max-width: 100%;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
        transition: all 0.5s ease;
        margin: 1.5rem 0;
    }

    .img-shopping:hover {
        transform: scale(1.05);
    }

    /* Footer */
    .welcome-footer {
        margin-top: 3rem;
        font-size: 0.9rem;
        color: #7b1fa2;
        text-align: center;
        padding: 1rem;
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 10px;
    }

    /* Para mantener la barra de navegación oscura */
    .navbar-dark {
        background-color: #1a1a2e !important;
    }

    /* Para asegurar que el contenido principal tenga espacio */
    .main-content {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    /* Estilos para la clase container */
    .container {
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 20px;
        padding: 2rem;
        margin-top: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
    }

    /* Estilos para ajustar mejor las características existentes */
    [class*="bi-"] {
        color: #ec407a;
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }

    /* Estilo para títulos de secciones */
    h2, h3, h4, h5 {
        color: #ad1457;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    /* Estilo para links */
    a {
        color: #c2185b;
        transition: color 0.3s ease;
    }

    a:hover {
        color: #ec407a;
        text-decoration: none;
    }

    /* Ajustes responsivos */
    @media (max-width: 768px) {
        h1, .title {
            font-size: 2.5rem;
        }
        
        .container {
            padding: 1.5rem;
        }
    }
</style>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand fw-bold text-rose" href="/app01_mrml">
          <img src="<?= asset('./images/ico_mujer.png') ?>" width="35px" alt="cit">
          Mujeres
        </a>

        <div class="collapse navbar-collapse" id="navbarToggler">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
            <li class="nav-item">
              <a class="nav-link text-white" aria-current="page" href="/app01_mrml">
                <i class="bi bi-house-heart-fill me-2"></i>Inicio
              </a>
            </li>

            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="/productosMaria" data-bs-toggle="dropdown">
                <i class="bi bi-bag-heart-fill"></i>Productos
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" id="dropwdownRevision" style="margin: 0;">
                <li>
                  <a class="dropdown-item nav-link text-white" href="/app01_mrml/productosMaria">
                    <i class="bi bi-plus-circle-dotted"></i>Registrar 
                  </a>
                </li>
              </ul>
            </div>

            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-stars me-2"></i>Categorias
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" id="dropwdownRevision" style="margin: 0;">
                <li>
                  <!-- Aqui rutiamos con el que esta en el contreoller -->
                  <a class="dropdown-item nav-link text-white" href=/app01_mrml/CategoriaMaria>
                    <i class="bi bi-flower1 me-2"></i>Subitem
                  </a>
                </li>
              </ul>
            </div>

            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-stars me-2"></i>Opciones
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" id="dropwdownRevision" style="margin: 0;">
                <li>
                  <a class="dropdown-item nav-link text-white" href="/aplicaciones/nueva">
                    <i class="bi bi-flower1 me-2"></i>Subitem
                  </a>
                </li>
              </ul>
            </div>


          </ul>

          <div class="col-lg-1 d-grid mb-lg-0 mb-2">
            <a href="/menu/" class="btn btn-rose">
              <i class="bi bi-arrow-left-heart-fill"></i> MENÚ
            </a>
          </div>
        </div>
      </div>
    </nav>

    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">
        
    <!-- Aqui esta todo el contenido -->
        <?php echo $contenido; ?>
    <!--  -------------------------------------- -->

    <!-- footer de todo -->
    </div>
    <div class="container-fluid " >
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                        Las mujeres somos fuerte e idependientes, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
</body>
</html>