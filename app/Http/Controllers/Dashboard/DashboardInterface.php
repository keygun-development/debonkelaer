<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;

interface DashboardInterface
{
    public function index(): Factory|View|Application;

    public function detailedPage(Request $request): Factory|View|Application;

    public function create(Request $request): Redirector|Application|RedirectResponse;

    public function update(Request $request): RedirectResponse;

    public function delete(Request $request): RedirectResponse;
}
