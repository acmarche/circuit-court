<?php

declare(strict_types=1);

use App\Livewire\CircuitCourt\AboutPage;
use App\Livewire\CircuitCourt\ActeurIndex;
use App\Livewire\CircuitCourt\ActeurShow;
use App\Livewire\CircuitCourt\FiliereIndex;
use App\Livewire\CircuitCourt\FiliereShow;
use App\Livewire\CircuitCourt\LocaliteIndex;
use App\Livewire\CircuitCourt\LocaliteShow;
use App\Livewire\CircuitCourt\MapPage;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('circuit-court'));

// Circuit Court
Route::prefix('circuit-court')->group(function (): void {
    Route::get('/', MapPage::class)->name('circuit-court.map');
    Route::get('/acteur', ActeurIndex::class)->name('circuit-court.acteurs');
    Route::get('/acteur/{shop:slug}', ActeurShow::class)->name('circuit-court.acteur.show');
    Route::get('/filiere', FiliereIndex::class)->name('circuit-court.filieres');
    Route::get('/filiere/{tag:slug}', FiliereShow::class)->name('circuit-court.filiere.show');
    Route::get('/localite', LocaliteIndex::class)->name('circuit-court.localites');
    Route::get('/localite/{city}', LocaliteShow::class)->name('circuit-court.localite.show');
    Route::get('/a-propos', AboutPage::class)->name('circuit-court.about');
});
