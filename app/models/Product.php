<?php

/**
 * Created by JetBrains PhpStorm.
 * User: PC0353
 * Date: 4/17/2017
 * Time: 12:37 PM
 */
class Product extends Eloquent
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    public $timestamps = false;

    protected $fillable = array('product_name', 'product_code', 'product_status', 'product_store', 'category_id', 'product_avatar', 'product_image', 'product_policy', 'product_promotion', 'product_content','product_price','product_home');

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Product::where('product_id','>',0);
            if (isset($dataSearch['product_name']) && $dataSearch['product_name'] != '') {
                $query->where('product_name', 'LIKE', '%' . $dataSearch['product_name'] . '%');
            }
            if (isset($dataSearch['product_id']) && sizeof($dataSearch['product_id']) > 0) {
                $query->whereIn('product_id', $dataSearch['product_id']);
            }
            if (isset($dataSearch['product_code']) && sizeof($dataSearch['product_code']) > 0) {
                $query->whereIn('product_code', $dataSearch['product_code']);
            }
            if (isset($dataSearch['category_id']) && sizeof($dataSearch['category_id']) > 0) {
                $query->whereIn('category_id', $dataSearch['category_id']);
            }
            if (isset($dataSearch['product_home']) && $dataSearch['product_home'] >= 0) {
                $query->where('product_home', $dataSearch['product_home']);
            }
            if (isset($dataSearch['product_status']) && $dataSearch['product_status'] >= 0) {
                $query->where('product_status', $dataSearch['product_status']);
            }
            $total = $query->count();
            $query->orderBy('product_id', 'desc');
            return $query->take($limit)->skip($offset)->get();

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
            $data->save();
            DB::connection()->getPdo()->commit();
            return $data->product_id;
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

    public static function getProductSearch($keyword, $cate_id, $orderBy = '', $type = 'DESC', $offset = 0, $limit = 16, &$total){
        try {
            $query = Product::where('product_status', 1);
            $query->where(function($qu) use ($keyword)
            {
                $qu->where('product_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('product_code', $keyword)
                    ->orWhere('product_content', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('product_content', 'LIKE', '%' . $keyword . '%');
            });
            if(sizeof($cate_id) > 0){
                $query->whereIn('product_Category', $cate_id);
            }
            $total = $query->count();
            if ($orderBy != '') {
                $query->orderBy($orderBy, $type);
            }
            $data = $query->skip($offset)->take($limit)->get();
            return $data;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            throw new PDOException();
        }
    }

}