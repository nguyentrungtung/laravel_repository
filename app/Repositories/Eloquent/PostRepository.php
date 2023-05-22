<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\PostRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\throwException;

class PostRepository extends RelationModelRepository implements PostRepositoryInterface
{
    protected $querySearchTargets = [
        'title',
        'author',
        'summary',
        'label',
        'status',
    ];

    public function getBlankModel()
    {
        return new Post;
    }

    public function hotPost($type)
    {
        if ($type == null) {
            $model = $this->getBlankModel();
        }
        $model = $this->getBlankModel()->orderBy('updated_at', 'DESC')->where('label', 'LIKE', '%' . $type . '%')->load('parents')->get();

        return $model;
    }

    public function postType($id, $type, $limit)
    {
        if ($type == null && $limit == null && $limit == null) {
            $model = $this->getBlankModel();
        }
        $model = $this->getBlankModel()->orderBy('updated_at', 'DESC')->where('post_category_id', $id)->where('label', 'LIKE', '%' . $type . '%')->where('status', 1)->paginate($limit);

        return $model;
    }

    public function newPost($limit)
    {
        if ($limit == null) {
            $model = $this->getBlankModel();
        }

        $model = $this->getBlankModel()->orderBy('updated_at', 'DESC')->where('label', '=', 'new')->paginate($limit);

        return $model;
    }

    public function getDetailPost($slug)
    {
        if ($slug == null) {
            $model = $this->getBlankModel();
        }

        $model = $this->getBlankModel()
            ->Where('slug', 'LIKE', '%' . $slug . '%')->with('ratings')->first();

        return $model;
    }

    public function newss($id)
    {
     if ($id == null) {
            $model = $this->getBlankModel();
        }
    $model = DB::select('SELECT * FROM posts  WHERE post_category_id = ? LIMIT 3 OFFSET 0 ;', [$id]);

    return $model;
    }

    public function querySearch($data, $number)
    {
        if ($data == null) {
            $model = $this->getBlankModel();
        }
        try {
            $model = $this->getBlankModel()
                ->where('title', 'LIKE', '%' . $data . '%')
                ->orWhere('summary', 'LIKE', '%' . $data . '%')
                ->orWhere('author', 'LIKE', '%' . $data . '%')
                ->orWhere('seo_title', 'LIKE', '%' . $data . '%')
                ->orWhere('seo_description', 'LIKE', '%' . $data . '%')
                ->orWhere('seo_keyword', 'LIKE', '%' . $data . '%')
                ->orWhere('seo_canonical', 'LIKE', '%' . $data . '%')->paginate($number);

            return $model;
        } catch (Exception $e) {
            throwException($e);
        }
    }

    public function removeCheckbox($ids)
    {
        if (! $ids) {
            return;
        }
        $model = $this->getBlankModel()->whereIn('id', $ids)->delete();

        return $model;
    }
}
