<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use URL;

class Menu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $menu = $this -> setMenu();
        view()->share(['menu'=>$menu['permissions'],'active' => $menu['urlpath']]);
        return $next($request);
    }

    public function setMenu()
    {
//        dd(URL::route('admin.roles.index'));
//        //查找并拼接出地址的别名值
        $path_arr = explode('/', \URL::getRequest()->path());
        if (isset($path_arr[1])) {
            $urlPath = $path_arr[0] . '.' . $path_arr[1] . '.index';
        } else {
            $urlPath = $path_arr[0] . '.index';
        }

        $user = Auth::user();

        $permissions_all = $user->getAllPermissions() -> groupBy('pid') ->toArray();

        if ($user->id === 1){
            $permissions_all = Permission::get() -> groupBy('pid') ->toArray();
        } else {
            $permissions_all = $user->getAllPermissions() -> groupBy('pid') ->toArray();
        }
        unset($permissions_all['0']);

        $permissions = [];
        foreach ($permissions_all as $k => $v){
            $permission = Permission::find($k);

            $menu_tag = [
                'display_name' => $permission->display_name,
                'url' => '#',
                'icon' => $permission->icon,
            ];
            $list = array();

            if (!empty($v)){
                foreach ($v as $vv){
                    if (strpos($vv['name'],'index')){
                        $list[] = [
                            'display_name' => $vv['display_name'],
                            'url' => URL::route($vv['name']),
                            'icon' => $vv['icon'],
                        ];
                    }
                }
            }
            if (!empty($list)){
                $menu_tag['list'] = $list;

                array_push($permissions,$menu_tag);
            }
        }
        return ['permissions' => $permissions,'urlpath' => URL::route($urlPath)];
    }
}
