<?php

namespace App\Http\Controllers;

use App\Interfaces\CrudInterface;
use App\Traits\EventsTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, EventsTrait;

    public CrudInterface $model;
    public QueryBuilder $builder;
    public array $self = []; // ['id' => auth()->id()]
    public array $unique = [];
    public array $scopes = [];
    public array $includes = [];
    public array $ability = []; // update, delete, create, view, viewAny


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function setSelf(): void
    {
        $this->self = [];
    }

    public function index(Request $request): JsonResponse
    {
        //        ob_start('ob_gzhandler');
        $this->setSelf();
        if (in_array('viewAny', $this->ability)) {
            $this->authorizeForUser($request->user('api'), 'viewAny', $this->model);
        }

        $allowed = array_merge($this->model->getFillable(), $this->scopes);
        $queryBuilder = QueryBuilder::for($this->model::class)->allowedFilters($allowed);
        if (count($this->includes) > 0) {
            $queryBuilder->allowedIncludes($this->includes);
        }
        $this->builder = $queryBuilder;

        if (!empty($request->get('with'))) {
            $with = explode(',', $request->get('with'));
            $this->builder->with($with);
        }

        if (!empty($request->get('limit'))) {
            $this->builder->limit($request->get('limit'));
        }

        if (!empty($request->get('group_by'))) {
            $this->builder->groupBy($request->get('group_by'));
        }

        if (!empty($request->get('order_by'))) {
            $orderBy = explode(':', $request->get('order_by'));
            $this->builder->orderBy($orderBy[0], $orderBy[1]);
        }

        if (!empty($request->get('where'))) {
            $where = explode(':', $request->get('where'));
            $this->builder->where($where[0], $where[1]);
        }

        if (!empty($this->self)) {
            $this->builder->where($this->self[0], $this->self[1]);
        }

        if (!empty($request->get('group_by_model'))) {
            if (!empty($request->get('page'))) {
                $paginator = $this->builder->paginate(10);
                $data = $paginator->getCollection();
                $paginator->setCollection($data->groupBy($request->get('group_by_model')));

                return response()->json($paginator);
            }
            return response()->json($this->builder->get()->groupBy($request->get('group_by_model')));
        }

        if (!empty($request->get('page'))) {
            return response()->json($this->builder->paginate(10));
        }

        if (!empty($this->builder)) {
            return response()->json($this->builder->get());
        }

        return response()->json($this->model::all());
    }

    /**
     * @param Request $request
     * @param FormRequest|null $validationClass
     * @return CrudInterface|JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request, ?FormRequest $validationClass = null): CrudInterface|JsonResponse
    {
        if (in_array('create', $this->ability)) {
            $this->authorizeForUser($request->user('api'), 'create', $this->model);
        }

        if ($validationClass) {
            $validator = Validator::make($request->all(), $validationClass->rules(), $validationClass->messages());

            if ($validator->fails()) {
                return response()->json($validator->getMessageBag(), 403);
            }
        }

        $this->beforeStore($this->model);
        if (count($this->unique) == 0) {
            $this->model->fill($request->all());
            $this->model->save();
            $this->afterStore($this->model);
        } else {
            $uniq = auth()->user()->only($this->unique);

            $model = $this->model->firstWhere($uniq)?->toArray();
            if (!empty($model)) {
                $this->model->fill($model);
                $this->model->id = $model['id'];
            } else {
                $fields = $request->all();
                $model = new $this->model;
                $model->fill($fields);
                $this->beforeStore($model);
                $model->save();
                $this->afterStore($model);
                $this->model = $model;
            }
        }

        return $this->model;
    }

    /**
     * @param Request $request
     * @return CrudInterface
     * @throws \Exception
     */
    public function show(Request $request): CrudInterface
    {
        ob_start('ob_gzhandler');
        $key = $this->getKey();
        if (!empty($request->get('with'))) {
            $with = explode(',', $request->get('with'));
            $obj = $this->model->with($with)->find($request->$key);
        } else {
            $obj = $this->model->find($request->$key);
        }
        if (empty($obj)) {
            throw new \Exception($key . ' não encontrado', 404);
        }
        if (in_array('view', $this->ability)) {
            $this->authorizeForUser($request->user('api'), 'view', $obj);
        }
        return $obj;
    }

    /**
     * @param Request $request
     * @return CrudInterface
     * @throws \Exception
     */
    public function update(Request $request): CrudInterface|JsonResponse
    {
        if (in_array('update', $this->ability)) {
            $this->authorizeForUser($request->user('api'), 'update', $this->model);
        }
        $key = $this->getKey();
        $obj = $this->model->find($request->$key);
        if (empty($obj)) {
            throw new \Exception($key . ' não encontrado', 404);
        }
        $this->beforeUpdate($obj);
        $obj->fill($request->all())->save();
        $this->afterUpdate($obj);
        return $obj;
    }

    /**
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function destroy(Request $request): bool|JsonResponse
    {
        if (in_array('delete', $this->ability)) {
            $this->authorizeForUser($request->user('api'), 'delete', $this->model);
        }
        $key = $this->getKey();
        $obj = $this->model->find($request->$key);
        if (empty($obj)) {
            throw new \Exception($key . ' não encontrado', 404);
        }

        $this->beforeDestroy($obj);
        $destroy = $obj->delete();
        $this->afterDestroy($obj);

        return $destroy;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        $class = (new \ReflectionClass($this->model))->getName();
        $keys = explode('\\', $class);

        return $this->camelToSnake($keys[count($keys) - 1]);
    }

    private function camelToSnake($input): string
    {
        $pattern = '/([a-z])([A-Z])/';
        $replacement = '$1_$2';

        return strtolower(preg_replace($pattern, $replacement, $input));
    }
}
