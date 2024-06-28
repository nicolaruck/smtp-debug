
# SMTP Debug Webserver

Dieses Projekt stellt ein Docker-Image zur Verfügung, das einen SMTP Debug Webserver basierend auf PHP und Apache bereitstellt. Mit diesem Webserver kann der SMTP-Versand getestet werden. Der Versand erfolgt mit Hilfe von PHPMailer.

### Eigenschaften
- PHP und Apache: Basierend auf dem offiziellen PHP Apache Docker Image.
- PHPMailer: Wird für den SMTP-Versand genutzt.
- Docker: Einfacher Einsatz über Docker und Docker Compose.

### Funktionen
- SMTP Versand testen: Geben Sie die SMTP-Serverdaten, Absender- und Empfängerinformationen ein und testen Sie den Versand.
- Debug-Informationen: Bei Versandproblemen können Debug-Informationen angezeigt und heruntergeladen werden.

### Weboberfläche
Nach dem Start des Containers ist die Weboberfläche unter http://localhost erreichbar. Dort können die SMTP-Daten eingegeben und der Versand getestet werden.
![image](https://github.com/nicolaruck/smtp-debug/assets/145778551/75819cbf-b9be-451e-822c-ce2bd9b907dc)
![image](https://github.com/nicolaruck/smtp-debug/assets/145778551/a98652c1-9be0-4c27-a9e1-0830c6f9cd06)

## Demo
https://smtp.my-c.ch


## Installation
Um das Image direkt von DockerHub zu ziehen und zu verwenden, führen Sie den folgenden Befehl aus:
```docker pull nicolaruckdeschel/smtp-debug:latest```

Mit dem bereitgestellten docker-compose.yml können Sie den SMTP Debug Webserver einfach starten. Erstellen Sie eine Datei docker-compose.yml mit folgendem Inhalt:

```bash
version: '1'
services:
  smtp-debug:
    image: nicolaruckdeschel/smtp-debug:latest
    container_name: smtp-debug
    volumes:
      - type: volume
        source: v-smtp-debug
        target: /var/www/html
        # volume:  # Optional: Konfiguration für den Volume, falls notwendig
        #   nocopy: true  # Verhindert, dass Daten vom Container in den neuen Volume kopiert werden
    ports:
        - :80
        - :443
    restart: unless-stopped  # Stellt sicher, dass der Container automatisch neu startet, außer er wird manuell gestoppt
    networks:
      - n-smtp-debug
networks:
  n-smtp-debug:
    external: false  # Verwendet ein externes Netzwerk, das außerhalb dieses Docker Compose-Files definiert ist
volumes:
  v-smtp-debug:
```
    
## Authors

- [@nicolaruck](https://github.com/nicolaruck)

