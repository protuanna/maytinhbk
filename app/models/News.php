<?php

/**
 * Created by PhpStorm.
 * User: PC0353
 * Date: 4/21/2017
 * Time: 10:50 AM
 */
class News extends Eloquent
{
    protected $table = 'news';

    protected $primaryKey = 'news_id';

    public $timestamps = false;

    protected $fillable = array('news_title', 'news_image', 'news_content', 'news_created', 'news_status', 'user_id', 'topic_id');

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = News::where('news_id','>',0);
            if (isset($dataSearch['news_title']) && $dataSearch['news_title'] != '') {
                $query->where('news_title', 'LIKE', '%' . $dataSearch['news_title'] . '%');
            }
            if (isset($dataSearch['news_status']) && $dataSearch['news_status'] >= 0) {
                $query->where('news_status', $dataSearch['news_status']);
            }
            if (isset($dataSearch['topic_id']) && $dataSearch['topic_id'] >= 0) {
                $query->where('topic_id', $dataSearch['topic_id']);
            }
            $total = $query->count();
            $query->orderBy('news_created', 'desc');
            return $query->take($limit)->skip($offset)->get();

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function add($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new News();
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
            $dataSave = News::find($id);
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
            $dataSave = News::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

}