<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class Product extends Eloquent
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    public $timestamps = false;

    protected $fillable = array('product_name', 'product_code', 'product_status', 'product_store', 'category_id', 'product_avatar', 'product_image', 'product_policy', 'product_promotion', 'product_content','product_price');

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Product::where('product_id','>',0);
            if (isset($dataSearch['product_name']) && $dataSearch['product_name'] != '') {
                $query->where('product_name', 'LIKE', '%' . $dataSearch['product_name'] . '%');
            }
            if (isset($dataSearch['product_id']) && sizeof($dataSearch['product_id']) > 0) {
                $query->whereIn('product_id', $dataSearch['product_id']);
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

    public static function getProductRelate($c_ids,$p_ids){
        try {
            //$product = Product::find($id);
            $query = Product::whereIn('product_Category',$c_ids);
            $query->where('product_Status', 1);
            $query->where('product_show_site', 1);
            $query->whereNotIn('product_id', $p_ids);
            //$query->where('product_NameUnit','LIKE','%'.$product->product_NameUnit.'%');
            return $query->take(8)->get();
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function getProductHome(){
        try {
            $query = Product::where('product_status', 1);
            return $query->get();
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function getProductByIds($ids)
    {
        try {
            $query = Product::whereIn('product_id', $ids);
            $query->where('product_Status', 1);
            $query->where('product_show_site', 1);
            return $query->get();
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function getListCateByIds($ids)
    {
        try {
            $query = Product::whereIn('product_id', $ids);
            $query->where('product_Status', 1);
            $query->where('product_show_site', 1);
            return $query->lists('product_Category');
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function getProductKm()
    {
        try {
            $query = Product::where('product_Status', 1);
            $query->where('product_show_site', 1);
            $query->where('product_landing_start', '<=', time());
            $query->where('product_landing_end', '>=', time());
            return $query->get();
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }


}