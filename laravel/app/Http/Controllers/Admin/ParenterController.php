<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 2018/9/5
 * Time: 15:57
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Parenters;
use Illuminate\Support\Facades\Validator;



class ParenterController extends  Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $where = returnTable($request);
            $search = $where['search']['value'];

            $data = [];
            $data_list = Parenters::select();
            if (strlen($search) > 0){
                // $data_list -> where('m.mobile_phone','like','%'.$search.'%');
            }
            $data['recordsTotal'] = $data['recordsFiltered'] = $data_list -> count();

            $data['data'] = $data_list-> skip($where['start'])
                -> take($where['length'])
                -> orderBy($where['columns'][$where['order'][0]['column']]['data'],$where['order'][0]['dir'])
                -> get()
                -> toArray();

            return response()->json($data);
        }
        return view('admin.parenters.index');

    }

    public function api(Request $request)
    {
        // 验证参数
        $validator = Validator::make($request->all(),[
            'nickname' => 'required',
//            'mobile' => 'required',
            'email' => 'required|email',
//            'company' => 'required',
            'position' => 'required',
            'detail' => 'required',
        ],[
            'nickname.required' => '请输入您的称呼',
//            'mobile.required' => '请输入电话号码',
            'email.required' => '请输入一个邮箱',
            'email.email' => '请输入一个正确的邮箱',
//            'company.required' => '请输入公司名',
            'position.required' => '请输入一个主题',
            'detail.required' => '请输入描述',
        ]);

        if ($validator->fails()){
            $errors = $validator->errors()->toArray();
            $error_data = [];
            foreach ($errors as $key => $value) {
                $error_data[$key] = $value['0'];
            }
            return api_data(1,'errors',$error_data);
        }

        $parent = new Parenters();
        $parent -> nickname = $request->nickname;
//        $parent -> mobile = $request->mobile;
        $parent -> email = $request->email;
//        $parent -> company = $request->mobile;
        $parent -> position = $request->position;
        $parent -> detail = $request->detail;

        $status = $parent -> save();

        if ($status){
            return api_data(0,'success');
        }

        return api_data(1,'errors 请重试');
    }
}