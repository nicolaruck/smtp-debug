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
            white-space: pre-wrap;
            word-break: break-all;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer img {
            width: 20px;
            height: 20px;
            margin-left: 5px;
        }

        @media (max-width: 600px) {
            form, .message-box, .code-box {
                width: 90%;
            }
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            border: 3px solid; /* Randfarbe dynamisch ändern */
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-header button {
            background-color: transparent;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
        }

        .modal-body {
            margin-top: 10px;
            max-height: 50vh;
            overflow-y: auto;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .modal-footer button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-footer button.close-btn {
            background-color: #dc3545;
            color: white;
            margin-right: 10px;
        }

        .modal-footer button.download-btn {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <form action="smtptest.php" method="post">
        <input type="text" name="host" placeholder="SMTP-Server" required>
        <input type="text" name="port" placeholder="Port" required>
        <select name="security">
            <option value="tls">START TLS (for M365)</option>
            <option value="ssl">SSL</option>
        </select>
        <input type="text" name="username" placeholder="Benutzername">
        <input type="password" name="password" placeholder="Passwort">
        <input type="email" name="sender" placeholder="Absender-E-Mail" required>
        <input type="email" name="recipient" placeholder="Empfänger-E-Mail" required>
        <input type="submit" value="E-Mail senden">
    </form>
    <div class="footer">
        by Nicola Ruckdeschel
        <a href="https://github.com/nicolaruck" target="_blank">
            <span>GitHub</span>
            <img src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" alt="GitHub Logo">
        </a>
    </div>
    <div id="responseMessage" class="message-box" style="display:none;"></div>
    <div id="debugModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>SMTP Debug-Informationen</h2>
                <button onclick="document.getElementById('debugModal').style.display='none'">&times;</button>
            </div>
            <div class="modal-body">
                <pre id="debugContent"></pre>
            </div>
            <div class="modal-footer">
                <button class="close-btn" onclick="document.getElementById('debugModal').style.display='none'">Schliessen</button>
                <button id="downloadLog" class="download-btn">Download Log</button>
            </div>
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
            responseMessage.style.display = 'block';
            responseMessage.textContent = data.message;

            if (data.success) {
                responseMessage.style.backgroundColor = '#d4edda';
                responseMessage.style.color = '#155724';
                responseMessage.style.borderColor = '#c3e6cb';
                document.querySelector('.modal-content').style.borderColor = '#c3e6cb'; // Grüner Rahmen für das Popup
            } else {
                responseMessage.style.backgroundColor = '#f8d7da';
                responseMessage.style.color = '#721c24';
                responseMessage.style.borderColor = '#f5c6cb';
                document.querySelector('.modal-content').style.borderColor = '#f5c6cb'; // Roter Rahmen für das Popup
            }

            if (data.debug) {
                document.getElementById('debugContent').textContent = data.debug;
                document.getElementById('debugModal').style.display = 'flex';
                setupDownloadLog(data.debug);
            }
        })
        .catch(error => {
            console.error('Fehler:', error);
            responseMessage.style.display = 'block';
            responseMessage.textContent = 'Ein Fehler ist aufgetreten. Bitte versuche es später erneut.';
            responseMessage.style.backgroundColor = '#f8d7da';
            responseMessage.style.color = '#721c24';
            responseMessage.style.borderColor = '#f5c6cb';
            document.querySelector('.modal-content').style.borderColor = '#f5c6cb'; // Roter Rahmen für das Popup
        });
    });

    function setupDownloadLog(debugContent) {
        const downloadButton = document.getElementById('downloadLog');
        downloadButton.addEventListener('click', function() {
            const blob = new Blob([debugContent], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'smtp-debug.log';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });
    }
});
</script>
