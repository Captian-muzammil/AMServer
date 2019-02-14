<?php namespace App\Libs\Platform\Storage\Order;

interface OrderRepository {
    public function all();	// method to fetch all entries

    public function conditions($filters, $query);	//method to create a conditions QueryBuilder

    public function count($filters);	// count of filtered list

    public function create($data);	// method to create a new entry

    public function datatables();	// method for datatables

    public function delete($id);	// method to delete an existing entry

    public function find($id);	// method to find an entry by id

    public function listing($limit, $active, $fields, $filters, $sort, $with, $page);	// method to fetch entries matching criteria

    public function messages();	// method to get validation messages

    public function rules($action, $id);	// method to get validation rules

    public function tabNavigation($id);	// method for dealing with the navigation tabs

    public function update($id, $data);	// method to update an existing entry


    public function view($id, $active, $fields, $with);

    public function node($tag);    // method to get entry by id along with other criterias
}
