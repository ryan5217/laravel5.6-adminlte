<?php
//接收参数
if (!function_exists('returnTable'))
{
    function returnTable($request)
    {
        $data = [];
        $data['draw'] = $request->get('draw');
        $data['start'] = $request->get('start');
        $data['length'] = $request->get('length');
        $data['order'] = $request->get('order');
        $data['columns'] = $request->get('columns');
        $data['search'] = $request->get('search');
        return $data;
    }
}

/**
 * 二维数组去重
 * @var [type]
 */

if (!function_exists('array_unique_fb')) {
    function array_unique_fb($array2D){
        foreach ($array2D as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组

        $data = [];
        foreach ($temp as $k => $v){
            $data[]=explode(',',$v); //再将拆开的数组重新组装
        }
        return $data;
    }

}

if (!function_exists('api_data')) {

    function api_data($code,$msg,$data = []){
        $send['code'] = $code;
        $send['msg'] = $msg;
        if (empty($data)) return $send;
        $send['data'] = $data;
        return $send;
    }

}