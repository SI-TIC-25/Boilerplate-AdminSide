<?php

namespace App\Traits;

use App\Models\ModelHistory;
use Illuminate\Support\Facades\Auth;

trait HasHistory
{
    public static function bootHasHistory()
    {
        static::created(function ($model) {
            ModelHistory::create([
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'before' => null,
                'after' => $model->toArray(),
                'action' => 'created',
                'user_id' => Auth::id(),
            ]);
        });

        static::updating(function ($model) {
            $before = $model->getOriginal();
            $after = $model->getDirty(); // hanya field berubah

            ModelHistory::create([
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'before' => $before,
                'after' => $after,
                'action' => 'updated',
                'user_id' => Auth::id(),
            ]);
        });

        static::deleted(function ($model) {
            ModelHistory::create([
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'before' => $model->toArray(),
                'after' => null,
                'action' => 'deleted',
                'user_id' => Auth::id(),
            ]);
        });
    }
}
