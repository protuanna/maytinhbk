<?php

/**
 * Created by PhpStorm.
 * User: PC0353
 * Date: 4/17/2017
 * Time: 2:10 PM
 */
class Category extends Eloquent
{
    protected $table = 'category';

    protected $primaryKey = 'category_id';

    public $timestamps = false;

    protected $fillable = array('category_id', 'category_name', 'category_parent_id', 'category_status');

    public static function searchByCondition($dataSearch = array(), &$total)
    {
        try {
            $query = Product::where('category_id', '>', 0);
            if (isset($dataSearch['category_name']) && $dataSearch['category_name'] != '') {
                $query->where('category_name', 'LIKE', '%' . $dataSearch['category_name'] . '%');
            }
            if (isset($dataSearch['category_id']) && sizeof($dataSearch['category_id']) > 0) {
                $query->whereIn('category_id', $dataSearch['category_id']);
            }
            if (isset($dataSearch['category_status']) && $dataSearch['category_status'] >= 0) {
                $query->where('category_status', $dataSearch['category_status']);
            }
            $total = $query->count();
            $query->orderBy('product_id', 'desc');
            return $query->get();
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function add($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new Product();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->product_id;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function updData($id, $dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Product::find($id);
            if (!empty($dataInput)) {
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function delData($id)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Product::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

}