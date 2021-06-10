<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;

class RidesController extends AbstractRidesController
{
    private const PAGE_SIZE = 10;

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
                $this->database->create($rideData);
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

        $ride = $this->database->list($pageNumber, $pageSize, $sortBy, $sortOrder);
        $rides = $this->database->count();

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
                $this->database->edit($rideId, $rideData);
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
            $this->database->delete($id);
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
            $ride = $this->database->get($rideId);
        } catch (NotFoundException $e) {
            $this->redirect('/', ['error' => 'rideNotFound']);
        }

        return $ride;
    }

    public function listBusAction(): void
    {
        $this->view->render('list_bus', ['vehicles' => $this->database->listVehicles('bus')]);
    }

    public function listTramAction(): void
    {
        $this->view->render('list_tram', ['vehicles' => $this->database->listVehicles('tram')]);
    }

    public function listRelicAction(): void
    {
        $this->view->render('list_relic', ['vehicles' => $this->database->listVehicles('relic')]);
    }
}