<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>SMTP Tester</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message-box {
            margin: 20px 0;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #d4edda;
            color: #155724;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .code-box {
            width: 100%;
            max-width: 500px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            overflow-x: auto;
            white-space: pre-wrap; /* Wichtig für die Anzeige des umgebrochenen Textes */
            word-break: break-all;
        }

        /* Optional: Weitere Styles für die Verbesserung der Mobilgeräte-Ansicht */
        @media (max-width: 600px) {
            form, .message-box, .code-box {
                width: 90%;
            }
        }

    </style>
</head>
<body>
    <form action="smtptest.php" method="post">
        <input type="text" name="host" placeholder="SMTP-Server" required>
        <input type="text" name="port" placeholder="Port" required>
        <select name="security">
            <option value="PHPMailer::ENCRYPTION_STARTTLS">START TLS (for M365)</option>
            <option value="PHPMailer::ENCRYPTION_SMTPS">SSL</option>
        </select>
        <input type="text" name="username" placeholder="Benutzername">
        <input type="password" name="password" placeholder="Passwort">
        <input type="email" name="sender" placeholder="Absender-E-Mail" required>
        <input type="email" name="recipient" placeholder="Empfänger-E-Mail" required>
        <input type="submit" value="E-Mail senden">
    </form>
    by Nicola Ruckdeschel
    <div id="responseMessage" class="message-box" style="display:none;"></div>
    <!-- Modal für Debug-Informationen -->
<div id="debugModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background-color:white; margin:10% auto; padding:20px; width:80%; height:50%; overflow:auto;">
        <h2>SMTP Debug-Informationen</h2>
        <pre id="debugContent"></pre>
        <button onclick="document.getElementById('debugModal').style.display='none'">Schliessen</button>
    </div>
</div>
</body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const responseMessage = document.getElementById('responseMessage');

        fetch('smtptest.php', { 
            method: 'POST',
            body: formData,
        })
        .then(response => response.json()) 
        .then(data => {
            // Meldungsbereich anzeigen und Nachricht setzen
            responseMessage.style.display = 'block';
            responseMessage.textContent = data.message;

            if (data.success) {
                // Grün für Erfolg
                responseMessage.style.backgroundColor = '#d4edda';
                responseMessage.style.color = '#155724';
                responseMessage.style.borderColor = '#c3e6cb';
            } else {
                // Rot für Fehler
                responseMessage.style.backgroundColor = '#f8d7da';
                responseMessage.style.color = '#721c24';
                responseMessage.style.borderColor = '#f5c6cb';
            }

            // Debug-Informationen im Modal anzeigen
            if (data.debug) {
                document.getElementById('debugContent').textContent = data.debug;
                document.getElementById('debugModal').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Fehler:', error);
            // Fehlermeldung anzeigen
            responseMessage.style.display = 'block';
            responseMessage.textContent = 'Ein Fehler ist aufgetreten. Bitte versuche es später erneut.';
            responseMessage.style.backgroundColor = '#f8d7da';
            responseMessage.style.color = '#721c24';
            responseMessage.style.borderColor = '#f5c6cb';
        });
    });
});

</script>


