#SMTP Debug Webserver

Überblick

Dieses Projekt stellt ein Docker-Image zur Verfügung, das einen SMTP Debug Webserver basierend auf PHP und Apache bereitstellt. Mit diesem Webserver kann der SMTP-Versand getestet werden. Der Versand erfolgt mit Hilfe von PHPMailer.

Eigenschaften

- PHP und Apache: Basierend auf dem offiziellen PHP Apache Docker Image.
- PHPMailer: Wird für den SMTP-Versand genutzt.
- Docker: Einfacher Einsatz über Docker und Docker Compose.

Verwendung

Docker

Um das Image direkt von DockerHub zu ziehen und zu verwenden, führen Sie den folgenden Befehl aus:

docker pull nicolaruckdeschel/smtp-debug:latest

Docker Compose

Mit dem bereitgestellten docker-compose.yml können Sie den SMTP Debug Webserver einfach starten. Erstellen Sie eine Datei docker-compose.yml mit folgendem Inhalt:

version: '3'
services:
  smtp-debug:
    image: nicolaruckdeschel/smtp-debug:latest
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./data:/var/www/html

Starten Sie den Container mit:

docker-compose up -d

Funktionen

- SMTP Versand testen: Geben Sie die SMTP-Serverdaten, Absender- und Empfängerinformationen ein und testen Sie den Versand.
- Debug-Informationen: Bei Versandproblemen können Debug-Informationen angezeigt und heruntergeladen werden.

Weboberfläche

Nach dem Start des Containers ist die Weboberfläche unter http://localhost erreichbar. Dort können die SMTP-Daten eingegeben und der Versand getestet werden.

Kontakt

Bei Fragen oder Problemen wenden Sie sich bitte an Nicola Ruckdeschel (https://github.com/nicolaruck).

Lizenz

Dieses Projekt ist unter der MIT-Lizenz lizenziert - siehe die LICENSE Datei für Details.

