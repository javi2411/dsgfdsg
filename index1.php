<?  
		echo ("hola");
		
	
    try {
       
        
	
       mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
        
       
       
        //Incluimos los nombres de usuarios y contraseñas.
        include "INCLUDES/credencialesmysql.php";
        //$dbuser=$usuario; 
        //$dbpass=$contrasena; 
        //$dbhost="localhost";
        //$dbuser="u236443240_simplyred_user"; 
        //$dbpass="123456Aa"; 
        //$dbname="u236443240_simplyred_BD";
        
        
        //Creacion de instancia y paso de parametros al constructor para acceder a la base de datos.
        $b1 = new mysqli($dbhost,$dbuser,$dbpass,$dbname) or die ('Error de conexion a mysql: ' . $b1->error.'<br>');
        
        
        
        if ($b1->connect_error) {
            die("Connection failed: " . $b1->connect_error);
        }
        
        echo "Connected successfully";
        
        //Creacion de una Base de Datos
        //$b1->query("CREATE DATABASE IF NOT EXISTS simplyredDB");
        
        //Seleccion de la Base de Datos a usar
        //$b1->select_db("simplyredDB");
        
        
        
        $b1->select_db("u236443240_simplyred_BD");
        
        
        //Creacion de una tabla en la Base de Datos usuarios. 
        $b1->query("CREATE TABLE IF NOT EXISTS usuarios (
            usuarioID MEDIUMINT NOT NULL AUTO_INCREMENT, 
            correo VARCHAR(100) NOT NULL, 
            contrasena VARCHAR(255) NOT NULL,
            validado CHAR(1) NOT NULL DEFAULT 'X',
            nombre VARCHAR(25) NOT NULL DEFAULT 'X',
            localidad VARCHAR(25) NOT NULL DEFAULT 'X', 
            dia INT(2) NOT NULL DEFAULT 0,
            mes VARCHAR(12) NOT NULL DEFAULT 'X', 
            ano INT(4) NOT NULL DEFAULT 0, 
            genero CHAR(1) NOT NULL DEFAULT 'X', 
            busco CHAR(1) NOT NULL DEFAULT 'X', 
            quiere VARCHAR(250) NOT NULL DEFAULT 'X', 
            foto VARCHAR(100) NOT NULL DEFAULT 'X',
            estudiar CHAR(1) NOT NULL DEFAULT 'X', 
            trabajar CHAR(1) NOT NULL DEFAULT 'X',
            viajar CHAR(1) NOT NULL DEFAULT 'X',
            comprar CHAR(1) NOT NULL DEFAULT 'X',
            socializar CHAR(1) NOT NULL DEFAULT 'X',
            lectura CHAR(1) NOT NULL DEFAULT 'X',
            familia CHAR(1) NOT NULL DEFAULT 'X',
            amistad CHAR(1) NOT NULL DEFAULT 'X',
            deporte CHAR(1) NOT NULL DEFAULT 'X',
            musica CHAR(1) NOT NULL DEFAULT 'X',
            cine CHAR(1) NOT NULL DEFAULT 'X',
            mascotas CHAR(1) NOT NULL DEFAULT 'X',
            PRIMARY KEY (usuarioID))");
                    
        
        $b1->query("CREATE TABLE IF NOT EXISTS chats (
            chatID VARCHAR(15), 
            PRIMARY KEY(chatID))");
        

        $b1->query("CREATE TABLE IF NOT EXISTS usuarioschat (
            similarusuarioID MEDIUMINT NOT NULL,
            similarchatID VARCHAR(15), 
            FOREIGN KEY (similarusuarioID) REFERENCES usuarios(usuarioID), 
            FOREIGN KEY (similarchatID) REFERENCES chats(chatID),
            PRIMARY KEY (similarusuarioID, similarchatID))");
                    
                    
        $b1->query("CREATE TABLE IF NOT EXISTS mensajes (
            mensajeID MEDIUMINT NOT NULL AUTO_INCREMENT,
            similarchatID VARCHAR(15) NOT NULL, 
            similarusuarioID MEDIUMINT NOT NULL, 
            fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            mensaje VARCHAR(250) NOT NULL, 
            mensajerecibido CHAR(1) NOT NULL, 
            FOREIGN KEY (similarusuarioID) REFERENCES usuarios(usuarioID), 
            FOREIGN KEY (similarchatID) REFERENCES chats(chatID),
            PRIMARY KEY (mensajeID))");
            
                       
        $b1->query("CREATE TABLE IF NOT EXISTS administrador (
            nombre VARCHAR(25) NOT NULL,
            correoID VARCHAR(100) NOT NULL, 
            contrasena VARCHAR(255) NOT NULL, 
            estado CHAR(1) NOT NULL DEFAULT 'X',
            PRIMARY KEY (correoID))");
        

                    
       
        $result1=$b1->query("SELECT * FROM administrador where correoID='bhayrosa@hotmail.com'");
        
        $b1->store_result();
        
        if($result1->num_rows==0){
            $contrasenaHash = password_hash("A1234567", PASSWORD_DEFAULT);
            include "INCLUDES/insertarAdministrador.php";
            insertarAdministrador("javi", "bhayrosa@hotmail.com", $contrasenaHash, "A");
        }
        
       
        //INSERTAR USUARIO PRUEBA
        //$contrasenaHash = password_hash("A1234567", PASSWORD_DEFAULT);
        //include "INCLUDES/insertarUsuario0.php";
        /*insertarUsuario("bhayrosa@hotmail.com", $contrasenaHash, "javi", "Cuenca", 20, "febrero", 1958, "M", "Salir de viaje, hacer deporte y compartir buenos momentos con amigos y familiares", "ffff");*/
         //insertarUsuario0("bhayrosa@hotmail.com", $contrasenaHash, "X");
        
    
        
        //Cerramos la conexin mysqli con la BD
        $b1->close();
        
        
    
    } catch (mysqli_sql_exception $e) {
       echo ($mensajeError="Error en la conexión con la base de datos.");	
    }

	header("Location: index2.php");

?>
			
