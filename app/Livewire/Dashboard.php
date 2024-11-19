<?php

namespace App\Livewire;

use App\Models\TableSetting;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        $articles1 = TableSetting::where('urlPrincipal', 'https://diariosinfronteras.com.pe/')->get();
        $articles2 = TableSetting::where('urlPrincipal', 'https://www.expreso.com.pe/')->get();
        $articles3 = TableSetting::where('urlPrincipal', 'https://losandes.com.pe/')->get();
        $articles4 = TableSetting::where('urlPrincipal', 'https://larepublica.pe')->get();
        $articles5 = TableSetting::where('urlPrincipal', 'https://www.exitosanoticias.pe/')->get();

        $art1Today = TableSetting::whereDate('created_at', Carbon::today())->where('urlPrincipal', 'https://diariosinfronteras.com.pe/')->count();
        $art2Today = TableSetting::whereDate('created_at', Carbon::today())->where('urlPrincipal', 'https://www.expreso.com.pe/')->count();
        $art3Today = TableSetting::whereDate('created_at', Carbon::today())->where('urlPrincipal', 'https://losandes.com.pe/')->count();
        $art4Today = TableSetting::whereDate('created_at', Carbon::today())->where('urlPrincipal', 'https://larepublica.pe')->count();
        $art5Today = TableSetting::whereDate('created_at', Carbon::today())->where('urlPrincipal', 'https://www.exitosanoticias.pe/')->count();

        $art1Yesterday = TableSetting::whereDate('created_at', Carbon::yesterday())->where('urlPrincipal', 'https://diariosinfronteras.com.pe/')->count();
        $art2Yesterday = TableSetting::whereDate('created_at', Carbon::yesterday())->where('urlPrincipal', 'https://www.expreso.com.pe/')->count();
        $art3Yesterday = TableSetting::whereDate('created_at', Carbon::yesterday())->where('urlPrincipal', 'https://losandes.com.pe/')->count();
        $art4Yesterday = TableSetting::whereDate('created_at', Carbon::yesterday())->where('urlPrincipal', 'https://larepublica.pe')->count();
        $art5Yesterday = TableSetting::whereDate('created_at', Carbon::yesterday())->where('urlPrincipal', 'https://www.exitosanoticias.pe/')->count();

        $totalArticles = TableSetting::count();

        if ($totalArticles > 0) {
            $porc1 = round(($articles1->count() / $totalArticles) * 100, 2);
            $porc2 = round(($articles2->count() / $totalArticles) * 100, 2);
            $porc3 = round(($articles3->count() / $totalArticles) * 100, 2);
            $porc4 = round(($articles4->count() / $totalArticles) * 100, 2);
            $porc5 = round(($articles5->count() / $totalArticles) * 100, 2);
        } else {
            $porc1 = 0;
            $porc2 = 0;
            $porc3 = 0;
            $porc4 = 0;
            $porc5 = 0;
        }
        return view('dashboard', compact('articles1', 'articles2', 'articles3', 'articles4', 'articles5', 'totalArticles', 'art1Today', 'art2Today', 'art3Today', 'art4Today', 'art5Today', 'art1Yesterday', 'art2Yesterday', 'art3Yesterday', 'art4Yesterday', 'art5Yesterday', 'porc1', 'porc2', 'porc3', 'porc4', 'porc5'));
    }
}
