# Podlatch Publisher

CMS for Podcasts

![Podlatch Screenshots](https://raw.githubusercontent.com/Podlatch/Podlatch-Publisher/master/docs/podlatch.png)

##

## Install from zip

* get [Latest Version](https://github.com/Podlatch/Podlatch-Publisher/releases/download/0.6.0/podlatch-0-6-0.zip)
* unzip the package and add it to your webspace
```
  unzip Podlatch-Publisher_beta.zip 
  cd Podlatch-Publisher_beta
  cp ./app/config/parameters.yml.dist ./app/config/parameters.yml
```
* add a virtual host with the `web` directory as document root!


* you need an ssh connection to your webserver
* go to the installation root

* fill the config file
```
  vi ./app/config/parameters.yml
```
* init the database and create your first user
```
php ./bin/console doctrine:schema:create
php ./bin/console fos:user:create adminuser --super-admin
 ```
 
 * go to https://YOUR.DOMAIN/admin/ (trailing slash is important)

## Install develop

Checkout this repo

install dependencies and fill out required information when promted
```
composer install
npm install
```

run build scripts
```
gulp sass
gulp icons
gulp backendsass
gulp backendjs
gulp js
gulp podlove
```
init database and create user
```
php ./bin/console doctrine:schema:create
php ./bin/console fos:user:create adminuser --super-admin
```
add a virtual host with the `web` directory as document root!


 * go to https://YOUR.DOMAIN/admin/ (trailing slash is important)


## Update

unzip the new files

migrate the database and clear caches
```
./bin/console doctrine:schema:update --force
./bin/console cache:clear --env=prod
```