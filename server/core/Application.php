<?php
/**
 * Application.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 7:17
 */

namespace app\core;

use app\core\db\Database;
//use app\core\db\DbModel;
use Exception;

/**
 * Class Application
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core
 * @version 1.0
 */
class Application
{
    public static string $ROOT_DIR;
    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public static Application $app;
    public Database $db;

    public ?UserModel $user;
    public ?Controller $controller = null;

    public View $view;
    //public Functions $functions;

    private array $config;

    /**
     * Előkészítés
     * @param string $rootPath
     * @param array $config
     */
    public function __construct(string $rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->config = $config;

        $this->db = new Database($config['db']);

        $primary_value = $this->session->get('user');
        if ($primary_value) {
            $primary_key = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primary_key => $primary_value]);
        } else {
            $this->user = null;
        }
    }

    /**
     * Alkalmazás futtatása
     */
    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * Beállított kontroller lekérése
     * @return Controller
     */
    //public function getController(): Controller
    //{
    //    return $this->controller;
    //}

    /**
     * Kontroller beállítása
     * @param Controller $controller
     */
    //public function setController(Controller $controller): void
    //{
    //    $this->controller = $controller;
    //}

    /**
     * Belépés a rendszerbe
     * @param UserModel $user
     * @return boolean
     */
    public function login(UserModel $user): bool
    {
        $this->user = $user;
        // Adattábla elsődleges kulcsának neve
        $primaryKey = $user->primaryKey();
        // Elsődleges kulcs értéke
        $primaryValue = $user->{$primaryKey};
        // Beteszem a felhasználói azonosítót a SESSION-be
        $this->session->set('user', $primaryValue);

        return true;
    }

    /**
     * Kilépés a rendszerből
     */
    public function logout()
    {
        $this->user = null;

        $this->session->remove('user');
    }

    /**
     * Be van jelentkezve a felhasználó?
     * @return bool
     */
    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    /**
     * Beállítás elemének lekérése
     * @param string $path
     * @return string
     */
    public function getConfig(string $path): string
    {
        $retval = '';
        if ($path) {
            $config = $this->config;
            $path = explode('/', $path);

            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    //$config = $config[$bit];
                    $retval = $config[$bit];
                    break;
                }
            }
        }
        return $retval;
    }

    public function getHost(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                "https" :
                "http") . "://$_SERVER[HTTP_HOST]";
    }

}