<?php

namespace App\Controller\Admin;

use App\Service\FlaskIntegrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PredictionController extends AbstractController
{
    private $flaskEndpoint = 'http://127.0.0.1:5000';

    private $thresholds = [
        'prediction' => [
            'low' => 85.055,
            'medium' => 1368.1,
        ],
        'predictProduction' => [
            'low' => 1053.00,
            'medium' => 1053.00,
        ],
    ];

    /**
     * @Route("/prediction", name="app_prediction", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = [
                'Menge' => $request->request->get('Menge', 0),
                'Nettpreis' => $request->request->get('Nettpreis', 0),
            ];

            $predictions = $this->executeFlaskAPI($data, '/cost_maintenance');

            $results = array_map(function ($value) {
                return [
                    'value' => $value,
                    'classification' => $this->classifyValue($value, $this->thresholds['prediction']),
                ];
            }, $predictions);

            return $this->render('admin/result.html.twig', [
                'results' => $results,
            ]);
        }

        return $this->render('admin/prediction.html.twig');
    }

    /**
     * @Route("/predictProduction", name="predictProduction", methods={"GET", "POST"})
     */
    public function index2(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = [
                'Menge' => $request->request->get('MengeProd', 0),
                'WertBB' => $request->request->get('WertBB', 0),
                'Gesamtvbrwert' => $request->request->get('Gesamtvbrwert', 0),
            ];

            $predictions2 = $this->executeFlaskAPI($data, '/predict_cost_production');

            $results2 = array_map(function ($value) {
                return [
                    'value' => $value,
                    'classification' => $this->classifyValue($value, $this->thresholds['predictProduction']),
                ];
            }, $predictions2);

            return $this->render('admin/result2.html.twig', [
                'results' => $results2,
            ]);
        }

        return $this->render('admin/prediction.html.twig');
    }

    private function executeFlaskAPI(array $data, string $endpoint): array
    {
        $flaskIntegrationService = new FlaskIntegrationService($this->flaskEndpoint);
        return $flaskIntegrationService->executeFlaskAPI($data, $endpoint);
    }

    private function classifyValue($value, $thresholds)
    {
        if ($value < $thresholds['low']) {
            return 'Low Cost';
        } elseif ($value < $thresholds['medium']) {
            return 'Medium Cost';
        } else {
            return 'High Cost';
        }
    }
}
