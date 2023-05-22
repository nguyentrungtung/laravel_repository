<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\CreateRequest;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Repositories\PostCategoryRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use App\Services\Production\FileServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\BackupPost;
// use App\Http\Controllers\Admin\Loging\LogingController;
// use App\Repositories\LogingRepositoryInterface;
// use App\Repositories\BackupPostRepositoryInterface;


class PostController extends Controller
{
    /** @var App\Repositories\postRepositoryInterface postRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $postRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;
    protected $postCategoryRepository;
    // protected $logingController;
    // protected $backupPostRepository;
    // protected $logingRepository;

    /**
     * class UserController.
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        FileServices $fileServices,
        PostCategoryRepositoryInterface $postCategoryRepository,
        // LogingController $logingController,
        // BackupPostRepositoryInterface $backupPostRepository,
        // LogingRepositoryInterface $logingRepository
    ) {
        $this->postRepository = $postRepository;
        $this->fileServices = $fileServices;
        $this->postCategoryRepository = $postCategoryRepository;
        // $this->logingController = $logingController;
        // $this->backupPostRepository = $backupPostRepository;
        // $this->logingRepository = $logingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Auth::user()->hasPermissionTo('list bai viet')) {
            $offset = $request->get('offset', '');
            $limit = $request->get('limit', 20);
            $order = $request->get('order', 'updated_at');
            $direction = $request->get('direction', 'DESC');
            $postCategories = $this->postCategoryRepository->getActivePostCategory();
            $category = $request->input('category');
            $status = $request->input('status');
            $query = $request->input('query');
            $filter = [];
            if (! empty($query) ) {
                $filter['query'] = $query;
            }
            if (empty($query) && empty($category) && empty($status)) {
                $posts = $this->postRepository->allByFilterPagination($filter, $limit, $order, $direction);
            } else {
                if (empty($filter)) {
                    $posts = Post::query()
                        ->when($category, function ($query, $category) use ($status) {
                            $query->whereHas('parent', function ($query) use ($category) {
                                $query->where('title', $category);
                            })->where('status', $status);
                        })
                        ->paginate(20);
                }
                if(!empty($filter)) {
                    dd(2222);
                    $posts = $this->postRepository->allByFilterPagination($filter, $limit, $order, $direction);
                }
            }
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'post', 'url' => route('post.index')]
            ];


            return view('admin.posts.index', compact('posts', 'breadcrumbs' , 'category', 'query' , 'status','postCategories'));
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
        if(\Auth::user()->hasPermissionTo('add bai viet')) {
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'post', 'url' => route('post.index')],
                ['title' => 'create', 'url' => route('post.create')],
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
        $postCategories = $this->postCategoryRepository->getActivePostCategory();

        return view('admin.posts.edit', compact('statusData', 'breadcrumbs', 'postCategories'));
    } else {
        \App::abort(403);
    }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        if(\Auth::user()->hasPermissionTo('add bai viet')) {
        $input = $request->except(['_token']);
        $input['info_admin'] = json_encode($input['info_admin']);
        $input['slug'] = Str::slug($input['title']);
        $input['meta_robot'] = json_encode($input['meta_robot']);
        try {
            $model = $this->postRepository->create($input);
            // $this->logingController->log('create', $model->getTable(), $model->id);
            return redirect(route('post.index'))->with('success', 'Tạo bài viết thành công!');
        } catch (Exception $e) {
            throw new Exception($e);
        }
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
        // $user = $this->postRepository->findOrFail($id);
        // return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->hasPermissionTo('edit bai viet')) {
        $post = $this->postRepository->findOrFail($id);

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home.index')],
            ['title' => 'post', 'url' => route('post.index')],
            ['title' => 'update', 'url' => route('post.edit' , ['post'=>$id])],
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
        $postCategories = $this->postCategoryRepository->getActivePostCategory();

        return view('admin.posts.edit', compact('statusData', 'post', 'breadcrumbs', 'postCategories'));
    } else {
        \App::abort(403);
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        if(\Auth::user()->hasPermissionTo('edit bai viet')) {
        $post = $this->postRepository->findOrFail($id);
        $input = $request->except(['_token']);
        $input['info_admin'] = json_encode($input['info_admin']);
        $input['meta_robot'] = json_encode($input['meta_robot']);
        $input['slug'] = Str::slug($input['slug']);
        $input['schema'] = json_decode($request->input('schema'), true);
        if (empty($post)) {
            return Redirect::back()->with('error', 'Not Found!');
        }

        try {
            // $postBackup = $this->backupPostRepository->getbackup($post->id);
            // if($postBackup != null) {
            //     $logs = $this->logingRepository->findOrFail($postBackup->log_id);
            //     $logs->delete();
            // }
            // $this->logingController->log('update' , $post->getTable() , $id);
            $this->postRepository->update($post, $request->all());
            return redirect()->route('post.index')->with('success', 'Update successfully');
        } catch (Exception $e) {
            throw new Exception($e);
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
        if(\Auth::user()->hasPermissionTo('delete bai viet')) {
        $user = $this->postRepository->findOrFail($id);
        if (empty($user)) {
            session()->flash('error', 'Not found user.');

            return ['error' => true];
        }
        try {
            $this->postRepository->delete($user);

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
     public function removeAll(Request $request)
     {
        if(\Auth::user()->hasPermissionTo('delete bai viet')) {
        $ids = $request->array_id;
        $model = $this->postRepository->removeCheckbox($ids);

        return response()->json(['status' => 'success']);
        } else {
            \App::abort(403);
        }
     }
}
