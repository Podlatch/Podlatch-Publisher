# Podlatch Publisher

CMS for Podcasts

![Podlatch Screenshots](https://raw.githubusercontent.com/Podlatch/Podlatch-Publisher/master/docs/podlatch.png)

## Contribute

Contributions are welcome :)

There are a lot of low hanging fruits in the issues list here on github.

## Install from zip

* get [Latest Version](https://podlat.ch/de/home.html?file=files/podlatch/installer/podlatch-latest.zip&cid=293)
* unzip the package and add it to your webspace
* configure `public` directory as document root!
 * go to https://YOUR.DOMAIN/install/index.php and install the software

## Install develop

Checkout this repo

install dependencies and fill out required information when promted
```
composer install
yarn install
```

run build scripts
```
php ./bin/console assets:install
yarn encore dev
```
init database and create user
```
php ./bin/console doctrine:schema:create
php ./bin/console fos:user:create adminuser --super-admin
```
add a virtual host with the `public` directory as document root!


 * go to https://YOUR.DOMAIN/admin/ (trailing slash is important)


## Update

unzip the new files

migrate the database and clear caches
```
./bin/console doctrine:schema:update --force
./bin/console cache:clear --env=prod
```

## Open Source Libraries Used

* [Symfony MIT](https://github.com/symfony/symfony)
* [EasyAdminBundle MIT](https://github.com/EasyCorp/EasyAdminBundle) 
* [VichUploaderBundle](https://github.com/dustin10/VichUploaderBundle)
* [getID3 GPLv3](https://github.com/JamesHeinrich/getID3)
* [Podlove Web Player BSD-2-Clause](https://github.com/podlove/podlove-web-player)
* [Podlove Subscribe Button MIT](https://github.com/podlove/podlove-subscribe-button)
* [Bulma MIT](https://github.com/jgthms/bulma)
* [Bulma Templates MIT](https://github.com/dansup/bulma-templates)
* [Perfect Scrollbar MIT](https://github.com/utatti/perfect-scrollbar)
* [jQuery MIT](https://github.com/jquery/jquery)
