<?php

/**
 * Created by PhpStorm.
 * User: PC0353
 * Date: 4/21/2017
 * Time: 4:04 PM
 */
class Topic extends Eloquent
{
    protected $table = 'topic';

    protected $primaryKey = 'topic_id';

    public $timestamps = false;

    protected $fillable = array('topic_name', 'topic_status');


    public static function add($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new Topic();
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
            $dataSave = Topic::find($id);
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
            $dataSave = Topic::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function getListShow()
    {
        try {
            return Topic::where('topic_status', 1)->lists('topic_name', 'topic_id');
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

}