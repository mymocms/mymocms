<?php

namespace Plugins\Movie\Http\Controllers\Backend\LiveTV;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Plugins\Movie\Models\LiveTV\LiveTv;
use Plugins\Movie\Models\Category\Tags;

class LiveTvController extends BackendController
{
    public function index() {
        return view('movie::live-tv.index');
    }
    
    public function form($id = null) {
        $model = LiveTv::firstOrNew(['id' => $id]);
        $tags = Tags::whereIn('id', explode(',', $model->tags))->get(['id', 'name']);
        
        return view('movie::live-tv.form', [
            'model' => $model,
            'tags' => $tags,
            'title' => $model->name ?: trans('movie::app.add_new'),
        ]);
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = LiveTv::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
            });
        }
        
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->thumb_url = $row->getThumbnail();
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.live-tv.edit', [$row->id]);
            //$row->preview_url = route('watch', [$row->slug]);
            $row->stream_url = route('admin.live-tv.stream', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'description' => 'nullable',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
            'category_id' => 'nullable|exists:live_tv_categories,id',
        ], $request, [
            'name' => trans('movie::app.name'),
            'description' => trans('movie::app.description'),
            'status' => trans('movie::app.status'),
            'thumbnail' => trans('movie::app.thumbnail'),
            'category_id' => trans('movie::app.category'),
        ]);
    
        $tags = $request->post('tags', []);
        $tags = implode(',', $tags);
        
        $model = LiveTv::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->setAttribute('tags', $tags);
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('movie::app.saved_successfully'),
            'redirect' => route('admin.movies'),
        ]);
    }
    
    public function publish(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
            'status' => 'required',
        ], $request, [
            'ids' => trans('movie::app.live_tv'),
            'status' => trans('movie::app.status'),
        ]);
    
        $ids = $request->post('ids');
        $status = $request->post('status');
        
        LiveTv::whereIn('id', $ids)
            ->update([
                'status' => $status,
            ]);
    
        return response()->json([
            'status' => 'success',
            'message' => trans('movie::app.updated_successfully'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('movie::app.live_tv')
        ]);
    
        $ids = $request->post('ids');
        LiveTv::destroy($ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('movie::app.deleted_successfully'),
        ]);
    }
}