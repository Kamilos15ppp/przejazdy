<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\AppException;
use App\Exception\NotFoundException;
use Throwable;

class RideController extends RideAbstractController
{
    private const PAGE_SIZE = 10;

    public function loginAction(): void
    {
        try {
            if ($this->request->isPost()) {
                $username = trim($this->request->postParam('username'));
                $password = trim($this->request->postParam('password'));

                if (!empty($username) && !empty($password)) {
                    $user =  $this->userModel->get($username);
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['userRole'] = $user['userRole'];
                        $this->redirect('/', []);
                    }
                }
            }
        } catch (Throwable $e) {
            throw new AppException('Nie udało się zalogować', 400, $e);
        }
        $this->view->render('login');
    }

    public function logoutAction(): void
    {
        unset($_SESSION);
        session_destroy();
        $this->view->render('login');
    }

    public function registerAction(): void
    {
        if ($this->request->isPost()) {
            $username = trim($this->request->postParam('username'));
            $usernameSafe = htmlentities(trim($this->request->postParam('username')));
            $password = trim($this->request->postParam('password'));
            $userRole = 'user';
            if (
                !empty($username)
                && !empty($password)
                && preg_match('/^[a-zA-Z0-9_]+$/', $username)
                && strlen($password) >= 6
            ) {
                $userData = [
                    'username' => $username,
                    'usernameSafe' => $usernameSafe,
                    'password' => $password,
                    'userRole' => $userRole
                ];
                $this->userModel->createUser($userData);
                $this->redirect('/?action=login', []);
            }
        }
        $this->view->render('register');
    }

    public function createAction(): void
    {
        if ($this->request->hasPost()) {
            $tabor = $this->request->postParam('tabor');
            $line = $this->request->postParam('line');
            $direction = $this->request->postParam('direction');
            $first = $this->request->postParam('first');
            $last = $this->request->postParam('last');

            if (
                !empty($tabor)
                && !empty($line)
                && !empty($direction)
                && !empty($first)
                && !empty($last)
            ) {
                $rideData = [
                    'tabor' => $tabor,
                    'line' => $line,
                    'direction' => $direction,
                    'first' => $first,
                    'last' => $last
                ];
                $this->rideModel->create($rideData);
                $this->redirect('/', ['before' => 'created']);
                exit;
            } else {
                $this->view->render('create', ['error' => 'emptyValue']);
            }
        }
        $this->view->render('create');
    }

    public function showAction(): void
    {
        $error = $this->request->getParam('error') ?? null;

        $this->view->render('show', ['ride' => $this->getRide(), 'error' => $error]);
    }

    public function listAction(): void
    {
        $pageNumber = (int) $this->request->getParam('page', 1);
        $pageSize = (int) $this->request->getParam('pagesize', self::PAGE_SIZE);
        $sortBy = $this->request->getParam('sortby', 'created');
        $sortOrder = $this->request->getParam('sortorder', 'desc');

        if (!in_array($pageSize, [1, 5, 10, 20])) {
            $pageSize = self::PAGE_SIZE;
        }

        $ride = $this->rideModel->list($pageNumber, $pageSize, $sortBy, $sortOrder);
        $rides = $this->rideModel->count();

        $this->view->render(
            'list',
            [
                'page' => [
                    'number' => $pageNumber,
                    'size' => $pageSize,
                    'pages' => (int) ceil($rides / $pageSize)
                ],
                'sort' => ['by' => $sortBy, 'order' => $sortOrder],
                'rides' => $ride,
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error')
            ]
        );
    }

    public function editAction(): void
    {
        if ($this->request->isPost()) {
            $rideId = (int)$this->request->postParam('id');
            $tabor = $this->request->postParam('tabor');
            $line = $this->request->postParam('line');
            $direction = $this->request->postParam('direction');
            $first = $this->request->postParam('first');
            $last = $this->request->postParam('last');

            if (
                !empty($tabor)
                && !empty($line)
                && !empty($direction)
                && !empty($first)
                && !empty($last)
            ) {
                $rideData = [
                    'tabor' => $tabor,
                    'line' => $line,
                    'direction' => $direction,
                    'first' => $first,
                    'last' => $last
                ];
                $this->rideModel->edit($rideId, $rideData);
                $this->redirect('/', ['before' => 'edited']);
            } else {
                $this->redirect('/', ['action' => 'show', 'id' => (string) $rideId, 'error' => 'emptyValue']);
            }
        }

        $this->view->render('edit', ['ride' => $this->getRide()]);
    }

    public function deleteAction(): void
    {
        if ($this->request->isPost()) {
            $id = (int) $this->request->postParam('id');
            $this->rideModel->delete($id);
            $this->redirect('/', ['before' => 'deleted']);
        }

        $this->view->render('delete', ['ride' => $this->getRide()]);
    }

    private function getRide(): array
    {
        $rideId= (int) $this->request->getParam('id');
        if (!$rideId) {
            $this->redirect('/', ['error' => 'missingRideId']);
        }

        try {
            $ride = $this->rideModel->get($rideId);
        } catch (NotFoundException $e) {
            $this->redirect('/', ['error' => 'rideNotFound']);
        }

        return $ride;
    }

    public function listBusAction(): void
    {
        $this->view->render('list_bus', ['vehicles' => $this->rideModel->listVehicles('bus')]);
    }

    public function listTramAction(): void
    {
        $this->view->render('list_tram', ['vehicles' => $this->rideModel->listVehicles('tram')]);
    }

    public function listRelicAction(): void
    {
        $this->view->render('list_relic', ['vehicles' => $this->rideModel->listVehicles('relic')]);
    }
}