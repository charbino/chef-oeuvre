<?php

declare(strict_types=1);

namespace App\Transformer\Basket;

use App\Converter\SizeConverter;
use App\Entity\Basket\Player;
use App\Entity\Basket\Team;
use App\Repository\Basket\TeamRepository;

class PlayerBasketTransformer implements PlayerBasketTransformerInterface
{
    public function __construct(
        private TeamRepository $repository
    )
    {
    }

    public function transform(array $data): Player
    {
        $player = new Player();
        $player->setExternalId($data['id']);
        $player->setFirstName($data['first_name']);
        $player->setLastName($data['last_name']);
        $player->setPosition($data['position']);
        $player->setCountry($data['country']);
        $player->setDraftNumber($data['draft_number']);

        if (isset($data['height'])) {
            $heigthData = explode("-", $data['height']);
            $player->setHeight(SizeConverter::inchToCentimeter((int)($heigthData[0] ?? 0), (int)($heigthData[1] ?? 0)));
        }
        if (isset($data['weight'])) {
            $player->setWeight(SizeConverter::poundToKilo((float)$data['weight']));
        }

        $player->setTeam($this->getTeam($data['team']));

        return $player;
    }

    private function getTeam(array $teamData): Team
    {
        $team = $this->repository->findOneBy(['externalId' => $teamData['id']]);

        if ($team !== null) {
            return $team;
        }

        //TODO DO THAT IN FACTORY oR BUILDER  and use serializer?
        $team = new Team();
        $team->setExternalId($teamData['id']);
        $team->setName($teamData['name']);
        $team->setFullName($teamData['full_name']);
        $team->setAbbreviation($teamData['abbreviation']);
        $team->setCity($teamData['city']);
        $team->setConference($teamData['conference']);

        $this->repository->save($team, true);

        return $team;
    }
}
