<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Catalogue;
use App\Product;
use App\Client;
use App\Provider;
use App\User;
use App\Batch;
use Yajra\DataTables\DataTables;
use App\Http\Requests\BatchRequest;
use Validator;

class BatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:batch')->only('batch'); 
    }
    
    public function index()
    {
        $isUser = auth()->user()->can(['batch.edit', 'batch.destroy']);
        if($isUser){
            return datatables()->of(Batch::all()->where('state','ACTIVO'))
            ->addColumn('product_name', function ($item) {
                $product_name = Product::find($item->product_id);
                return  $product_name->name;
            })
            ->addColumn('Detalle', function ($item) {
                return '<a class="btn btn-xs btn-info text-white" onclick="Detail('.$item->id.')"><i class="icon-list-bullet"></i></a>';
            })
            ->addColumn('Editar', function ($item) {
                return '<a class="btn btn-xs btn-primary text-white" onclick="Edit('.$item->id.')"><i class="icon-pencil"></i></a>';
            })
            ->addColumn('Eliminar', function ($item) {
                return '<a class="btn btn-xs btn-danger text-white" onclick="Delete(\''.$item->id.'\')"><i class="icon-trash"></i></a>';
            })
            ->rawColumns(['Detalle','Editar','Eliminar'])            
            ->toJson();
        }else{
            return datatables()->of(Batch::all()->where('state','ACTIVO'))
            ->addColumn('product_name', function ($item) {
                $product_name = Product::find($item->product_id);
                return  $product_name->name;
            })
            ->addColumn('Detalle', function ($item) {
                return '<a class="btn btn-xs btn-info text-white" onclick="Detail('.$item->id.')"><i class="icon-list-bullet"></i></a>';
            })
            ->addColumn('Editar', function ($item) {
                return '<a class="btn btn-xs btn-primary text-white disabled" onclick="Edit('.$item->id.')"><i class="icon-pencil"></i></a>';
            })
            ->addColumn('Eliminar', function ($item) {
                return '<a class="btn btn-xs btn-danger text-white disabled" onclick="Delete(\''.$item->id.'\')"><i class="icon-trash"></i></a>';
            })
            ->rawColumns(['Detalle','Editar','Eliminar'])            
            ->toJson();
        }
        
    }
    public function store(Request $request)
    {   
        $rule = new BatchRequest();        
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails())
        {
            return response()->json(['success'=>false,'msg'=>$validator->errors()->all()]);
        } 
        else{
            Batch::create($request->all());
            return response()->json(['success'=>true,'msg'=>'Registro existoso.']);
        }
    }
    public function show(Request $request)
    {
        $Batch = Batch::find($request->id)->with('product','user','provider','line','storage','industry','payment_status','payment_type')->first();
        return $Batch;
    }

    public function edit(Request $request)
    {
        $Batch = Batch::find($request->id);
        return $Batch->toJson();
    }

    public function update(BatchRequest $request)
    {
        $rule = new BatchRequest();        
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails())
        {
            return response()->json(['success'=>false,'msg'=>$validator->errors()->all()]);
        } 
        else{
            $Batch = Batch::find($request->id);
            $Batch->update($request->all());
            return response()->json(['success'=>true,'msg'=>'Registro actualizado existosamente.']);
        }
    }
    public function destroy(Request $request)
    {
        $Batch = Batch::find($request->id);
        $Batch->state = "ELIMINADO";
        $Batch->update();
        return response()->json(['success'=>true,'msg'=>'Registro borrado.']);
    }
    public function batch()
    {
        return view('manage_inventory.batch');
    }
}
