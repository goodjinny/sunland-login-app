# Symfony login application
  
A test applications demonstrates basic form authentication according to the next logic:
- Needs a login to access the pages. 
- token or cookie needs to be saved so user doesn’t have to login at every reload. 
- token or cookie needs to be validated by the backend on every reload. 
- user should be redirected away from pages if the token or cookie has expired.

Implemented using Symfony 4.4 (core functionality) and Vanilla JS (checking that login email belongs to **@sunland.dk** domain). 

## Setup and run the app

1. `git pull git@github.com:goodjinny/sunland-login-app.git`
2. `cd sunland-login-app`
3. `docker-compose up -d`
4. `docker exec -ti sunland_login_app composer install`
5. `docker exec -ti sunland_login_app composer app:database-migrate`
6. `docker exec -ti sunland_login_app composer app:database-load-fixtures`
7.  Goto http://localhost:8081
8. Use next credentials for success user login:
   - email: **admin@sunland.dk**
   - password: **some_secure_password**
 
## Features

### Create admin user from console
To create admin user, run next command:

`docker exec -ti sunland_login_app bin/console app:create-admin-user admin_email@sunland.dk admin_password`