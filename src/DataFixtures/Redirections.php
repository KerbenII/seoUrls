<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Redirection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Redirections extends Fixture
{
    /** TODO: Zmienic na 301 przed oddaniem zadania */
    private $statusCode = 302;

    public function load(ObjectManager $manager)
    {
        $redirectionsData = [
            'czarna-ramoneska-winter-fear' => ['/czarna-ramoneska'],
            'czarne-sniegowce-kenthurst' => [
                '/czarne-śniegowce-kenthurst',
                '/czarne-śniegowce',
                '/czarne-sniegowce',
                ],
            'biale-sniegowce-kenthurst' => [
                '/biale-śniegowce-kenthurst',
                '/białe-śniegowce-kenthurst',
                '/biale-śniegowce',
                '/białe-sniegowce',
            ],
            'biala-kurtka-gravatai' => [
                '/biala-kurtka-gravatai',
                '/biała-kurtka-gravatai',
                '/biala-kurtka-grawatai',
                '/biała-kurtka-grawatai',
                '/biala-kurtka',
                '/biała-kurtka',
            ],
            'zielona-kurtka-gravatai' => [
                '/zielona-kurtka-grawatai',
                '/zielona-kurtka',
            ],
            'Musztardowa Kurtka Gravatai' => [
                '/musztardowa-kurtka-grawatai',
                '/musztardowa-kurtka',
            ],
        ];

        foreach ($redirectionsData as $toPath => $fromPaths) {
            foreach ($fromPaths as $fromPath) {
                $redirection = new Redirection();
                $redirection->setFromPath($fromPath);
                $redirection->setToPath($toPath);
                $redirection->setStatusCode($this->statusCode);
                $manager->persist($redirection);
            }
        }
        $manager->flush();
    }
}
