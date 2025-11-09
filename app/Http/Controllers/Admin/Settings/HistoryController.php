<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\ModelHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = ModelHistory::with('user');

            if ($request->model) {
                $query->where('model_type', $request->model);
            }
            if ($request->user) {
                $query->where('user_id', $request->user);
            }

            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn(
                    'model',
                    fn($row) =>
                    class_basename($row->model_type) . " (ID: {$row->model_id})"
                )
                ->addColumn(
                    'user',
                    fn($row) =>
                    $row->user?->name ?? '-'
                )
                ->addColumn(
                    'before',
                    fn($row) =>
                    $row->before
                        ? "<pre>" . json_encode($row->before, JSON_PRETTY_PRINT) . "</pre>"
                        : '-'
                )
                ->addColumn(
                    'after',
                    fn($row) =>
                    $row->after
                        ? "<pre>" . json_encode($row->after, JSON_PRETTY_PRINT) . "</pre>"
                        : '-'
                )
                ->rawColumns(['before', 'after'])
                ->make(true);
        }

        // data for filter
        $models = ModelHistory::select('model_type')->distinct()->pluck('model_type');
        $users = \App\Models\User::whereIn(
            'id',
            ModelHistory::select('user_id')->distinct()->pluck('user_id')
        )->get();

        return view('AdminPages.Settings.Histories.index', compact('models', 'users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelHistory $modelHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelHistory $modelHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelHistory $modelHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelHistory $modelHistory)
    {
        //
    }
}
