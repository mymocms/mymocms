<?php

namespace Plugins\Movie\Http\Controllers\Backend;

use Plugins\Movie\Models\Movie\Movie;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Plugins\Movie\Models\DownloadLink;

class MovieDownloadController extends BackendController
{
    public function index($page_type, $movie_id) {
        $movie = Movie::findOrFail($movie_id);
        
        return view('movie::download.index', [
            'movie_id' => $movie_id,
            'movie' => $movie,
            'page_type' => $page_type,
            'title' => trans('movie::app.download_videos')
        ]);
    }
    
    public function form($page_type, $movie_id, $id = null) {
        $movie = Movie::findOrFail($movie_id);
        $model = DownloadLink::firstOrNew(['id' => $id]);
        
        return view('movie::download.form', [
            'movie_id' => $movie_id,
            'movie' => $movie,
            'page_type' => $page_type,
            'model' => $model,
            'title' => $model->lable ? $model->lable : trans('movie::app.add_new'),
        ]);
    }
    
    public function getData($page_type, $movie_id, Request $request) {
        Movie::findOrFail($movie_id);
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = DownloadLink::query();
        $query->where('movie_id', '=', $movie_id);
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('label', 'like', '%'. $search .'%');
                $subquery->orWhere('url', 'like', '%'. $search .'%');
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
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.movies.download.edit', [$page_type, $movie_id, $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($page_type, $movie_id, Request $request) {
        Movie::findOrFail($movie_id);
        
        $this->validateRequest([
            'label' => 'required|string|max:250',
            'url' => 'required|string|max:300',
            'order' => 'required|numeric|max:300',
            'status' => 'required|in:0,1',
        ], $request, [
            'label' => trans('movie::app.label'),
            'url' => trans('movie::app.url'),
            'order' => trans('movie::app.order'),
            'status' => trans('movie::app.status'),
        ]);
        
        $model = DownloadLink::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->movie_id = $movie_id;
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('movie::app.saved_successfully'),
            'redirect' => route('admin.movies.download', [$page_type, $movie_id]),
        ]);
    }
    
    public function remove($page_type, $movie_id, Request $request) {
        Movie::findOrFail($movie_id);
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('movie::app.subtitle')
        ]);
        
        DownloadLink::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('movie::app.deleted_successfully'),
        ]);
    }
}