<?php

namespace Tests\Feature;

use App\Models\Human;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HumanTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_displays_the_three_human_actions(): void
    {
        $response = $this->get(route('home.index'));

        $response->assertOk()
            ->assertSee('Registrar humanos')
            ->assertSee('Listar humanos')
            ->assertSee('Batalla de humanos');
    }

    public function test_human_registration_validates_and_persists_data(): void
    {
        $response = $this->from(route('human.create'))->post(route('human.store'), [
            'name' => 'Aura One',
            'aura' => 500,
            'hierarchy' => 'legendario',
        ]);

        $response->assertRedirect(route('human.index'));
        $this->assertDatabaseHas('humans', [
            'name' => 'Aura One',
            'aura' => 500,
            'hierarchy' => 'legendario',
        ]);

        $this->from(route('human.create'))
            ->post(route('human.store'), [
                'name' => '',
                'aura' => -1,
                'hierarchy' => 'unknown',
            ])
            ->assertRedirect(route('human.create'))
            ->assertSessionHasErrors(['name', 'aura', 'hierarchy']);
    }

    public function test_humans_are_listed_by_descending_aura_with_display_rules(): void
    {
        Human::factory()->create(['name' => 'Common Human', 'aura' => 100, 'hierarchy' => 'común']);
        Human::factory()->create(['name' => 'Legendary Human', 'aura' => 900, 'hierarchy' => 'legendario']);
        Human::factory()->create(['name' => 'Moderate Human', 'aura' => 500, 'hierarchy' => 'moderado']);

        $response = $this->get(route('human.index'));

        $response->assertOk()
            ->assertSeeInOrder(['Legendary Human', 'Moderate Human', 'Common Human'])
            ->assertSee('Boff')
            ->assertSee('text-primary');
    }

    public function test_battle_uses_the_two_strongest_humans_and_declares_the_winner(): void
    {
        Human::factory()->create(['name' => 'Winner', 'aura' => 900]);
        Human::factory()->create(['name' => 'Second', 'aura' => 500]);
        Human::factory()->create(['name' => 'Ignored', 'aura' => 100]);

        $this->get(route('human.battle'))
            ->assertOk()
            ->assertSeeInOrder(['Winner', '900', 'Second', '500'])
            ->assertSee('Ganaría Winner con 900 de aura.');
    }

    public function test_battle_reports_a_tie_and_requires_two_humans(): void
    {
        Human::factory()->create(['name' => 'First', 'aura' => 500]);
        Human::factory()->create(['name' => 'Second', 'aura' => 500]);

        $this->get(route('human.battle'))
            ->assertSee('Hay empate en la batalla de farmeo de aura.');

        Human::query()->delete();

        $this->get(route('human.battle'))
            ->assertSee('Se necesitan al menos dos humanos para iniciar una batalla.');
    }
}
