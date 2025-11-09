<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Constants\DBTypes;
use App\Constants\FileDirectory;
use App\Constants\Routes;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Menu;
use App\Models\News;
use App\Models\Type;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    protected $news, $type, $menu, $file;

    public function __construct(NewsService $news, Type $type, Menu $menu, File $file)
    {
        $this->news = $news;
        $this->type = $type;
        $this->menu = $menu;
        $this->file = $file;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->news->with(['categories'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori', function ($row) {
                    return $row->categories->name;
                })
                ->addColumn('action', function ($row) {

                    $btn = '
                            <button onclick="editForm(`' . route('news.update', $row->id) . '`)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit ' . $row->name . '">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button onclick="deleteData(`' . route('news.destroy', $row->id) . '`)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete ' . $row->name . '">
                                <i class="fa fa-trash"></i>
                            </button>
                        ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $features = $this->setFeatureSession(Routes::routeMasterNews);

        $categories = $this->type->where('master_id', $this->type->getIdByCode(DBTypes::KategoriBerita))->get();
        return view('AdminPages.Masters.News.index', compact('categories', 'features'));
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
        // Validator
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'desk' => 'required|string',
        ]);

        if ($validator->fails())
            return $this->failed($validator->errors()->first());
        // End Validator

        $create = collect($request->only($this->news->getFillable()))
            ->filter()
            ->put('created_by', Auth::user()->id)
            ->toArray();


        $data = $this->news->create($create);

        if ($request->hasFile('cover')) {
            $type = $this->type->getIdByCode(DBTypes::FileKoverBerita);

            $this->uploadFile($request->file('cover'), $type, $data->id, $request->file('cover')->hashName(), FileDirectory::KoverBerita);
        }

        return $this->success('Success Create New News', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->news->getQuery()->find($id);
        if (!$data)
            return $this->notFound();
        return $this->success('Success Show News', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->news->find($id);
        if (!$data)
            return $this->notFound();

        $update = collect($request->only($this->news->getFillable()))
            ->filter()
            ->put('updated_by', Auth::user()->id);

        $data->update($update->toArray());

        if ($request->hasFile('cover')) {
            $cover = $this->file->where('transtypeid', $this->type->getIdByCode(DBTypes::FileKoverBerita))->where('refid', $id)->first();
            if ($cover) {
                $this->deleteFile($cover->directories, $cover->filename);
                $cover->delete();
            }

            $type = $this->type->getIdByCode(DBTypes::FileKoverBerita);

            $this->uploadFile($request->file('cover'), $type, $data->id, $request->file('cover')->hashName(), FileDirectory::KoverBerita);
        }

        return $this->success('Success Update News', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->news->find($id);
        if (!$data)
            return $this->notFound();

        $cover = $this->file->where('transtypeid', $this->type->getIdByCode(DBTypes::FileKoverBerita))->where('refid', $id)->first();
        if ($cover) {
            $this->deleteFile($cover->directories, $cover->filename);
            $cover->delete();
        }

        $data->delete();
        return $this->success('Success Hapus News', $data);
    }
}
