<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
    $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
    $conexion = new PDO('mysql:host=localhost;dbname=Final_18_18829', 'root', '', $pdo_options);


        
    //para guardar datos en la base de datos
    //validacion
    if(isset($_POST["accion"])){
        // echo "Quieres " . $_POST["accion"];
        //formulario para gurdar y crear datos
         if ($_POST["accion"] == "Crear") {
             $insert = $conexion->prepare("INSERT INTO alumno (carnet, nombre, grado, telefono) VALUES (:carnet, :nombre, :grado, :telefono)");
             $insert->bindValue('carnet', $_POST['carnet']);
             $insert->bindValue('nombre', $_POST['nombre']);
             $insert->bindValue('grado', $_POST['grado']);
             $insert->bindValue('telefono', $_POST['telefono']);
             $insert->execute();
         }
         // segundo formulario para editar los datos excepto el carnet
         if ($_POST["accion"] == "Editado") {
             $update = $conexion->prepare("UPDATE alumno SET nombre=:nombre, grado=:grado, telefono=:telefono WHERE carnet=:carnet ");
             $update->bindValue('carnet', $_POST['carnet']);
             $update->bindValue('nombre', $_POST['nombre']);
             $update->bindValue('grado', $_POST['grado']);
             $update->bindValue('telefono', $_POST['telefono']);
             $update->execute();
             header("Refresh: 0");
         }
     }
 
     //ejecutamos la consulta
     //en query entre el parentesis escribimos nuestra consulta
     $select = $conexion->query("SELECT carnet, nombre, grado, telefono FROM alumno");
 
     ?>
     
 
     <?php
     //linea de codigo para que se presente uno de los dos formularios creados
     if (isset($_POST["accion"]) && $_POST["accion"] == "Editar" ) { ?>
     <form method="POST">
         <input type="text" name="carnet" value="<?php echo $_POST["carnet"] ?>" placeholder="Ingresa el carnet"/>
         <input type="text" name="nombre" placeholder="Ingresa el nombre"/>
         <input type="text" name="grado" placeholder="Ingresa el grado"/>
         <input type="text" name="telefono" placeholder="Ingresa el telefono"/>
         <input type="hidden" name="accion" value="Editado"/>
         <button type="submit"> Guardar </button>
     </form>
 <?php } else { ?>
     <form method="POST">
         <input type="text" name="carnet" placeholder="Ingresa el carnet"/>
         <input type="text" name="nombre" placeholder="Ingresa el nombre"/>
         <input type="text" name="dpi" placeholder="Ingresa el grado"/>
         <input type="text" name="telefono" placeholder="Ingresa el telefono"/>
         <input type="hidden" name="accion" value="Crear"/>
         <button type="submit"> Crear </button>
     </form>
     <?php } ?>
 
 
     <table border="1">
         <thead>
             <tr>
                 <th>Carnet</th>
                 <th>Nombre</th>
                 <th>grado</th>
                 <th>telefono</th>
                 
             </tr>
         </thead>
         <tbody>
             <?php foreach($select->fetchAll() as $alumno) { ?>
                 <tr>
                     <td> <?php echo $alumno["carnet"] ?></td>
                     <td> <?php echo $alumno["nombre"] ?></td>
                     <td> <?php echo $alumno["grado"] ?></td>
                     <td> <?php echo $alumno["telefono"] ?></td>
                     <td>
                         <form method="POST">
                             <button type="submit">Editar</button>
                             <input type="hidden" name="accion" value="Editar"/>
                             <input type="hidden" name="carnet" value="<?php echo $alumno["carnet"] ?>"/>
                         </form>
                     </td>
                 </tr>
                 <?php } ?>
         </tbody>
     </table>
</body>
</html>