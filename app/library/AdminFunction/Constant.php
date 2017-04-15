<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/15/2016
 * Time: 10:33 AM
 */
class Constant
{
    const dir_banner = 'uploads/banner/';
    const dir_news = 'uploads/news/';
    const dir_group_category = 'uploads/groupcategory/';
    const dir_product = 'uploads/product/';
    const dir_price = 'uploads/price/';

    public static $sort = array(
        'new' => array(
            'label' => 'Mới nhất',
            'field' => 'product_id',
            'type' => 'DESC'
        ),
        'name-az' => array(
            'label' => 'Tên(A - Z)',
            'field' => 'product_Name',
            'type' => 'ASC'
        ),
        'name-za' => array(
            'label' => 'Tên(Z - A)',
            'field' => 'product_Name',
            'type' => 'DESC'
        ),
        'price-az' => array(
            'label' => 'Giá(Thấp - Cao)',
            'field' => 'product_Price',
            'type' => 'ASC'
        ),
        'price-za' => array(
            'label' => 'Giá(Cao - Thấp)',
            'field' => 'product_Price',
            'type' => 'DESC'
        ),
    );

    public static $limit = array(16, 20, 40, 60, 80);

}