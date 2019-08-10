<?php

namespace App\Http\Controllers;


use App\User;
use App\Client;
use App\Seller;

use App\Catalogue;
use App\Sale;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use Validator;

class SaleController extends Controller
{
    public function index()
    {
        return datatables()->of(Sale::all())
        ->addColumn('user_name', function ($item) {
            $user_name = User::find($item->user_id);
            return  $user_name->name;
        })
        ->addColumn('client_name', function ($item) {
            $client_name = Client::find($item->client_id);
            return  $client_name->name;
        })
        ->addColumn('seller_name', function ($item) {
            $seller_name = Seller::find($item->seller_id);
            return  $seller_name->name;
        })
        ->addColumn('payment_status', function ($item) {
            $payment_status = Catalogue::find($item->payment_status_id);
            return  $payment_status->name;
        })
        ->addColumn('Detalles', function ($item) {
            return '<a class="btn btn-xs btn-info text-white" onclick="Detail('.$item->id.')"><i class="icon-list-bullet"></i></a>';
        })
        ->addColumn('NotaVenta', function ($item) {
            return '<a class="btn btn-xs btn-dark text-white" onclick="SaleNote(\''.$item->id.'\')"><i class="icon-print"></i></a>';
        })
        ->addColumn('Eliminar', function ($item) {
            return '<a class="btn btn-xs btn-danger text-white" onclick="Delete('.$item->id.')"><i class="icon-trash"></i></a>';
        })
        ->rawColumns(['Detalles','NotaVenta','Eliminar'])            
        ->toJson();

        
    }
    public function create()
    {

    }
    public function store(Request $request)
    {
        $rule = new SaleRequest();        
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails())
        {
            return response()->json(['success'=>false,'msg'=>$validator->errors()->all()]);
        } 
        else{
            $Sale = Sale::create($request->all());
            return response()->json(['success'=>true,'msg'=>'Registro existoso.','sale_id'=>$Sale->id]);
        }
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $rule = new SaleRequest();        
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails())
        {
            return response()->json(['success'=>false,'msg'=>$validator->errors()->all()]);
        } 
        else{
            $Sale = Sale::find($request->id);
            $Sale->update($request->all());
            return response()->json(['success'=>true,'msg'=>'Se actualizo existosamente.']);
        }
    }
    public function destroy($id)
    {
        //
    }
    public function sale()
    {
        return view('manage_sales.sale');
    }
}
