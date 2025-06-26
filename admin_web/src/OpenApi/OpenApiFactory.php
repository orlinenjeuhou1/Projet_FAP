<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model\Paths;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Response;

class OpenApiFactory implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $paths = $openApi->getPaths();

        $paths->addPath('/api/stats/visits-by-month', new PathItem(
            get: new Operation(
                operationId: 'getVisitsByMonth',
                tags: ['Statistiques'],
                responses: [
                    '200' => new Response('Statistiques mensuelles')
                ],
                summary: 'Nombre de visites par mois'
            )
        ));

        $paths->addPath('/api/stats/visits-by-month-guide', new PathItem(
            get: new Operation(
                operationId: 'getVisitsByMonthGuide',
                tags: ['Statistiques'],
                responses: [
                    '200' => new Response('Statistiques mensuelles par guide')
                ],
                summary: 'Nombre de visites par guide et par mois'
            )
        ));

        $paths->addPath('/api/stats/presence', new PathItem(
            get: new Operation(
                operationId: 'getPresenceRate',
                tags: ['Statistiques'],
                responses: [
                    '200' => new Response('Taux de présence mensuel')
                ],
                summary: 'Taux de présence par mois'
            )
        ));

        return $openApi;
    }
}
