<?php

namespace app\controllers;

use app\library\Controller;

class MainController extends Controller
{
    private $territoryModel;
    private $userModel;

    public function __construct()
    {
        $this->territoryModel = $this->model('Territory');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $regions = array();
        $regions = $this->territoryModel->getRegions();

        $data = [
            'regions' => $regions,
        ];

        $this->view('index', $data);
    }

    public function getAreas()
    {
        $region = $_POST['region'] ?? '';

        $areas = array();
        if ($region) {
            $areas = $this->territoryModel->getAreas(trim($region));
        }

        exit(json_encode($areas));
    }

    public function getCities()
    {
        $area = $_POST['area'] ?? '';

        $cities = array();
        if ($area) {
            $cities = $this->territoryModel->getCities(trim($area));
        }

        exit(json_encode($cities));
    }

    public function registration()
    {
        $userName = $_POST['name'] ?? '';
        $userEmail = $_POST['email'] ?? '';
        $userRegion = $_POST['region'] ?? '';
        $userArea = $_POST['area'] ?? '';
        $userCity = $_POST['city'] ?? '';

        $result = array();

        if (!$userName) {
            $result['errors'][] = [
                'name' => 'Не заполнено имя!'
            ];
        }
        if (!$userEmail) {
            $result['errors'][] = [
                'email' => 'Не заполнен email!'
            ];
        }
        if (!$userRegion) {
            $result['errors'][] = [
                'region' => 'Не выбрана область!'
            ];
        }
        if (!$userArea) {
            $result['errors'][] = [
                'area' => 'Не выбран район!'
            ];
        }
        if (!$userCity) {
            $result['errors'][] = [
                'city' => 'Не выбран город!'
            ];
        }

        $territory = $userCity . ", " . $userArea . ", " . $userRegion;

        if (!$result) {
            $user = $this->userModel->getUserByEmail($userEmail);

            if (!empty($user)) {
                $result = [
                    'msg' => 'Вы вошли!',
                    'status' => 'login',
                    'href' => 'registered'
                ];
            } else {
                $data = [
                    'name' => $userName,
                    'email' => $userEmail,
                    'territory' => $territory,
                ];

                $this->userModel->create($data);

                $result = [
                    'msg' => 'Вы зарегистрированы!',
                    'status' => 'registration',
                    'href' => 'registered'
                ];
            }

            $_SESSION['user'] = $this->userModel->getUserByEmail($userEmail);
        }

        exit(json_encode($result));
    }

    public function registered()
    {
        $user = $_SESSION['user'];

        $data = [
            'userName' => $user['name'],
            'userEmail' => $user['email'],
            'userTerritory' => $user['territory']
        ];

        $this->view('registered', $data);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('location: /');
    }
}