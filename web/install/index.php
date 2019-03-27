<?php
/**
 * Copyright (c) Benjamin Issleib 2019.
 * This file is part of the Podlatch Podcast Publisher.
 * Podlatch Podcast Publisher is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * Podlatch Podcast Publisher is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with the Podlatch Podcast Publisher. If not, see http://www.gnu.org/licenses/.
 */

require __DIR__.'/../../vendor/autoload.php';
error_reporting(0);
$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
$setup = new Setup($request);
$emitter = new Zend\HttpHandlerRunner\Emitter\SapiEmitter();

if(isset($request -> getQueryParams()['action']) && $request -> getQueryParams()['action'] === 'finish'){
    $response = new \Zend\Diactoros\Response\RedirectResponse('/admin/');
    $emitter -> emit($response);
    exit();
}

if(!$setup ->isFirstRun()){
    $response = new \Zend\Diactoros\Response\HtmlResponse(
        '<h1>403 - Already installed</h1><a href="/admin/">Login</a>',
        403
    );
    $emitter -> emit($response);
    exit();
}
$response = $response = new \Zend\Diactoros\Response\HtmlResponse(file_get_contents(__DIR__ . '/../../app/Resources/install/index.htm'),200);


if(isset($request -> getQueryParams()['action']) && $request -> getQueryParams()['action'] === 'check-database'){
    if($setup ->checkDatabaseConnection()){
        $response = new \Zend\Diactoros\Response\JsonResponse([],200);
    } else {
        $response = new \Zend\Diactoros\Response\JsonResponse(
            [
                'messages'=> $setup->getErrorMessages()
            ],
            406);
    }
    $emitter -> emit($response);
}

if(isset($request -> getQueryParams()['action']) && $request -> getQueryParams()['action'] === 'create-schema'){
    try{
        $setup -> writeSymfonyParameters();
        $setup ->createDatabaseSchema();
        $setup ->createAdminUser();
        $response = new \Zend\Diactoros\Response\JsonResponse([],200);

    } catch (Exception $e){
        $response = new \Zend\Diactoros\Response\JsonResponse([],500);
    }
}

$emitter -> emit($response);

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class Setup {

    private $dbHost;
    private $dbPort;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $podlatchEmail;
    private $podlatchUser;
    private $podlatchPassword;

    private $errorMessages = [];

    /**
     * @var \PDO
     *
     */
    private $pdo = null;

    public function __construct(\Zend\Diactoros\ServerRequest $request)
    {
        $this->dbHost = $request->getParsedBody()['dbhost']?:'127.0.0.1';
        $this->dbPort = $request->getParsedBody()['dbport']?:3306;
        $this->dbName = $request->getParsedBody()['dbname']?:null;
        $this->dbUser = $request->getParsedBody()['dbuser']?:null;
        $this->dbPassword = $request->getParsedBody()['dbpassword']?:null;
        $this->podlatchUser = $request->getParsedBody()['podlatchUser']?:null;
        $this->podlatchPassword = $request->getParsedBody()['podlatchPassword']?:null;
        $this->podlatchEmail = $request->getParsedBody()['podlatchEmail']?:null;

    }

    public function getPdo()
    {
        if($this->pdo === null){
            $this->pdo = new \PDO(
                'mysql:host='.$this->dbHost.';dbname='.$this->dbName,
                $this->dbUser,
                $this->dbPassword,
                array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
            );
        }
        return $this->pdo;
    }

    public function renderSetupForm(){}

    public function checkDatabaseConnection(){
        try{
            $this -> getPdo();
        } catch (Exception $e){
            $this->errorMessages[] = $e->getMessage();
            return false;
        }
        return true;
    }

    public function createDatabaseSchema(){
        $sql = file_get_contents(__DIR__ . '/../../app/Resources/install/install.sql');
        try{
            $this->getPdo()->exec($sql);
        } catch (Exception $e){
            return false;
        }
        return true;
    }

    public function createAdminUser(){
        $kernel = new AppKernel('prod', false);
        $application = new Application($kernel);

        $input = new ArrayInput([
            'command' => 'fos:user:create',
            // (optional) define the value of command arguments
            'username' => $this->podlatchUser,
            'email' => $this->podlatchEmail,
            'password' => $this->podlatchPassword,
            // (optional) pass options to the command
            '--super-admin' => true,
        ]);
        $output = new BufferedOutput();
        error_reporting(E_ALL);
        $application->run($input, $output);

        $meh = $output;


    }

    public function writeSymfonyParameters()
    {


        error_reporting(E_ALL);
        $yamlTemplate = \Symfony\Component\Yaml\Yaml::parseFile(__DIR__.'/../../app/config/parameters.yml.dist');


        $parameters = $yamlTemplate['parameters'];

        $parameters['database_host'] = $this->dbHost;
        $parameters['database_port'] = $this->dbPort;
        $parameters['database_name'] = $this->dbName;
        $parameters['database_user'] = $this->dbUser;
        $parameters['database_password'] = $this->dbPassword;
        $parameters['mailer_user'] = $this->podlatchEmail;
        $parameters['secret'] = uniqid(mt_rand(), true);

        $productionYaml = \Symfony\Component\Yaml\Yaml::dump(['parameters'=>$parameters]);
        file_put_contents(__DIR__.'/../../app/config/parameters.yml', $productionYaml);

    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {

        return $this->errorMessages;
    }


    public function isFirstRun()
    {
        $isFirstRun = !file_exists(__DIR__.'/../../app/config/parameters.yml');
        return $isFirstRun;
    }


}


