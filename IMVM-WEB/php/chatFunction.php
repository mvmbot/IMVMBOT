<?php

#region Aqui se importan los archivos que puedas llegar a necesitar,
# Son los basicos, no se si vas a necesitar algo mas
# Ahora solo tienes k llamar a los metodos que t hagan falta
require_once ("redirectFunctions.php");
require_once ("databaseFunctions.php");
require_once ("config.php");
#endregion

#region Conexion a la base de datos
# Esta variable es la encargada de conectar a la base d datos
# Si ves que el del tutorial hace algo tipo $connection->mysqli y tal, ignoralo
# Ya tenemos un metodo que hace eso, simplemente se llama asi, vamos a guardar los mensajes
# Asi que si tu guia de hacer un chat no tiene base de datos, es que no los guarda,
# Pero nosotros si, te va a hacer falta, no te lo comento pq es solo esto, no lo editas
$conn = connectToDatabase();
#endregion

#region Verificacion de inputs
# Aqui es donde vas a meter los datos del usuario y tal para validarlos y sanitizarlos
# No olvides poner las datos aqui pq es importante validarlo todo por temas d seguridad
# Que luego el Albert t mete un script y nos quedamos sin proyecto
# Estas declarando una array asociativa, al final de cada variable pones una ',' y no un ';'
# Tenlo en cuenta

/***********
$inputs = validateInputs([
    # $var1,
    # $var2 y las que sean
]) ?: redirectToTicket(); # Esto es un operador ternario para que si algo esta mal que t expulse, no creo que entre nada pq es un chat pero igual viene bn
***********/
#endregion

#region Insertar o tocar base de datos en general
# Si necesitas hacer un insert/update/lo que sea a la base d datos, t hago una mini guia
# Primero, todo lo que sea acceder a la base de datos, lo haces en un fichero a parte
# Preferiblemente en el 'IMVM-WEB\php\databaseFunctions.php'
# Recuerda siempre enviar la variable $conn a cualquier funcion que conecte con la base de datos
# Asi no la re-declaramos cuando no es necesario

# funcionDeOtroFichero($conn, $inputs);

# Y ademas, se hace dentro de un try-catch, asi si salta un error, veras el pq y no petara todo

/*******************************
    try {

        # Creas una variable que va a contener la query
        # IMPORTANTE, que a la hora  de meter variables
        # directamente ahi hay que usar "?"
        # Es por motivos de seguridad

        $insert/updateSQL = "INSERT INTO helpSupport (subject, description, file, ticketID) VALUES (?, ?, ?, ?)";

        # Luego has de crear una variable que haga de statement
        # Dicha variable va a preparar la query
        # En caso de que falle esto, entrara al operador ternario
        # Y te lanzara una excepcion con el error para debuggar
        # Si no sabes pq falla algo m preguntas

        $stmt = $conn->prepare($insert/updateSQL)?:throw new Exception("Error preparing INSERT or UPDATE (o lo que sea) statement: " . $conn->error);

        # Ahora simplemente has de bindear los parametros a la query
        # Que son los '?' que viste antes
        # La cantidad de s/i ha de ser equivalente a la de '?' obviamente
        # Cada '?' corresponde a una variable de la query
        # La S es de String y la I es de Integer, bastante intuitivo
        # La array asociativa de antes devuelve la array limpia en formato numerico
        # Sus valores siguen el orden anterior, es decir, $inputs[0] es $var1, etc...

        $stmt->bind_param("sssi", $inputs[0], $inputs[1], $fileAttachment, $ticketId);

        # Y ya finalmente lo ejecutas y ya

        $stmt->execute();

        # Acuerdate de cerrar el statement (la variable $stmt) tras ejecutar la query
        $stmt->close();

        # En el catch declaras la excepcion como $e de error o como tu quieras tbh
    } catch (Exception $e) {

        # Llamas al metodo de showError y le pones el mensajito que tu quieras que se vea
        # Luego del mensaje recuerda poner el '.', es para concatenar, y llamas a la variable y recoges el mensaje
        showError("Mensaje de error cualquiera: " . $e->getMessage());
    }
*******************************/
#endregion



# Dato extra, si el fichero es puro php
# (Ha de serlo, como todos los demas que estan en esta carpeta)
# No has de poner el '? >' al final para cerrarlo