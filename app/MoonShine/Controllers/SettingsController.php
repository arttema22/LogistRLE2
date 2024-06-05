<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use MoonShine\MoonShineRequest;
use Spatie\Valuestore\Valuestore;
use Symfony\Component\HttpFoundation\Response;
use MoonShine\Http\Controllers\MoonShineController;

final class SettingsController extends MoonShineController
{
    public function __invoke(MoonShineRequest $request): Response
    {
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $settings->put('price_car_refueling', $request->price_car_refueling);
        $this->toast(__('moonshine::ui.saved'), 'success');
        return back();
    }
}
