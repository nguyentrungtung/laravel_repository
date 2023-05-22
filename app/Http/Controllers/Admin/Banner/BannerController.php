<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Repositories\BannerRepositoryInterface;
use App\Services\Production\FileServices;
use App\Http\Requests\Admin\Banner\CreateRequest;
use App\Http\Requests\Admin\Banner\UpdateRequest;
// use App\Http\Controllers\Admin\Loging\LogingController;
use Exception;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /** @var App\Repositories\{banner}RepositoryInterface bannerRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $bannerRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;
    protected $logingController;
    /**
     * class UserController.
     *
     * @param \{banner}RepositoryInterface $bannerRepository
     */
    public function __construct(
        BannerRepositoryInterface $bannerRepository,
        FileServices $fileServices,
        // LogingController $logingController,
    ) {
        $this->bannerRepository = $bannerRepository;
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
        // if (\Auth::user()->hasPermissionTo('list banner')) {
            $offset = $request->get('offset', '');
            $limit = $request->get('limit', 20);
            $order = $request->get('order', 'updated_at');
            $direction = $request->get('direction', 'DESC');

            $queryWord = $request->get('query');

            $filter = [];
            if (! empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $banners = $this->bannerRepository->allByFilterPagination($filter, $limit, $order, $direction);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'Banner', 'url' => route('banner.index')]
            ];

            return view('admin.banners.index', compact('banners', 'breadcrumbs'));
        // } else {
        //     \App::abort(403);
        // }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(\Auth::user()->hasPermissionTo('add banner')) {

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'Banner', 'url' => route('banner.index')]
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

            return view('admin.banners.edit', compact('statusData', 'breadcrumbs'));
        // } else {
        //     \App::abort(403);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        if(\Auth::user()->hasPermissionTo('add banner')) {
            $input = $request->except(['_token']);

            if ($input['view'] != null) {
                $input['view'] = json_encode($input['view']);
            } else {
                $input['view'] = null;
            }
            try {
                $model = $this->bannerRepository->create($input);
                // $id = $model->id;
                // $this->logingController->log('create', $model->getTable(), $id);
                return redirect(route('banner.index'))->with('success', 'Tạo bài viết thành công!');
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
        // $user = $this->bannerRepository->findOrFail($id);
        // return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->hasPermissionTo('edit banner')) {
            $banner = $this->bannerRepository->findOrFail($id);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'Banner', 'url' => route('banner.index')]
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

            return view('admin.banners.edit', compact('statusData', 'banner', 'breadcrumbs'));
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
    public function update(UpdateRequest $request, $id)
    {
        if (\Auth::user()->haspermissionTo('edit banner')) {
            $input = $request->except(['_token']);

            if ($input['view'] != null) {
                $input['view'] = json_encode($input['view']);
            } else {
                $input['view'] = null;
            }
            try {
                $model = $this->bannerRepository->findOrFail($id);
                $this->bannerRepository->update($model, $input);
                // $this->logingController->log('update', $model->getTable(), $id);
                return redirect()->route('banner.index')->with('success', 'Update successfully');
            } catch(Exception $e) {
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
        if(\Auth::user()->hasPermissionTo('delete banner')) {
            $model = $this->bannerRepository->findOrFail($id);
            if (empty($model)) {
                session()->flash('error', 'Not found user.');

                return ['error' => true];
            }
            try {
                // $this->logingController->log('delete', $model->getTable(), $id);
                $this->bannerRepository->delete($model);

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
