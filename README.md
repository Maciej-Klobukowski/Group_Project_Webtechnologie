# 🌐 Webtechnologie Groepsproject

Welkom bij het Webtechnologie Groepsproject! Dit project omvat de ontwikkeling van een webapplicatie met diverse moderne webtechnologieën.

---

## 🚀 Projectstatus

Hier is een overzicht van de voltooide en nog openstaande taken:

### ✅ Voltooid

* **HTTP(S) Web Server Setup**: Configuratie van een robuuste HTTP(S) webserver.
* **Dynamische Content met PHP**: Implementatie van dynamische functionaliteiten en server-side processen met PHP.
* **Frontend Ontwikkeling**: Realisatie van een intuïtieve frontend met **HTML**, **CSS**, en **JavaScript**.
* **Database Integratie & Beveiliging**: Integratie van een database inclusief beveiligingsmaatregelen om **SQL injecties** te voorkomen.
* **RESTful Web Service**: Ontwerp en implementatie van een **RESTful API** voor naadloze communicatie tussen de webapplicatie en clients.
* **Git/GitHub Integratie & Teamwork**: Effectieve samenwerking via **Git** en **GitHub**, met regelmatige commits die de projectvoortgang weerspiegelen.
* **Documentatie & Presentatie**: Uitgebreide projectdocumentatie en een heldere presentatie van de belangrijkste kenmerken en technische aspecten.
  
### ❌ Half Gelukt

* **Interactie met Externe Embedded Apparaten**: Implementatie van interactie tussen externe embedded apparaten en de server via een RESTful interface.

---

## 🛠️ Benodigde Installaties

Om dit project te draaien, heb je de volgende pakketten nodig. Je kunt controleren of ze al geïnstalleerd zijn met `apt list --installed`.

* `php8.3-fpm`
* `caddy`
* `postgresql postgresql-contrib php-pgsql`
* `net-tools`
* `apache2` (installeer via `sudo apt install apache2 php php-pgsql`)

### Pakketten installeren

Voer de volgende commando's uit om de benodigde pakketten te updaten en te installeren:

```
sudo apt update
sudo apt install apache2 php php-pgsql php8.3-fpm caddy postgresql postgresql-contrib php-pgsql net-tools
```
▶️ Starten van de Services
PHP starten
```
sudo systemctl start php8.3-fpm
Caddy starten
```
```
sudo caddy run --config /mnt/c/Users/Bram/Desktop/Webtechnologie/Group_Project_Webtechnologie/caddyfile --adapter caddyfile
```
🔒 PostgreSQL Gebruiker en Database Setup
Volg deze stappen om een gebruiker en database voor PostgreSQL aan te maken en te configureren:

Open Ubuntu Terminal.

Installeer PostgreSQL:

```
sudo apt update
sudo apt install postgresql postgresql-contrib php-pgsql
Start PostgreSQL service:
```

```
sudo systemctl start postgresql
```
Bekijk bestaande rollen:
```
sudo -u postgres psql
du
(Typ \q en druk op Enter om psql te verlaten, of blijf in de psql shell als je postgres=# ziet.)
```
Creëer een nieuwe gebruiker:

```
CREATE USER "WebTechUser" WITH PASSWORD 'Abracadabra is a magic word! ;)';
Creëer de database:
```
```
CREATE DATABASE WebTechName;
Geef alle rechten aan de gebruiker voor de database:
```
```
GRANT ALL PRIVILEGES ON DATABASE WebTechName TO "WebTechUser";
Maak verbinding met de nieuwe database als de nieuwe gebruiker:
```
```
psql -h localhost -U WebTechUser -d webtechname
Voer het wachtwoord in wanneer daarom wordt gevraagd: Abracadabra is a magic word! ;).
```
Geef verdere permissies aan de gebruiker in de database:
```
GRANT CREATE ON SCHEMA public TO "WebTechUser";
GRANT USAGE ON SCHEMA public TO "WebTechUser";
GRANT ALL PRIVILEGES ON DATABASE webtechname TO "WebTechUser";
ALTER SCHEMA public OWNER TO "WebTechUser";
GRANT ALL ON SCHEMA public TO "WebTechUser";
ALTER DATABASE webtechname OWNER TO "WebTechUser";
```
Creëer de users tabel:
```
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
);
```
Voeg een initiële admin gebruiker toe:
```
INSERT INTO users (username, password) VALUES ('admin', 'wachtwoord');
Controleer de gebruikers in de tabel:
```
```
SELECT * FROM users;
(Typ \q en druk op Enter om psql te verlaten.)
```
⚡ API Setup en Testen
Node Modules installeren (voor API ontwikkeling)
Installeer npm:
```
sudo apt install npm
```
Initialiseer een nieuw Node.js project (volg de instructies en druk op Enter voor standaardwaarden):
```
npm init
```
RESTful API starten
Navigeer naar de API directory:
```
ls
cd api
```

Start de PHP development server:
```
php -S localhost:8000
```
API testen
Gebruik curl om te controleren of je RESTful API correct werkt:
```
curl -X POST http://localhost:8000/login.php \
-H "Content-Type: application/json" \
-d '{"username":"admin","password":"wachtwoord"}'
```
