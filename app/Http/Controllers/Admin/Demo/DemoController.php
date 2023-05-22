<?php

namespace App\Http\Controllers\Admin\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Demo;
use App\Repositories\DemoRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use Exception;



class DemoController extends Controller
{
    /** @var App\Repositories\{demo}RepositoryInterface demoRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $demoRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{demo}RepositoryInterface $demoRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        DemoRepositoryInterface $demoRepository,
        FileServices $fileServices,
    ) {
        $this->demoRepository = $demoRepository;
        $this->fileServices   = $fileServices;
        $this->middleware('log');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset    = $request->get('offset', '');
        $limit     = $request->get('limit', 20);
        $order     = $request->get('order', 'id');
        $direction = $request->get('direction','DESC');

        $queryWord = $request->get('query');


        $filter = [];
        if (!empty($queryWord)) {
            $filter['query'] = $queryWord;
        }
        $demos     = $this->demoRepository->allByFilterPagination($filter, $limit, $order, $direction);
        $title     = 'Demo';
        $subTile   = '';

        return view('admin.demo.index', compact('demos', 'title', 'subTile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create';
        $subTitle = '';
        $statusData = [
            [
                'name' => 'Hiện',
                'value' => 1,
            ],
            [
                'name' => 'Ẩn',
                'value' => 0,
            ]
        ];
        return view('admin.demo.edit', compact('statusData', 'title', 'subTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'thumbnail' => 'required',
            'author' => 'required',
            'label' => 'required',
            'description' => 'required',
            'status' => 'required',
            'seo_title' => 'required',
            'seo_description' => 'required',
            'seo_keyword' => 'required',
            'seo_canonical' => 'required',
        ]);

        $model = new Demo();
        $model->title = $data['title'];
        $model->summary = $data['summary'];
        $model->thumbnail = $data['thumbnail'];
        $model->author = $data['author'];
        $model->label = $data['label'];
        $model->description = $data['description'];
        $model->status = $data['status'];
        $model->seo_title = $data['seo_title'];
        $model->seo_description = $data['seo_description'];
        $model->seo_keyword = $data['seo_keyword'];
        $model->seo_canonical = $data['seo_canonical'];
        $model->save();
        return redirect(route('demo.index'))->with('success', 'Tạo bài viết thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $user = $this->demoRepository->findOrFail($id);
        // return view('admin.demo.show', compact('demo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $demo = $this->demoRepository->findOrFail($id);

        $title = 'Edit';
        $subTitle = '';
        $statusData = [
            [
                'name' => 'Hiện',
                'value' => 1,
            ],
            [
                'name' => 'Ẩn',
                'value' => 0,
            ]
        ];
        return view('admin.demo.edit', compact('statusData', 'demo',  'title', 'subTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'thumbnail' => 'required',
            'author' => 'required',
            'description' => 'required',
            'status' => 'required',
            'label' => 'required',
            'seo_title' => 'required',
            'seo_description' => 'required',
            'seo_keyword' => 'required',
            'seo_canonical' => 'required',
        ]);

        $model = $this->demoRepository->findOrFail($id);
        $model->title = $data['title'];
        $model->summary = $data['summary'];
        $model->thumbnail = $data['thumbnail'];
        $model->author = $data['author'];
        $model->description = $data['description'];
        $model->status = $data['status'];
        $model->label = $data['label'];
        $model->seo_title = $data['seo_title'];
        $model->seo_description = $data['seo_description'];
        $model->seo_keyword = $data['seo_keyword'];
        $model->seo_canonical = $data['seo_canonical'];
        $model->save();

        return redirect()->route('demo.index')->with('success', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $demo = $this->demoRepository->findOrFail($id);
        if (empty($demo)) {
            session()->flash('error', 'Not found user.');

            return ['error' => true];
        }
        try {
            $this->demoRepository->delete($demo);

            session()->flash('success', 'Destroy successfully.');

            return ['error' => false];
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param $id
     * @return bool[]|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
}

