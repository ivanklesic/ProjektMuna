<?php declare(strict_types = 1);

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Service\CheckStringService;
use App\Model\HistoryItem\HistoryItemRepository;
use DateTimeInterface;

class MainController extends AbstractController
{
    private CheckStringService $checkStringService;

    private HistoryItemRepository $historyItemRepository;

    public function __construct()
    {
        $this->checkStringService = new CheckStringService();
        $this->historyItemRepository = new HistoryItemRepository();
        parent::__construct();
    }

    public function checkAction()
    {
        $returnData = [];
        if($this->request->requestMethod === "POST") {
            if ($this->request->getBody()['stringValue']) {
                $checkResult = $this->checkStringService->check($this->request->getBody()['stringValue']);

                $insertData = [
                    'value' => $this->request->getBody()['stringValue'],
                    'time' => (new \DateTime())->format(DateTimeInterface::RFC3339)
                ];

                $this->historyItemRepository->insert($insertData);

            }
            if (is_string($checkResult)) {
                $returnData['error'] = $checkResult;
            } else {
                $returnData['ok'] = $checkResult ? 'true' : 'false';
            }
        } else {
            $returnData['error'] = 'Request method not supported!';
        }

        header('Content-type:application/json;charset=utf-8');
        echo json_encode($returnData);
    }

    public function statAction(): array
    {
        header('Content-type:application/json;charset=utf-8');
        return $this->historyItemRepository->getList();
    }
}