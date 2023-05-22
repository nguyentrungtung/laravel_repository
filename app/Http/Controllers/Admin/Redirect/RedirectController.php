<?php

namespace App\Http\Controllers\Admin\Redirect;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Redirect;
use App\Http\Requests\Admin\Redirect\CreateRequest;
use App\Http\Requests\Admin\Redirect\UpdateRequest;
use Exception;
use App\Repositories\RedirectRepositoryInterface;
// use App\Http\Controllers\Admin\Loging\LogingController;
use DB;

class RedirectController extends Controller
{
    protected $redirectRepository   ;
    // protected $logingController;
    public function __construct(
        RedirectRepositoryInterface $redirectRepository,
        // LogingController $logingController,
    ){
        $this->redirectRepository = $redirectRepository;
        // $this->logingController = $logingController;
    }
    public function index(Request $request)
    {
        if(\Auth::user()->hasPermissionTo('list lien ket link')) {
        $offset = $request->get('offset', '');
        $limit = $request->get('limit', 20);
        $order = $request->get('order', 'id');
        $direction = $request->get('direction', 'DESC');

        $queryWord = $request->get('query');

        $filter = [];
        if (! empty($queryWord)) {
            $filter['query'] = $queryWord;
        }
        $redirects = $this->redirectRepository->allByFilterPagination($filter, $limit, $order, $direction);
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home.index')],
            ['title' => 'redirect', 'url' => route('redirect.index')]
        ];
        return view('admin.redirect.index', compact('redirects', 'breadcrumbs'));
    } else {
        \App::abort(403);
    }
    }
    public function store(CreateRequest $request)
    {
        if(\Auth::user()->hasPermissionTo('add lien ket link')) {
            $input = $request->except(['_token']);
            try {
                $model = $this->redirectRepository->create($input);
                // $this->logingController->log('create', $model->getTable() , $model->id);
                return redirect(route('redirect.index'))->with('success', 'Tạo địa chỉ thành công!');
            } catch (Exception $e) {
                throw New Exception($e);
            }
    } else {
        \App::abort(403);
    }
    }
    public function destroy($id)
    {
        if(\Auth::user()->hasPermissionTo('delete lien ket link')) {
        $redirect = $this->redirectRepository->findOrFail($id);
        if (empty($redirect)) {
            session()->flash('error', 'Not found redirect.');

            return ['error' => true];
        }
        try {
            $this->redirectRepository->delete($redirect);

            session()->flash('success', 'Destroy successfully.');

            return ['error' => false];
        } catch (Exception $e) {
            throw new Exception($e);
        }
    } else {
        \App::abort(403);
    }
    }
    public function upgrate(UpdateRequest $request)
    {
        if(\Auth::user()->hasPermissionTo('edit lien ket link')) {
        $model = $this->redirectRepository->findOrFail($request->id);
        $input = $request->except(['_token']);
        if (empty($model)) {
            return Redirect::back()->with('error', 'Not Found!');
        } else {
            try {
                // $this->logingController->log('update', $model->getTable(), $request->id);
                $this->redirectRepository->update($model, $input);
                return response()->json(['status'=>'success']);
            } catch (\Exception $e) {
                throw New Exception($e);
             }
        }
    } else {
        \App::abort(403);
    }
    }
    public function removeAll(Request $request)
     {
        if(\Auth::user()->hasPermissionTo('delete lien ket link')) {
        $ids = $request->array_id;
        $model = $this->redirectRepository->removeCheckbox($ids);
        return response()->json(['status' => 'success']);
    } else {
        \App::abort(403);
    }
    }
     public function redirect($slug)
     {
         $redirect = Redirect::where('old_link', $slug)->where('status', 1)->first();
         if ($redirect) {
             $newLink = $redirect->new_link;
             $redirectStatus = $redirect->redirect_status;
             $status = $redirect->status;

             if ($redirectStatus >= 300 && $redirectStatus <= 307) {
                 return redirect()->to($newLink, $redirectStatus);
             } else {
                 return redirect()->to($newLink, 302);
             }
         }

         abort(404);
     }
}
