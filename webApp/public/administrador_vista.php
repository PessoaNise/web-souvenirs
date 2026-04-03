<?php 

 

session_start(); 

if (isset($_SESSION['usuario'])) { 

 

    $PageTitle = "Administrador"; 

 

    include '../resources/templates/head.html'; 

    include '../resources/templates/header.html'; 

    include '../resources/templates/administrador_navegacion.html'; 

    ?> 

 

    <main> 

       <div class="container"> 

           <div class="text-center my-5"> 

               <img src="../public/assets/img/admin.png"> 

           </div> 

 

           <div class="px-4 text-secondary"> 

               <h5 class="display-6 mb-5">Recuerda seguir las siguientes políticas</h5> 

 

               <ul class="fs-5"> 

                   <li> 

                       Facilitar posibles soluciones a las necesidades de la comunidad que se encuentre en el entorno de la 

                       empresa como resultado final de la misma. 

                   </li> 

                   <li> 

                       Brindar a sus clientes los productos o servicios que siempre desean. 

                   </li> 

                   <li> 

                       Proporcionar a los empleados de la organización un ambiente agradable, reconfortante, seguro y 

                       divertido como parte del estímulo que les permite llevar a cabo una buena ejecución de sus labores 

                       diarias. 

                   </li> 

                   <li> 

                       Facilitar y promocionar cursos de capacitación que formen parte de un proceso obligatorio a los 

                       nuevos ingresos de la empresa. 

                   </li> 

                   <li> 

                       Rechazar la corrupción tanto en los cargos altos como medios de la organización. 

                   </li> 

                   <li> 

                       Fomentar un espíritu laboral agradable tanto en líderes como empleados para el buen funcionamiento 

                       de la empresa. 

                   </li> 

                   <li> 

                       Formar nuevos trabajadores de forma directa e indirecta para el desarrollo óptimo empresarial. 

                   </li> 

               </ul> 

           </div> 

       </div> 

    </main> 

 

    <?php 

    include '../resources/templates/footer.html'; 

    include '../resources/templates/scripts.html'; 

    include '../resources/templates/fin.html'; 

 

} else { 

    header("Location:login_error.php"); 

    exit(); 

} 

 