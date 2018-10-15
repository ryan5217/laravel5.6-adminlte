<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
            $data_list = User::select();
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
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 获取所有权限
        $roles = new RolesController();
        $permissions_all = $roles -> getCommlist();

        //获取所有角色
        $roles_all = Role::get()->toArray();

        return view('admin.user.create') -> with([
            'permissions_all' => $permissions_all,
            'roles_all' => $roles_all,
            'perms'=>['roles' => [],'permissions' => []]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $roles = $request -> get('roles');
        $permissions = $request -> get('permissions');

        // 给用户分配角色
        if (!empty($roles)){
            $role_r = Role::whereIn('id',$roles)->get();
            $user->assignRole($role_r);
        }

        if (!empty($permissions)){
            $permissions_p = Permission::whereIn('id',$permissions)->get();
            $user->givePermissionTo($permissions_p);
        }

        return redirect('/admin/user/index') -> withSuccess('添加成功');
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
        $user = User::find($id);

        $permissions = $user->permissions; //获取该用户直接获取的权限

        $perms = [
            'permissions'=>[],
            'roles'=>[]
        ];

        if (!empty($permissions)){
            foreach ($permissions as $v){
                $perms['permissions'][] = $v->id;
            }
        }

        $roles = $user -> roles; //获取该用户直接获取的角色

        if (!empty($roles)){
            foreach ($roles as $v){
                $perms['roles'][] = $v->id;
            }
        }

        // 获取所有权限
        $roles = new RolesController();
        $permissions_all = $roles -> getCommlist();

        //获取所有角色
        $roles_all = Role::get()->toArray();

        return view('admin.user.edit') -> with([
            'user' => $user,
            'perms' => $perms,
            'permissions_all' => $permissions_all,
            'roles_all' => $roles_all
        ]);
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
//        dd($request->toArray());
        $user = User::find($id);
        $user -> name = $request->get('name');
        $user -> email = $request -> get('email');
        $password = $request->get('password');
        if (!empty($password)){
            $user -> password = $password;
        }
        $user->save();

        $roles = $request->get('roles');
        if (!empty($roles)) {
            $user->roles()->sync($roles);  // 如果有角色选中与用户关联则更新用户角色
        } else {
            $user->roles()->detach(); // 如果没有选择任何与用户关联的角色则将之前关联角色解除
        }

        $permissions = $request->get('permissions');
        if (!empty($permissions)) {
            $user->permissions()->sync($permissions);  // 如果有角色选中与用户关联则更新用户角色
        } else {
            $user->permissions()->detach(); // 如果没有选择任何与用户关联的角色则将之前关联角色解除
        }

        return back() -> withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back() -> withSuccess('删除成功');
    }
}
