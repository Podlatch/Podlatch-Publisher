<?php
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

if(!$setup ->isFirstRun()){
    $response = new \Zend\Diactoros\Response\HtmlResponse(
        '<h1>403 - Already installed</h1><a href="/admin/">Login</a>',
        403
    );
    $emitter -> emit($response);
    exit();
}
$response = $response = new \Zend\Diactoros\Response\HtmlResponse(file_get_contents('index.htm'),200);


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

if(isset($request -> getQueryParams()['action']) && $request -> getQueryParams()['action'] === 'finish'){
    $meh = $request -> getUri()->getScheme().'://'.$request->getUri()->getHost();
    $setup -> writeSymfonyParameters();

    if($setup ->protectInstallationDirectory()){
        $response = new \Zend\Diactoros\Response\RedirectResponse('/admin/');
    } else {
        $response = new \Zend\Diactoros\Response\JsonResponse([],500);
    }
}

if(isset($request -> getQueryParams()['action']) && $request -> getQueryParams()['action'] === 'create-schema'){
    if($setup ->createDatabaseSchema()){
        if($setup ->createAdminUser()){
            $setup ->protectInstallationDirectory();
            $response = new \Zend\Diactoros\Response\JsonResponse([],200);
        } else {
            $response = new \Zend\Diactoros\Response\JsonResponse([],500);
        }
    } else {
        $response = new \Zend\Diactoros\Response\JsonResponse([],500);
    }

}

$emitter -> emit($response);

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
        $this->dbHost = $request->getParsedBody()['dbhost'];
        $this->dbPort = $request->getParsedBody()['dbport']?:3306;
        $this->dbName = $request->getParsedBody()['dbname'];
        $this->dbUser = $request->getParsedBody()['dbuser'];
        $this->dbPassword = $request->getParsedBody()['dbpassword'];
        $this->podlatchUser = $request->getParsedBody()['podlatchUser'];
        $this->podlatchPassword = $request->getParsedBody()['podlatchPassword'];
        $this->podlatchEmail = $request->getParsedBody()['podlatchEmail'];

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
        $sql = file_get_contents('install.sql');
        try{
            $this->getPdo()->exec($sql);
        } catch (Exception $e){
            return false;
        }
        return true;
    }

    public function createAdminUser(){
        return true;
    }

    public function protectInstallationDirectory(){
        return true;
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
        file_put_contents(__DIR__.'/../../app/config/parameters.yml2', $productionYaml);

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

