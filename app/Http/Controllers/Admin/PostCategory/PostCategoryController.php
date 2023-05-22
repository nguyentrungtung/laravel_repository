<?php

namespace App\Http\Controllers\Admin\PostCategory;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Repositories\PostCategoryRepositoryInterface;
use App\Services\Production\FileServices;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PostCategory\CreateRequest;
use App\Http\Requests\Admin\PostCategory\UpdateRequest;
use Illuminate\Support\Str;
use Redirect;
// use App\Http\Controllers\Admin\Loging\LogingController;

class PostCategoryController extends Controller
{
    /** @var App\Repositories\{postcategory}RepositoryInterface postcategoryRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $postcategoryRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;
    // protected $logingController;
    /**
     * class UserController.
     *
     * @param \{postcategory}RepositoryInterface $postcategoryRepository
     */
    public function __construct(
        PostCategoryRepositoryInterface $postcategoryRepository,
        FileServices $fileServices,
        // LogingController $logingController
    ) {
        $this->postcategoryRepository = $postcategoryRepository;
        $this->fileServices = $fileServices;
        // $this->logingController = $logingController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Auth::user()->hasPermissionTo('list danh muc bai viet')) {
            $offset = $request->get('offset', '');
            $limit = $request->get('limit', 20);
            $order = $request->get('order', 'updated_at');
            $direction = $request->get('direction', 'DESC');

            $queryWord = $request->get('query');

            $filter = [];
            if (! empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $postcategorys = $this->postcategoryRepository->allByFilterPagination($filter, $limit, $order, $direction);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'post Category', 'url' => route('postcategory.index')]
            ];
            return view('admin.postcategorys.index', compact('postcategorys', 'breadcrumbs'));
        } else {
            \App::abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->hasPermissionTo('add danh muc bai viet')) {
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'post Category', 'url' => route('postcategory.index')]
            ];
        $statusData = [
            [
                'name' => 'Ẩn',
                'value' => 0,
            ],
            [
                'name' => 'Hiện',
                'value' => 1,
            ],
        ];

        return view('admin.postcategorys.edit', compact('statusData', 'breadcrumbs'));
    } else {
        \App::abort(403);
    }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        if(\Auth::user()->hasPermissionTo('add danh muc bai viet')) {
            $input = $request->except(['_token']);
            $input['slug'] = Str::slug($input['title']);
         try {
            $model = $this->postcategoryRepository->create($input);
            return redirect(route('postcategory.index'))->with('success', 'Tạo bài viết thành công!');
         } catch (Exception $e) {
            throw New Exception($e);
         }
        // $this->logingController->log('create', $model->getTable() , $model->id);
    } else {
        \App::abort(403);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $user = $this->postcategoryRepository->findOrFail($id);
        // return view('admin.postcategorys.show', compact('postcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->hasPermissionTo('edit danh muc bai viet')) {
        $postcategory = $this->postcategoryRepository->findOrFail($id);

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home.index')],
            ['title' => 'post Category', 'url' => route('postcategory.index')]
        ];
        $statusData = [
            [
                'name' => 'Ẩn',
                'value' => 0,
            ],
            [
                'name' => 'Hiện',
                'value' => 1,
            ],
        ];

        return view('admin.postcategorys.edit', compact('statusData', 'postcategory', 'breadcrumbs'));
    } else {
        \App::abort(403);
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(\Auth::user()->hasPermissionTo('edit danh muc bai viet')) {
            $model = $this->postcategoryRepository->findOrFail($id);
            $input = $request->except(['_token']);
            $input['slug'] = Str::slug($input['slug']);
            if (empty($model)) {
                return Redirect::back()->with('error', 'Not Found!');
            } else {
                try {
                    $this->postcategoryRepository->update($model, $input);
                    // $this->logingController->log('update' , $model->getTable() , $id);
                    return redirect()->route('postcategory.index')->with('success', 'Update successfully');
                } catch (Exception $e) {
                    throw New Exception($e);
                }
            }
        } else {
            \App::abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function destroy($id)
    {
        if(\Auth::user()->hasPermissionTo('delete danh muc bai viet')) {
        $postcategory = $this->postcategoryRepository->findOrFail($id);
        if (empty($postcategory)) {
            session()->flash('error', 'Not found user.');

            return ['error' => true];
        }
        try {
            // $this->logingController->log('delete' , $postcategory->getTable() , $id);
            $this->postcategoryRepository->delete($postcategory);

            session()->flash('success', 'Destroy successfully.');

            return ['error' => false];
        } catch (Exception $e) {
            throw new Exception($e);
        }
    } else {
        \App::abort(403);
    }

    }

    /**
     * @param $id
     * @return bool[]|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
}
