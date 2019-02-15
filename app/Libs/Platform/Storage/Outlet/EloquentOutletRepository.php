<?php namespace App\Libs\Platform\Storage\Outlet;

use App\Model\Outlet;
use Exception;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;

class EloquentOutletRepository implements OutletRepository {
    protected $model;

    /**
     * Contructor method
     *
     * @param Tag $model
     */
    public function __construct(Outlet $model) {
        $this->model = $model;
    }

    /**
     * Method to fetch all the entries from the table
     *
     * @return collection
     */
    public function all() {
        return $this->model->all();
    }

    /**
     * Method to create a conditions QueryBuilder
     *
     * @param array $filters : array of filters
     * @param QueryBuilder $query
     * @return App\Models\User QueryBuilder
     */
    public function conditions($filters=[], $query=null) {
        if (!$query) {
            $query = $this->model->newQuery();
        }

        return $query;
    }

    /**
     * Count of filtered list
     *
     * @param boolean $active
     * @param array $filters
     * @return  integer
     */
    public function count($filters=[]) {
        $query = $this->model->newQuery();

        if ($filters) {
            $query = $this->conditions($filters, $query);
        }

        return $query->count();
    }

    /**
     * Method to create an entry into the database
     *
     * @param array $data : array containing the new entry's data
     * @return App\Models\User
     */
    public function create($data) {
    	// sanitize the data

        return $this->model->create($data);
    }

    /**
     * Method for datatables
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function datatables() {
        $result = $this->model->select([
                'id','name'
            ]);



        return Datatables::of($result)->make();
    }

    /**
     * Method to delete an existing entry from the database
     *
     * @param int $id : id of the entry
     * @return boolean
     */
    public function delete($id) {
        $resource = $this->find($id);
        return $resource->delete();
    }

    /**
     * Method to fetch and return a particular record from the table by 'id'
     *
     * @param int $id : id of the entry
     * @return App\Models\User
     */
    public function find($id) {
        return $this->model->find($id);
    }



    /**
     * Get a paginated listing
     *
     * @param int $limit
     * @param boolean $active
     * @param array $fields
     * @param array $filters
     * @param array $sort
     * @param array $with
     * @param int $page
     * @return collection
     */
    public function listing($limit=25, $active=true, $fields=[], $filters=[], $sort=['id'], $with=[], $page=0) {
        $order = 'ASC';	// default query sorting order
        $query = $this->model->newQuery();

        if (!$fields) {
            $fields = ['*'];
        }
        if ($filters) {
            $query = $this->conditions($filters, $query);
        }

        if ($with) {
            $with = $this->model->processWithSelects($with);
            $query->with($with);
        }

        /* Sorts */
        foreach ($sort as $key=>$val) {
            if (is_string($key)) { $query->orderBy($key, $val); }
            else { $query->orderBy($val); }
        }
        /* Sorts */

        /* Pagination */
        if ($limit) {
            if (!$page) { $page = Input::has('page') ? abs(Input::get('page')) : 1; }
            $skip = ($page - 1) * $limit;
            $query->take($limit)->skip($skip);
        }
        /* Pagination */

        return $query->get($fields);
    }

    /**
     * Method to update an existing entry in the database
     *
     * @param int $id : id of the entry
     * @param array $data : array containing the entry's updated data
     * @return App\Models\User
     */
    public function update($id, $data) {// sanitize the data

        $resource = $this->model->find($id);

        if ($resource->update($data)) { return $resource; }
        return false;
    }


    /**
     * Method to fetch an entry along with the respective data based on the criteria
     *
     * @param int $id
     * @param boolean $active
     * @param array $fields
     * @param array $with
     * @return App\Models\User
     * @throws Exception
     */
    public function view($id, $active=true, $fields=[], $with=[]) {
        $query = $this->model->newQuery();

        if (!$fields) {
            $fields = ['*'];
        }
        if ($with) {
            $with = $this->model->processWithSelects($with);
            $query->with($with);
        }

        try {
            return $query->where('id', '=', $id)->first($fields);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }


    public function node($model) {
        $response = null;

        if (!is_object($model)) {
            $model= $this->find($model);
        }
        if ($model) {
            $response = [
                'id' => $model->id,
                'name' => $model->name
            ];
        }
        return $response;
    }

}
