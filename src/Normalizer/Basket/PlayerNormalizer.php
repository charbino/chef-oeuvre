<?php

/*
 * This file is part of the EMS package.
 *
 * (c) NewQuest Entertainment
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Normalizer\Basket;

use App\Entity\Basket\Player;
use App\Repository\Basket\TeamRepository;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[Autoconfigure(tags: ['serializer.normalizer'])]
class PlayerNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function __construct(
        private ObjectNormalizer $normalizer,
        private TeamRepository $teamRepository
    ) {
    }

    public function normalize($player, string $format = null, array $context = []): mixed
    {
        return $this->normalizer->normalize($player, $format, $context);
    }

    /**
     * @param array<string> $context
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Player;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $denormalized = $this->normalizer->denormalize($data, $type, $format, $context);

        if (isset($data['team'])) {
            $team = $this->teamRepository->find($data['team']['id'] ?? null);
            $denormalized->setTeam($team);
        }

        return $denormalized;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return class_exists($type) || (interface_exists($type, false));
    }
}
