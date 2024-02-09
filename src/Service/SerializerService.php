<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;

class SerializerService
{
    /**
     * @var Serializer
     */
    protected Serializer $serializer;

    /**
     * Add additional normalizers/encoders
     */
    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizers = [
            new DateTimeNormalizer(),
            new ObjectNormalizer($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter(), null, null, null, null, $defaultContext)
        ];
        $encoders = [
            new JsonEncoder(),
            new XmlEncoder()
        ];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @throws ExceptionInterface
     */
    public function toArray(mixed $object, array $context = []): array
    {
        return $this->serializer->normalize($object, null, $context);
    }
}
