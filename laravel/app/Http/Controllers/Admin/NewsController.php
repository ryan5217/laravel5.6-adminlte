<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    protected $fields = [
        'title' => '',
        'content' => '',
        'tag_name' => '',
        'link'=> '',
        'lang'=>'',
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
            $data_list = News::select();
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
        return view('admin.news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $news = new News();
        $news->title = $request -> get('title');
        $news->content = $request -> get('content');
        $news->tag_name = $request -> get('tag_name');
        $news->link = $request -> get('link');
        $news->lang = $request -> get('lang');
        $status = $news -> save();

        if ($status)
            return redirect('/admin/news/index') -> withSuccess('添加成功');
        else
            return redirect('/admin/news/index') -> withErrors('添加失败');
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
        $news = News::select() -> where('id',$id) -> first();
        if (empty($news))
            return back() -> withErrors('请重试');

        return view('admin.news.edit') -> with(['data' => $news]);
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
        $news = News::find($id);

        foreach (array_keys($this->fields) as $field){
            $news->$field = trim($request->get($field));
        }

        $status = $news -> save();

        if ($status)
            return redirect('admin/news/index')->withSuccess('修改成功！');
        else
            return back() -> withErrors('修改失败，请重试！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::destroy($id);

        if (!$news)
            return back() -> withErrors('删除失败');
        else
            return back() -> withSuccess('删除成功');
    }

    public function api($lang)
    {
        $lang = $lang ? $lang:1;
        $news = News::select() -> where('lang','=',$lang) -> orderBy('id','desc') -> paginate(8);
        if (!$news->total())
            return api_data(1,'暂无数据');
        return $news;
    }

    public function detail($id)
    {
        if (!$id)
            return api_data(1,'id is require');

        $detail = News::select() -> where('id','=',$id) -> first();

        if (empty($detail))
            return api_data(1,'not data');

        return $detail;
    }
}
