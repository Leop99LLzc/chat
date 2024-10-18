<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat en Tiempo Real</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #F4F4F9; /* Fondo gris suave */
            margin: 0;
            padding: 0;
        }

        .chat-container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            background-color: #FFFFFF; /* Fondo blanco */
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1); /* Sombra más suave */
            padding: 20px;
        }

        .message {
            margin: 10px 0;
            padding: 12px 18px;
            border-radius: 12px;
            max-width: 70%;
            display: inline-block;
            font-size: 16px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .message.sent {
            background-color: #4CAF50; /* Verde suave */
            color: white;
            align-self: flex-end;
            text-align: right;
        }

        .message.received {
            background-color: #E8E8E8; /* Gris claro */
            color: #333;
        }

        #chat {
            height: 400px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding-right: 10px;
            scroll-behavior: smooth; /* Animación suave al hacer scroll */
        }

        #message {
            width: calc(100% - 150px); /* Ajuste del ancho para los botones adicionales */
            padding: 12px;
            border: 1px solid #CCCCCC; /* Borde gris claro */
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        #send {
            padding: 12px 20px;
            background-color: #4CAF50; /* Verde suave */
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        #send:hover {
            background-color: #43A047; /* Verde más oscuro en hover */
        }

        .input-container {
            display: flex;
            margin-top: 15px;
            align-items: center;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .icon {
            font-size: 24px;
            margin: 0 10px;
            cursor: pointer;
        }

        /* Ajustes para dispositivos móviles */
        @media screen and (max-width: 600px) {
            .chat-container {
                padding: 15px;
            }
            #message {
                width: calc(100% - 120px); /* Ajuste para móviles */
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h1>Chat en Tiempo Real</h1>
        <div id="chat"></div>
        <div class="input-container">
            <input type="text" id="message" placeholder="Escribe tu mensaje">
            <span class="icon" id="emoji-picker">😊</span> <!-- Emoji Picker -->
            <span class="icon" id="file-picker">📎</span> <!-- Archivos -->
            <span class="icon" id="photo-picker">📷</span> <!-- Fotografía -->
            <button id="send">Enviar</button>
        </div>
    </div>

    <script>
        var conn = new WebSocket('ws://localhost:8080');
        var chat = document.getElementById('chat');
        var sendButton = document.getElementById('send');
        var messageInput = document.getElementById('message');

        conn.onopen = function(e) {
            chat.innerHTML += '<div class="message received">Conexión establecida</div>';
        };

        conn.onmessage = function(e) {
            chat.innerHTML += '<div class="message received">' + e.data + '</div>';
            chat.scrollTop = chat.scrollHeight; // Mantener el scroll al final
        };

        sendButton.onclick = function() {
            var msg = messageInput.value;
            if (msg.trim() !== '') { // Validar que el mensaje no esté vacío
                chat.innerHTML += '<div class="message sent">' + msg + '</div>';
                conn.send(msg);
                messageInput.value = '';
                chat.scrollTop = chat.scrollHeight; // Mantener el scroll al final
            }
        };

        // Funcionalidad de emoji picker (simulada)
        document.getElementById('emoji-picker').onclick = function() {
            messageInput.value += '😊'; // Simulación de agregar un emoji
        };

        // Funcionalidad de selección de archivos (simulada)
        document.getElementById('file-picker').onclick = function() {
            alert('Función de adjuntar archivos activada');
        };

        // Funcionalidad de selección de fotos (simulada)
        document.getElementById('photo-picker').onclick = function() {
            alert('Función de adjuntar fotos activada');
        };
    </script>
</body>
</html>
