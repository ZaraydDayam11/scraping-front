<?php

use App\Livewire\Admin\AccountSettingYape;
use App\Livewire\Client\Article;
use App\Livewire\Client\PageVentaResultado;
use App\Livewire\Client\PaymenYape;
use App\Livewire\Admin\SisCrudYape;
use App\Livewire\Dashboard;
use App\Livewire\PageVoucher;
use App\Livewire\Seting;
use App\Livewire\SetingPag;
use App\Livewire\Roles;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;

Route::get('/', Article::class)->name('articles');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/sistema/pagina/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/sistema/pagina/scrapy', Seting::class)->name('scrapy');
    Route::get('/sistema/pagina/scrapy/pag', SetingPag::class)->name('scrapy.pag');

    Route::get('/sistema/pagina/roles', Roles::class)->middleware('can:roles')->name('roles');

    Route::get('/sistema/pagina/usuarios', Users::class)->middleware('can:users')->name('users');

    Route::get('/articulos/pdf', [Seting::class, 'createPDF']);

    Route::get('/yape/{yapeId}', PaymenYape::class)->name('yape-pay');
    Route::get('/results', PageVentaResultado::class)->name('venta-resultado');

    Route::get('/sistema/pagina/registro-de-ventas-pagos-yape', SisCrudYape::class)->name('registro-de-ventas-pagos-yape');
    Route::get('/sistema/pagina/configurar-cuenta-yape', AccountSettingYape::class)->name('configurar-cuenta-yape');

    // RUTA PARA GENERAR EL VOUCHER EN PDF
    Route::get('/pdf/visualizar', [PageVoucher::class, 'validarProforma'])->name('voucher.visualizar');
});

