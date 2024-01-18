<?php

declare(strict_types=1);

namespace App\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractController extends SymfonyController
{
    private Request $mainRequest;

    /**
     * @return array<string>
     */
    protected function getSerializationGroups(): array
    {
        $groups = $this->mainRequest->get('groups');

        return !\is_array($groups)
            ? explode(',', $this->mainRequest->query->getAlpha('groups'))
            : $this->mainRequest->query->all('groups');
    }

    #[Required]
    public function setMainRequest(RequestStack $requestStack): void
    {
        $this->mainRequest = $requestStack->getMainRequest() ?? new Request();
    }
}
