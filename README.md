# Group_Project_Webtechnologie

To Do:

✅ HTTP Web Server Setup: Students are required to configure a HTTP(S) web server

✅ Dynamic Content with PHP: Implementation of dynamic behavior using PHP to handle server-side processing

✅ Frontend Development: Creation of a basic frontend using HTML, CSS, and JavaScript

✅ Database Integration and Security: Integration of a database with the application, and implementation of security measures to prevent SQL injections 

✅ RESTful Web Service: Design and implementation of a RESTful API to facilitate communication between the web application and its clients

✅ Git/GitHub Integration and Teamwork: Utilization of Git for version control and collaboration through GitHub, demonstrating effective teamwork and regular commits to showcase project progress

❌ External Embedded Device Interaction: External embedded devices must interact with the server through a RESTful interface

❌ Documentation and Presentation: Comprehensive documentation outlining project structure and usage guidelines, along with a clear presentation highlighting key features and technical aspects of the project


What do you need to install: (to see if its installed use: apt list --installed)
-  php8.3-fpm
-  caddy
-  postgresql postgresql-contrib php-pgsql
-  net-tools
-  sudo apt update
-  sudo apt install apache2 php php-pgsql

To start php:
-  sudo systemctl start php8.3-fpm
  
To run caddy:
-  sudo caddy run --config /mnt/c/Users/Bram/Desktop/Webtechnologie/Group_Project_Webtechnologie/caddyfile --adapter caddyfile



How did i make a user for the SQL login?
1) Open Ubuntu:
   
2) Download postgresql:
  - sudo apt update
  - sudo apt install postgresql postgresql-contrib php-pgsql
    
3) Start postgresql:
  - sudo systemctl start postgresql
    
4) Lijst van rollen zien:
  - sudo -u postgres psql
  - du
    
5) Rol creëren:
  - sudo -u postgres psql (of staat al open als er postgres=# staat)
  - CREATE USER "WebTechUser" WITH PASSWORD 'Abracadabra is a magic word! ;)';
    
6) Database creëren:
  - CREATE DATABASE WebTechName;
    
7) Machtigingen geven:
  - GRANT ALL PRIVILEGES ON DATABASE WebTechName TO "WebTechUser";
    
8) User creëren:
  - psql -h localhost -U WebTechUser -d webtechname;  (passwoord is: 'Abracadabra is a magic word! ;)')
    
9) Toestemmingen geven:
  - GRANT CREATE ON SCHEMA public TO "WebTechUser";
  - GRANT USAGE ON SCHEMA public TO "WebTechUser";
  - GRANT ALL PRIVILEGES ON DATABASE webtechname TO "WebTechUser";
  - ALTER SCHEMA public OWNER TO "WebTechUser";
  - GRANT ALL ON SCHEMA public TO "WebTechUser";
  - ALTER DATABASE webtechname OWNER TO "WebTechUser";
    
10) table creëren:
  - typ in achter webtechname=> dat er normaal staat nu.
  - CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
    );
    
11) Username en passwoord instellen:
  - INSERT INTO users (username, password) VALUES ('admin', 'wachtwoord');
    
13) Usernames en passwoorden zien:
  - SELECT * FROM users;


How to do API's:

1) instal node modules
  - sudo apt install npm
  - npm init


2) If it asks for stuff just press enter till your trough

3) RESTfull api to localhost:8000
  - ls
  - cd api
  - php -S localhost:8000
  
3) Test RESTfull api to check if it work

curl -X POST http://localhost:8000/login.php \-H "Content-Type: application/json" \-d '{"username":"admin","password":"wachtwoord"}'

4) That's it!!
