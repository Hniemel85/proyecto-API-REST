<!DOCTYPE html>
<html>
    <head>
        <style>
            @import url(tarea9.css);
        </style>
    </head>
    <body>
        <h1>Encuentra tu Pokemon</h1>
        <div class="formulario">                  
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="get">
            <label for="id">Introduzca el id del pokemon (1 - 898): </label>
            <input id="id" name="id" type="text">
            <input type="submit" value="Buscar">
        </form>
        </div>
        <div class="padre">
        <div class="imagen">
        <?php
        $url = "";
        // Si se ha hecho una peticion que busca informacion de un pojemon a traves de su "id"
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            if ($id > 0 && $id < 899){
                //Se realiza la peticion a la api que nos devuelve el JSON con la información de los pokemon
                $url = "https://pokeapi.co/api/v2/pokemon/" . $id;
                $infoPokemon = file_get_contents($url);
                // Se decodifica el fichero JSON y se convierte a array
                $infoPokemon = json_decode($infoPokemon, true);
                //recuperamos la imagen del pokemon solicitado
                $imagen = $infoPokemon["sprites"]["other"]["official-artwork"]["front_default"];
                
            
            //Mostramos la imagen del pokemon  
            echo '<img src = " '. $imagen . '" id="imagen"/>';
                    
                
        ?>
        </div>
                
           <div class="contenedor">     
                
                <!--Mostramos el resto de información del pokemon-->
                <table id="tabla">
                    <tr>
                        <th><?php echo ucfirst($infoPokemon["name"]);?></th>
                    </tr>
                    <tr>
                        <td><?php echo "Altura: " . $infoPokemon["height"]/10 . " m";?></td>
                    </tr>
                    <tr>
                        <td><?php echo "Peso: " . $infoPokemon["weight"]/10 . " kg";?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                        $tipos = $infoPokemon["types"];
                
                            if(count($tipos)>1) {
                                echo "Tipos: ";
                            } else {
                                echo "Tipo: ";
                            }
                            foreach ($tipos as $tipo){
                                $url = $tipo["type"]["url"];
                                $infoTipo = file_get_contents($url);
                                $infoTipo = json_decode($infoTipo, true);
                                echo $infoTipo["names"]["5"]["name"] . " ";    
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                        $habilidades = $infoPokemon["abilities"];
                
                        if(count($habilidades)>1) {
                            echo "Habilidad: ";
                        } else {
                            echo "Habilidades: ";
                        }
                        foreach ($habilidades as $habilidad){
                            $url = $habilidad["ability"]["url"];
                            $infoHabilidad = file_get_contents($url);
                            $infoHabilidad = json_decode($infoHabilidad, true);
                            echo $infoHabilidad["names"]["5"]["name"] . " ";    
                        }
                            ?>
                        </td>
                    </tr>


                </table>
            </div>
        </div>
                <?php            
            } else {
                echo "No hay ningun pokemon con ese ID";
            }            
        }         
    ?>
        </div>
    </body>
</html>