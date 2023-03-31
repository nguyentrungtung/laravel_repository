<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\ProvinceRepositoryInterface;
use App\Repositories\DistrictRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    /** @var App\Repositories\UserRepositoryInterface UserRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $userRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;


    /**
     * class UserController.
     *
     * @param UserRepositoryInterface $userRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        FileServices $fileServices,
    ) {
        $this->userRepository = $userRepository;
        $this->fileServices   = $fileServices;
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
        $direction = $request->get('direction');

        $queryWord = $request->get('query');

        $filter = [];
        if (!empty($queryWord)) {
            $filter['query'] = $queryWord;
        }

        $users     = $this->userRepository->allByFilterPagination($filter, $limit, $order, $direction);

        $title     = 'Users';
        $subTile   = '';

        return view('admin.users.index', compact('users', 'title', 'subTile'));
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
        return view('admin.users.edit', compact( 'title', 'subTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $input = $request->only([
            'name',
            'email',
            'password',
        ]);

        try {
            $this->userRepository->create($input);

            return redirect()->route('user.index')->with('success', 'Tạo Mới Thành Công!');
        } catch (Exception $e) {
            throw new Exception($e);
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
        $user = $this->userRepository->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findOrFail($id);

        $title = 'Edit';
        $subTitle = '';

        return view('admin.users.edit', compact('user',  'title', 'subTitle'));
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
        if ($request->password){
            $input = $request->only([
                'name',
                'password',
            ]);
        }else{
            $input = $request->only([
                'name',
            ]);
        }

        $users = $this->userRepository->find($id);

        if (empty($users)) {

            return Redirect::back()->with('error', 'not found.');

        }
        $this->userRepository->update($users, $input);

        return redirect()->route('user.index')->with('success', 'Update successfully');
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
        $user = $this->userRepository->findOrFail($id);
        if (empty($user)) {
            session()->flash('error', 'Not found user.');

            return ['error' => true];
        }
        try {
            $this->userRepository->delete($user);

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
    public function profileUser($id)
    {
        $user = $this->userRepository->findOrFail($id);
        if(empty($user)){
            session()->flash('error', 'not found user');
            return ['error' => true];
        }
        $title     = 'Users';
        $subTile   = '';
        return view('admin.users.profile', compact('user', 'title', 'subTile'));
    }
}
