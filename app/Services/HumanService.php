<?php

namespace App\Services;

use App\Models\Human;
use Illuminate\Database\Eloquent\Collection;

class HumanService
{
    public function create(array $humanData): Human
    {
        return Human::create($humanData);
    }

    public function getOrderedHumans(): Collection
    {
        return Human::query()
            ->orderByDesc('aura')
            ->orderBy('id')
            ->get();
    }

    public function getBattleHumans(): Collection
    {
        return $this->getOrderedHumans()->take(2);
    }

    public function getBattleResult(Human $firstHuman, Human $secondHuman): string
    {
        if ($firstHuman->getAura() === $secondHuman->getAura()) {
            return 'Hay empate en la batalla de farmeo de aura.';
        }

        $winner = $firstHuman->getAura() > $secondHuman->getAura()
            ? $firstHuman
            : $secondHuman;

        return 'Ganaría '.$winner->getName().' con '.$winner->getAura().' de aura.';
    }
}
