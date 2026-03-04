<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Copy\Store;
use App\Http\Requests\Admin\Copy\Update;
use App\Models\Copy ;
use App\Traits\ReportTrait;


class CopyController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $copys = Copy::search(request()->searchArray)->paginate(30);
            $html = view('admin.copys.table' ,compact('copys'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.copys.index');
    }

    public function create()
    {
        return view('admin.copys.create');
    }


    public function store(Store $request)
    {
        Copy::create($request->validated());
        ReportTrait::addToLog('  اضافه arsinglesame') ;
        return response()->json(['url' => route('admin.copys.index')]);
    }
    public function edit($id)
    {
        $copy = Copy::findOrFail($id);
        return view('admin.copys.edit' , ['copy' => $copy]);
    }

    public function update(Update $request, $id)
    {
        $copy = Copy::findOrFail($id)->update($request->validated());
        ReportTrait::addToLog('  تعديل arsinglesame') ;
        return response()->json(['url' => route('admin.copys.index')]);
    }

    public function show($id)
    {
        $copy = Copy::findOrFail($id);
        return view('admin.copys.show' , ['copy' => $copy]);
    }
    public function destroy($id)
    {
        $copy = Copy::findOrFail($id)->delete();
        ReportTrait::addToLog('  حذف arsinglesame') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Copy::WhereIn('id',$ids)->get()->each->delete()) {
            ReportTrait::addToLog('  حذف العديد من arpluraleName') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
