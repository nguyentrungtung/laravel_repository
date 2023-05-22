<?php

namespace App\Http\Controllers\Admin\PostComment;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use App\Repositories\PostCommentRepositoryInterface;
use App\Services\Production\FileServices;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
// use App\Http\Controllers\Admin\Loging\LogingController;
class PostCommentController extends Controller
{
    /** @var App\Repositories\{postcomment}RepositoryInterface postcommentRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $postcommentRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;
    // protected $logingController;
    /**
     * class UserController.
     *
     * @param \{postcomment}RepositoryInterface $postcommentRepository
     */
    public function __construct(
        PostCommentRepositoryInterface $postcommentRepository,
        FileServices $fileServices,
        // // LogingController $logingController,
    ) {
        $this->postcommentRepository = $postcommentRepository;
        $this->fileServices = $fileServices;
        // // $this -> logingController = $logingController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Auth::user()->hasPermissionTo('list binh luan bai viet')) {
            $offset = $request->get('offset', '');
            $limit = $request->get('limit', 20);
            $order = $request->get('order', 'id');
            $direction = $request->get('direction', 'DESC');

            $queryWord = $request->get('query');

            $filter = [];
            if (! empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $postcomments = $this->postcommentRepository->allByFilterPagination($filter, $limit, $order, $direction);

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'post comment', 'url' => route('postcomment.index')]
            ];

            return view('admin.postcomments.index', compact('postcomments', 'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('add binh luan bai viet')) {
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'post comment', 'url' => route('postcomment.index')],
                ['title' => 'create comment', 'url' => route('postcomment.create')],
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

        return view('admin.postcomments.edit', compact('statusData', 'breadcrumbs'));
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
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'title' => 'required',
    //         'summary' => 'required',
    //         'thumbnail' => 'required',
    //         'author' => 'required',
    //         'label' => 'required',
    //         'description' => 'required',
    //         'status' => 'required',
    //         'seo_title' => 'required',
    //         'seo_description' => 'required',
    //         'seo_keyword' => 'required',
    //         'seo_canonical' => 'required',
    //     ]);

    //     $model = new PostComment();
    //     $model->title = $data['title'];
    //     $model->summary = $data['summary'];
    //     $model->thumbnail = $data['thumbnail'];
    //     $model->author = $data['author'];
    //     $model->label = $data['label'];
    //     $model->description = $data['description'];
    //     $model->status = $data['status'];
    //     $model->seo_title = $data['seo_title'];
    //     $model->seo_description = $data['seo_description'];
    //     $model->seo_keyword = $data['seo_keyword'];
    //     $model->seo_canonical = $data['seo_canonical'];
    //     $model->save();
    //     return redirect(route('postcomment.index'))->with('success', 'Tạo bài viết thành công!');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $user = $this->postcommentRepository->findOrFail($id);
        // return view('admin.postcomments.show', compact('postcomment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->hasPermissionTo('edit binh luan bai viet')) {
        $postcomment = $this->postcommentRepository->findOrFail($id);

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home.index')],
            ['title' => 'post comment', 'url' => route('postcomment.index')],
            ['title' => 'update comment', 'url' => route('postcomment.edit')],
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

        return view('admin.postcomments.edit', compact('statusData', 'postcomment', 'breadcrumbs'));

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
        if(\Auth::user()->hasPermissionTo('edit binh luan bai viet')) {
        $data = $request->all();

        $admin = auth()->user();
        $today = new DateTime;

        $updateRepcommentTime = $today->format(' H:i:s');
        if ($request->rep) {
            $rep[] = [
                'id' => $admin->id,
                'author' => $admin->name,
                'email' => $admin->email,
                'comment' => $request->rep,
                'updated' => $updateRepcommentTime,
            ];
            $rep = json_encode($rep);
        } else {
            $rep = null;
        }
        $model = $this->postcommentRepository->findOrFail($id);
        $model->rep = $rep;
        $model->email = $data['email'];
        $model->author = $data['author'];
        $model->comment = $data['comment'];
        $model->status = $data['status'];
        $model->save();
        // $this->logingController->log('update', $model->getTable() , $id);
        return redirect()->route('postcomment.index')->with('success', 'Update successfully');
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
        if(\Auth::user()->hasPermissionTo('delete binh luan bai viet')) {
        $postcomment = $this->postcommentRepository->findOrFail($id);
        if (empty($postcomment)) {
            session()->flash('error', 'Not found user.');

            return ['error' => true];
        }
        try {
            // $this->logingController->log('delete', $postcomment->getTable(), $id);
            $this->postcommentRepository->delete($postcomment);

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
