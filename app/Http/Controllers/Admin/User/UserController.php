<?php

namespace App\Http\Controllers\Admin\User;

use App\Helpers\FormBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Repositories\UserRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use Exception;
use App\Models\User;
use Spatie\Permission\Models\Role;
// use App\Http\Controllers\Admin\Loging\LogingController;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /** @var App\Repositories\UserRepositoryInterface UserRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $userRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;
    // protected $logingController;
    /**
     * class UserController.
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        FileServices $fileServices,
        // LogingController $logingController
    ) {
        $this->userRepository = $userRepository;
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
//        if (\Auth::user()->hasPermissionTo('list user')) {
            $offset = $request->get('offset', '');
            $limit = $request->get('limit', 20);
            $order = $request->get('order', 'id');
            $direction = $request->get('direction', 'DESC');

            $queryWord = $request->get('query');

            $filter = [];
            if (! empty($queryWord)) {
                $filter['query'] = $queryWord;
            }

            $users = $this->userRepository->allByFilterPagination($filter, $limit, $order, $direction);

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'User', 'url' => route('user.index')]
            ];

            return view('admin.users.index', compact('users', 'breadcrumbs'));
//        } else {
//            \App::abort(403);
//        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //if (\Auth::user()->hasPermissionTo('add user')) {
        $title = 'Create';

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home.index')],
            ['title' => 'User', 'url' => route('user.index')],
            ['title' => 'User', 'url' => route('user.create')]
        ];

        $users = User::pluck('name', 'id')->all();

        $form = new FormBuilder();
        $form->addField('text', 'name', 'Tên');
        $form->addField('email', 'email', 'Email');
        $form->addField('password', 'password', 'Password');
        $form->addField('password', 'password_confirmation', 'Password confirmation');
        $form->addField('select', 'user_id', 'Select User', [
            'options' => $users,
            'multiple' => true,
        ]);
        $form->addField('radio', 'color', 'Color',
            [
                'choices' => [
                    'red' => 'Red',
                    'green' => 'Green',
                    'blue' => 'Blue',
                ],
                'id' => 'color_radio',
                'value' => 'red',
                'class' => 'minimal'
            ]
        );

        $form->addField('checkbox', 'color', 'Color',
            [
                'choices' => [
                    'red' => 'Red',
                    'green' => 'Green',
                    'blue' => 'Blue',
                ],
                'id' => 'color_radio',
                'value' => 'red',
                'class' => 'minimal'
            ]
        );

        $form->addField('submit', 'submit', 'submit', ['class' => 'btn btn-primary']);
        $formHtml = $form->render();

        $roles = Role::all();

        return view('admin.users.add', compact( 'title', 'breadcrumbs', 'formHtml', 'roles'));

//        } else {
//            \App::abort(403);
//        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        //if (\Auth::user()->hasPermissionTo('add user')) {
            try {
                $input = $request->only([
                    'name',
                    'email',
                    'phoneNumber',
                    'password',
                    'permission',
                ]);

                $model = $this->userRepository->create($input);
                $model->assignRole($request->permission);

                return redirect()->route('user.index')->with('success', 'Tạo Mới Thành Công!');

            } catch (Exception $e) {
                throw new Exception($e);
            }
//        } else {
//            \App::abort(403);
//        }
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
        $roles = Role::all();
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home.index')],
            ['title' => 'User', 'url' => route('user.index')]
        ];
        return view('admin.users.show', compact('user', 'roles','breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //if (\Auth::user()->hasPermissionTo('edit user')) {
            $user = $this->userRepository->findOrFail($id);

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'User', 'url' => route('user.index')]
            ];

            $form = new FormBuilder();
            $form->addField('text', 'name', 'Tên',['value' => $user->name]);
            $form->addField('email', 'email', 'Email', ['value' => $user->email]);
            $form->addField('password', 'password', 'Password');
            $form->addField('password', 'password_confirmation', 'Password confirmation');
            $form->addField('submit', 'submit', 'submit', ['class' => 'btn btn-primary']);
            $formHtml = $form->render();
            $roles = Role::all();
            return view('admin.users.edit', compact('user', 'breadcrumbs', 'formHtml','roles'));

//        } else {
//            \App::abort(403);
//        }
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
        //if (\Auth::user()->hasPermissionTo('edit user')) {
            if ($request->password) {
                $input = $request->only([
                    'name',
                    'email',
                    'password',
                ]);
            } else {
                if ($request->password) {
                    $input = $request->only([
                        'name',
                        'phoneNumber',
                        'password',
                        'permission',
                    ]);
                } else {
                    $input = $request->only([
                        'name',
                        'phoneNumber',
                        'permission',
                    ]);
                }
                $users = $this->userRepository->find($id);
                if (empty($users)) {

                    return Redirect::back()->with('error', 'not found.');

                }
                if ($request->permission == 'resetPermission') {
                    $users->syncRoles([]);
                } else {
                    $users->syncRoles($request->permission);
                }
                $this->userRepository->update($users, $input);
                // $this->logingController->log('update', $users->getTable(), $id);
                return redirect()->route('user.index')->with('success', 'Update successfully');
            }
        }
//        else {
//                \App::abort(403);
//            }
//        }

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
        //if (\Auth::user()->hasPermissionTo('delete user')) {
            $user = $this->userRepository->findOrFail($id);
            if (empty($user)) {
                session()->flash('error', 'Not found user.');

                return ['error' => true];
            }
            try {
                // $this->logingController->log('delete', $user->getTable(), $id);
                $this->userRepository->delete($user);

                session()->flash('success', 'Destroy successfully.');

                return ['error' => false];
            } catch (Exception $e) {
                throw new Exception($e);
            }
//        } else {
//            \App::abort(403);
//        }
    }

    /**
     * @return bool[]
     */
    public function profileUser($id)
    {

        $user = $this->userRepository->findOrFail($id);
        if (empty($user)) {
            session()->flash('error', 'not found user');

            return ['error' => true];
        }
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home.index')],
            ['title' => 'User', 'url' => route('user.index')]
        ];

        return view('admin.users.profile', compact('user', 'breadcrumbs'));
    }
}
