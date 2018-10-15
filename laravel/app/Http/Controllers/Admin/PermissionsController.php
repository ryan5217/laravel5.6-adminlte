<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
    protected $fields = [
        'name' => '',
        'display_name' => '',
        'description' => '',
        'icon'=> '',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$pid=0)
    {
        if ($request->ajax()) {
            $where = returnTable($request);
            $search = $where['search']['value'];

            $data = [];
            $data_list = Permission::select()
            -> where(['pid' => $pid]);
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
        return view('admin.permissions.index') -> with(['pid'=>$pid]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($pid=0)
    {
        return view('admin.permissions.create')->with(['pid' => $pid]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$pid=0)
    {
        // 验证参数
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'display_name' => 'required'
        ],[
            'name.required' => '请输入权限规则',
            'display_name.required' => '请输入权限名'
        ]);

        if ($validator->fails()){
//            $errors = $validator->errors()->toArray();
//            $data = [];
//            foreach ($errors as $key => $value) {
//                $data[$key] = $value['0'];
//            }
//            return api_data(1,'errors',$data);
            return back()->withErrors($validator)->withInput();
        }

        // dd($request->toArray());
        $permission = new Permission();
        foreach (array_keys($this->fields) as $field) {
            $permission->$field = trim($request->get($field));
        }
        $permission->pid = (int)$pid;
        $permission->save();
        // Event::fire(new permChangeEvent());
        return redirect('/admin/permissions/index')->withSuccess('添加成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($request->ajax()) {
            $where = returnTable($request);
            $search = $where['search']['value'];

            $data = [];
            $data_list = Permission::select()
            -> where(['id' => $id]);
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
        return view('admin.permissions.index') -> with(['data'=>['id'=>$id]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Permission::where(['id'=>$id]) -> first();
        return view('admin.permissions.edit')->with(['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 验证参数
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'display_name' => 'required'
        ],[
            'name.required' => '请输入权限规则',
            'display_name.required' => '请输入权限名'
        ]);

        if ($validator->fails()){
//            $errors = $validator->errors()->toArray();
//            $data = [];
//            foreach ($errors as $key => $value) {
//                $data[$key] = $value['0'];
//            }
//            return api_data(1,'errors',$data);
            return back()->withErrors($validator)->withInput();
        }

        $permission = Permission::find($id);
        foreach (array_keys($this->fields) as $field) {
            $permission->$field = trim($request->get($field));
        }
        $permission -> save();

        return redirect('admin/permissions/index')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $child = Permission::where('pid', $id)->first();

        if ($child) {
            return redirect()->back()
                ->withErrors("请先将该权限的子权限删除后再做删除操作!");
        }
        $tag = Permission::find((int)$id);
        if ($tag) {
            $tag -> delete();
        } else {
            return redirect()->back()->withErrors("删除失败");
        }
        // Event::fire(new permChangeEvent());
        return redirect()->back()->withSuccess("删除成功");
    }
}
