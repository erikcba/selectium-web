<?php
header("Access-Control-Allow-Origin: *"); // Permite todas las solicitudes (menos seguro) o especifica el origen (más seguro)
header("Access-Control-Allow-Methods: POST"); // Permite solo solicitudes POST
header("Access-Control-Allow-Headers: Content-Type");
// Verifica si los datos fueron enviados correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ajustar los nombres de los campos según el formulario de index.html
    $nombre = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $texto = htmlspecialchars($_POST['message']);

    // Los campos empresa y telefono no existen en el formulario, así que los dejamos vacíos
    $empresa = '';
    $telefono = '';

    // Validar solo los campos que existen en el formulario
    if (!empty($nombre) && !empty($email) && !empty($texto)) {
        // Configura los detalles del correo
        $to = "info@selectium.net";
        $subject = "Nuevo mensaje desde el formulario de contacto";
        
        $message = "
        <html>
        <head>
        <title>Nuevo mensaje</title>
        </head>
        <body>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Mensaje:</strong> $texto</p>
        </body>
        </html>
        ";
        
        // Encabezados del correo
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . 'info@selectium.net' . "\r\n";
        
        // Envía el correo
        if (mail($to, $subject, $message, $headers)) {
            // Responder en formato JSON
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "No se pudo enviar el correo."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Por favor, completa todos los campos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método de solicitud no permitido."]);
}
?>