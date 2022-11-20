<?php
/**
 * index.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 7:14
 * @version 1.0
 */

//use app\controllers\AuthController;
//use app\controllers\CompanyController;
//use app\controllers\CurrencyController;
//use app\controllers\HumanController;
//use app\controllers\SiteController;
//use app\controllers\UserController;
use app\core\Application;
//use app\models\User;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => User::class,
    'lang' => 'hu',
    'delete' => 'soft_delete',
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'app_mode_dev' => $_ENV['APP_MODE_DEV'],
    ],
];

$app = new Application(dirname(__DIR__), $config);

// --------------------------
// ROUTE -OK
// --------------------------

// ============================
// Login és Register
// ============================
$app->router->post('/api/login', [\app\controllers\AuthController::class, 'login']);
$app->router->post('/api/register', [\app\controllers\AuthController::class, 'register']);

// ============================
// Cég adatok kezelése
// ============================
$app->router->get('/api/companies', [app\controllers\CompanyController::class, 'getCompanies']);
$app->router->get('/api/company/{id}', [app\controllers\CompanyController::class, 'getCompany']);

// ============================
// Ország adatok kezelése
// ============================
$app->router->get('/api/countries', [app\controllers\CountryController::class, 'getCountries']);
$app->router->get('/api/country/{id}', [app\controllers\CountryController::class, 'getCountry']);

/*
$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->get('/login/{id}', [AuthController::class, 'login']);
$app->router->get('/login/{id:\d+}/{username}', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/profile', [AuthController::class, 'profile']);
$app->router->get('/profile/{id:\d+}/{username}', [AuthController::class, 'profile']);
$app->router->post('/change_password', [AuthController::class, 'change_password']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);

// ============================
// Cég adatok kezelése
// ============================
$app->router->get('/companies', [CompanyController::class, 'getCompanies']);

$app->router->get('/api/company/{id}', [CompanyController::class, 'getCompany']);

$app->router->post('/api/company/delete', [CompanyController::class, 'company_delete']);
//$app->router->get('/api/company/delete/{id}', [CompanyController::class, 'company_delete']);

$app->router->get('/company_new', [CompanyController::class, 'company_new']);
$app->router->post('/company_new', [CompanyController::class, 'company_new']);
$app->router->get('/company_edit/{id}', [CompanyController::class, 'company_edit']);
$app->router->post('/company_edit/{id}', [CompanyController::class, 'company_edit']);
$app->router->get('/company_delete/{id}', [CompanyController::class, 'company_delete']);
$app->router->post('/company_delete/{id}', [CompanyController::class, 'company_delete']);

// ============================
// Felhasználói adatok kezelése
// ============================
$app->router->get('/users', [UserController::class, 'users']);
$app->router->get('/user_new', [UserController::class, 'user_new']);
$app->router->post('/user_new', [UserController::class, 'user_new']);
$app->router->get('/user_edit/{id}', [UserController::class, 'user_edit']);
$app->router->post('/user_edit/{id}', [UserController::class, 'user_edit']);
$app->router->get('/user_delete/{id}', [UserController::class, 'user_delete']);
$app->router->post('/user_delete/{id}', [UserController::class, 'user_delete']);

// ============================
// Pénznem adatok kezelése
// ============================
$app->router->get('/currencies', [CurrencyController::class, 'currencies']);
$app->router->get('/currency_new', [CurrencyController::class, 'currency_new']);
$app->router->post('/currency_new', [CurrencyController::class, 'currency_new']);
$app->router->get('/currency_edit/{id}', [CurrencyController::class, 'currency_edit']);
$app->router->post('/currency_edit/{id}', [CurrencyController::class, 'currency_edit']);
$app->router->get('/currency_delete/{id}', [CurrencyController::class, 'currency_delete']);
$app->router->post('/currency_delete/{id}', [CurrencyController::class, 'currency_delete']);

// ============================
// Humans adatok kezelése
// ============================
$app->router->get('/humans', [HumanController::class, 'humans']);
$app->router->get('/human_new', [HumanController::class, 'human_new']);
$app->router->get('/human_edit/{id}', [HumanController::class, 'human_edit']);
*/

$app->run();