<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Payload\Exception\PayloadValidationException;
use App\Domain\Core\PaginationParameters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractController extends SymfonyController
{
    private Request $mainRequest;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

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

    #[Required]
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    #[Required]
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @template T
     *
     * @param class-string<T> $type
     *
     * @return T
     */
    protected function createPayloadFromRequestContent(string $data, string $type)
    {
        $payload = $this->serializer->deserialize($data, $type, 'json');
        $errors = $this->validator->validate($payload);
        if (\count($errors) > 0) {
            throw new PayloadValidationException($errors);
        }

        return $payload;
    }

    protected function getPaginationParameters(): PaginationParameters
    {
        return new PaginationParameters($this->mainRequest->query->getInt('page', 1), $this->mainRequest->query->getInt('limit', 10));
    }
}
