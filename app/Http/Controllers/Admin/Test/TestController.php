<?php

namespace App\Http\Controllers\Admin\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Repositories\TestRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Test\CreateRequest;
use App\Http\Requests\Test\UpdateRequest;
use Exception;


class TestController extends Controller
{
    /** @var App\Repositories\{test}RepositoryInterface testRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $testRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{test}RepositoryInterface $testRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        TestRepositoryInterface $testRepository,
        FileServices $fileServices,
    ) {
        $this->testRepository = $testRepository;
        $this->fileServices   = $fileServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Auth::user()->hasPermissionTo('list test'))
            $offset    = $request->get('offset', '');
            $limit     = $request->get('limit', 20);
            $order     = $request->get('order', 'id');
            $direction = $request->get('direction','DESC');

            $queryWord = $request->get('query');


            $filter = [];
            if (!empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $tests     = $this->testRepository->allByFilterPagination($filter, $limit, $order, $direction);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'test', 'url' => route('test.index')]
            ];
            return view('admin.tests.index', compact('tests' , 'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('add test'))
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'test', 'url' => route('test.index')],
                ['title' => 'test', 'url' => route('test.create')],
            ];
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
            return view('admin.test.edit', compact('statusData', 'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('add test'))
            $input = $request->except(['_token']);

            try {
                $model = $this->$testRepository->create($input);
                return redirect(route('test.index'))->with('success', 'Tạo bài viết thành công!');
            } catch(Exception $e) {
                throw New Exception($e);
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
        // $user = $this->testRepository->findOrFail($id);
        // return view('admin.test.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        if(\Auth::user()->hasPermissionTo('edit test'))
            $test = $this->testRepository->findOrFail($id);

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'test', 'url' => route('test.index')],
                ['title' => 'test', 'url' => route('test.edit' , ['test' => $id])],
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
            return view('admin.tests.edit', compact('statusData', 'test',  'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('edit test'))
            $model = $this->testRepository->findOrFail($id);
            if(empty($model) {
                return Redirect::back()->with('error', 'Not Found!');
            } else {
                try {
                $this->testRepository->update($model, $input)
                    return redirect()->route('test.index')->with('success', 'Update successfully');
                } catch(\Exception $e) {
                    throw new Exception($e);
                }
            }
        } else {
            \App::abort(403);
        }
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
        if(\Auth::user()->hasPermissionTo('delete test'))
            $test = $this->testRepository->findOrFail($id);
            if (empty($test)) {
                session()->flash('error', 'Not found user.');

                return ['error' => true];
            }
            try {
                $this->testRepository->delete($test);

                session()->flash('success', 'Destroy successfully.');

                return ['error' => false];
            } catch (Exception $e) {
                throw new Exception($e);
            }
        } else {
            \App::abort(403);
        }
    }
}

