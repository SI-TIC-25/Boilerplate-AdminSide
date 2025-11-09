<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Constants\DBTypes;
use App\Constants\FileDirectory;
use App\Constants\Routes;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Menu;
use App\Models\Type;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    protected $post, $type, $menu, $file;

    public function __construct(PostService $post, Type $type, Menu $menu, File $file)
    {
        $this->post = $post;
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
            $data = $this->post->with(['categories'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return $row->categories->name;
                })
                ->addColumn('action', function ($row) {

                    $btn = '
                            <button onclick="editForm(`' . route('posts.update', $row->id) . '`)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit ' . $row->name . '">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button onclick="deleteData(`' . route('posts.destroy', $row->id) . '`)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete ' . $row->name . '">
                                <i class="fa fa-trash"></i>
                            </button>
                        ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $features = $this->setFeatureSession(Routes::routeMasterPost);

        $categories = $this->type->where('master_id', $this->type->getIdByCode(DBTypes::PostCategories))->get();
        return view('AdminPages.Masters.posts.index', compact('categories', 'features'));
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
            'category_id' => 'required',
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);

        if ($validator->fails())
            return $this->failed($validator->errors()->first());
        // End Validator

        $create = collect($request->only($this->post->getFillable()))
            ->filter()
            ->put('created_by', Auth::user()->id)
            ->toArray();


        $data = $this->post->create($create);

        if ($request->hasFile('thumbnail')) {
            $type = $this->type->getIdByCode(DBTypes::FilePostThumbnail);

            $this->uploadFile($request->file('thumbnail'), $type, $data->id, $request->file('thumbnail')->hashName(), FileDirectory::PostThumbnail);
        }

        return $this->success('Success Create New post', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->post->getQuery()->find($id);
        if (!$data)
            return $this->notFound();
        return $this->success('Success Show post', $data);
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
        $data = $this->post->find($id);
        if (!$data)
            return $this->notFound();

        $update = collect($request->only($this->post->getFillable()))
            ->filter()
            ->put('updated_by', Auth::user()->id);

        $data->update($update->toArray());

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $this->file->where('transtypeid', $this->type->getIdByCode(DBTypes::FilePostThumbnail))->where('refid', $id)->first();
            if ($thumbnail) {
                $this->deleteFile($thumbnail->directories, $thumbnail->filename);
                $thumbnail->delete();
            }
            
            $type = $this->type->getIdByCode(DBTypes::FilePostThumbnail);

            $this->uploadFile($request->file('thumbnail'), $type, $data->id, $request->file('thumbnail')->hashName(), FileDirectory::PostThumbnail);
        }

        return $this->success('Success Update post', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->post->find($id);
        if (!$data)
            return $this->notFound();

        $thumbnail = $this->file->where('transtypeid', $this->type->getIdByCode(DBTypes::FilePostThumbnail))->where('refid', $id)->first();
        if ($thumbnail) {
            $this->deleteFile($thumbnail->directories, $thumbnail->filename);
            $thumbnail->delete();
        }

        $data->delete();
        return $this->success('Success Hapus post', $data);
    }
}
