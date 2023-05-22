<?php

namespace App\Http\Controllers\Admin\Log;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Repositories\LogRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use Exception;



class LogController extends Controller
{
    /** @var App\Repositories\{log}RepositoryInterface logRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $logRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{log}RepositoryInterface $logRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        LogRepositoryInterface $logRepository,
        FileServices $fileServices,
    ) {
        $this->logRepository = $logRepository;
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
        $direction = $request->get('direction','DESC');

        $queryWord = $request->get('query');


        $filter = [];
        if (!empty($queryWord)) {
            $filter['query'] = $queryWord;
        }
        $logs     = $this->logRepository->allByFilterPagination($filter, $limit, $order, $direction);
        $title     = 'Log';
        $subTile   = '';

        return view('admin.log.index', compact('logs', 'title', 'subTile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $log = $this->logRepository->findOrFail($id);
        if (empty($log)) {
            session()->flash('error', 'Not found user.');

            return ['error' => true];
        }
        try {
            $this->logRepository->delete($log);

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

