<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHumanRequest;
use App\Models\Human;
use App\Services\HumanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HumanController extends Controller
{
    private readonly HumanService $humanService;

    public function __construct(HumanService $humanService)
    {
        $this->humanService = $humanService;
    }

    public function create(): View
    {
        return view('human.create')->with('viewData', [
            'title' => 'Registrar humanos',
            'hierarchies' => Human::HIERARCHIES,
        ]);
    }

    public function index(): View
    {
        return view('human.index')->with('viewData', [
            'title' => 'Lista de humanos',
            'humans' => $this->humanService->getOrderedHumans(),
        ]);
    }

    public function store(StoreHumanRequest $request): RedirectResponse
    {
        $this->humanService->create($request->validated());

        return redirect()->route('human.index')->with('success', 'Humano registrado correctamente.');
    }

    public function battle(): View
    {
        $battleHumans = $this->humanService->getBattleHumans();
        $viewData = [
            'title' => 'Batalla de humanos',
            'humans' => $battleHumans,
            'battleResult' => null,
        ];

        if ($battleHumans->count() === 2) {
            $viewData['battleResult'] = $this->humanService->getBattleResult(
                $battleHumans->get(0),
                $battleHumans->get(1),
            );
        }

        return view('human.battle')->with('viewData', $viewData);
    }
}
