# Podlatch Publisher

CMS for Podcasts

![Podlatch Screenshots](https://raw.githubusercontent.com/Podlatch/Podlatch-Publisher/master/docs/podlatch.png)


##Install develop

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





##Install from zip

unzip the package and add it to your webspace
```
  unzip Podlatch-Publisher_beta.zip 
  cd Podlatch-Publisher_beta
  cp ./app/config/parameters.yml.dist ./app/config/parameters.yml
```
add a virtual host with the `web` directory as document root!


* you need an ssh connection to your webserver
* go to the installation root

fill the config file
```
  vi ./app/config/parameters.yml
```
init the database and create your first user
```
php ./bin/console doctrine:schema:create
php ./bin/console fos:user:create adminuser --super-admin
 ```

go to https://YOUR.DOMAIN/admin/


