<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class GuidanceController extends Controller
{
    /**
     * Menampilkan Pusat Panduan Penggunaan FroShelf (FR-00).
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $defaultTab = $user->isPemilik() ? 'pemilik' : 'staf';
        $activeTab = $request->query('peran', $defaultTab);

        if (! in_array($activeTab, ['staf', 'pemilik'], true)) {
            $activeTab = $defaultTab;
        }

        return view('guidance.index', [
            'activeTab' => $activeTab,
        ]);
    }
}
