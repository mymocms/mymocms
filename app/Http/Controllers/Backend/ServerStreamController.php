<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServerStream;

class ServerStreamController extends Controller
{
    public function index() {
        return view('backend.server-stream.index');
    }
    
    public function form($id = null) {
        $model = ServerStream::firstOrNew(['id' => $id]);
        return view('backend.server-stream.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new')
        ]);
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = ServerStream::query();
        
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
            $row->edit_url = route('admin.server-stream.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'key' => 'required|string|max:32|unique:server_streams,key,'. $request->post('id'),
            'name' => 'required|string|max:250',
            'status' => 'required|in:0,1',
        ], $request, [
            'key' => trans('app.key'),
            'name' => trans('app.name'),
            'status' => trans('app.status'),
        ]);
        
        $id = $request->post('id');
        
        $model = ServerStream::firstOrNew(['id' => $id]);
        $model->fill($request->all());
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.server-stream'),
        ]);
    }
    
    public function publish(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
            'status' => 'required|in:0,1',
        ], $request, [
            'ids' => trans('app.server_stream'),
            'status' => trans('app.status'),
        ]);
        
        $ids = $request->post('ids');
        $status = $request->post('status');
        
        ServerStream::whereIn('id', $ids)
            ->update([
                'status' => $status,
            ]);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.updated_successfully'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.server_stream')
        ]);
        
        $ids = $request->post('ids');
        ServerStream::destroy($ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
