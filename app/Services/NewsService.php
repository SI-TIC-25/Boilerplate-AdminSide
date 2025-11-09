<?php

namespace App\Services;

use App\Constants\DBTypes;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class NewsService extends News
{
    public function getQuery()
    {
        return $this->newQuery()->with([
            'categories' => function ($query) {
                $query->select('id', 'name');
            },
            'cover' => function ($query) {
                $query->addSelect(DB::raw("*, CONCAT('" . config('app.url') . "/', directories, '/', filename) as url"))
                    ->whereHas('transtype', function ($query) {
                        $query->where('code', DBTypes::FileKoverBerita);
                    });
            },
        ]);
    }
}
