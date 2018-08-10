<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\RoleHasPermissions;

class RolesController extends Controller
{
    protected $fields = [
        'name' => '',
        'display_name' => '',
        'description' => '',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $where = returnTable($request);
            $search = $where['search']['value'];

            $data = [];
            $data_list = Role::select();
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
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions_all = $this->getCommlist();
        return view('admin.roles.create') -> with(['permissions_all' => $permissions_all,'perms' => []]);
    }

    // 递归查询子集
    public function getCommlist($pid = 0){
        $result=[];
        $arr = Permission::where(['pid' => $pid]) -> get() ->toArray();

        if(empty($arr)){
            return array();
        }
        foreach ($arr as $v) {
            $thisArr = &$result[];
            $v["children"] = $this->getCommlist($v["id"]);
            $thisArr = $v;
        }
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         dd($request->toArray());
        $roles = new Role();
        foreach (array_keys($this->fields) as $field) {
            $roles->$field = trim($request->get($field));
        }
//        $roles->guard_name = 'admin';
        $roles->save();

        $permissions = $request['permissions'];

        if (!empty($permissions)) {
            // 遍历选择的权限
            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail(); 
                // 获取新创建的角色并分配权限
                $role = Role::where('id', '=', $roles->id)->first();
                $role -> givePermissionTo($p);
            }
        }

        return redirect('/admin/roles/index')->withSuccess('添加成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $roles = Role::findOrFail($id);
        $permissions_all = $this->getCommlist();
        //获取该角色有哪些权限.

        $has_permissions = RoleHasPermissions::select('permission_id')
            -> where(['role_id' => $id])
            -> get();
        $perms = [];
        foreach ($has_permissions as $k => $v){
            $perms[] = $v->permission_id;
        }

        return view('admin.roles.edit') -> with(['roles' => $roles,'permissions_all' => $permissions_all,'perms' =>$perms]);
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
        $role = Role::find($id);
        foreach (array_keys($this->fields) as $field) {
            $role->$field = trim($request->get($field));
        }
//        $role->guard_name = 'admin';
        $role->save();

        $p_all = Permission::all(); //获取所有权限
        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //移除与角色关联的所有权限
        }

        $permissions = $request['permissions'];

        if (!empty($permissions)) {
            // 遍历选择的权限
            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role -> givePermissionTo($p);
            }
        }

        return redirect('/admin/roles/index')->withSuccess('添加成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect('/admin/roles/index') -> withSuccess('删除成功');
    }
}
