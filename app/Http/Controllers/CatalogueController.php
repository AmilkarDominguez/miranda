<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// importados
use App\TypeCatalogue;
use App\Catalogue;
use Yajra\DataTables\DataTables;
use App\Http\Requests\CatalogueRequest;
use Validator;

use Caffeinated\Shinobi\Middleware\UserHasRole;

class CatalogueController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:industry')->only('industry');
        $this->middleware('permission:line')->only('line');
        $this->middleware('permission:deposit')->only('deposit');
        $this->middleware('permission:zone')->only('zone');   
        
    }
    /*public function verify(Request $request)
    {

        $isAdmin = auth()->user()->hasRole('admin');
        if ($isAdmin) {
            return "true";
        }
        else {
            return "false";
        }
        return $isEditor->toJson();
        //$code_enable = "disabled";
        $roles = auth()->user()->roles;
        for ($i=0; $i < count($roles) ; $i++) { 
            if ($roles[$i]->name=="Admin") {
                return $roles;
                return $roles[$i]->name;
            }else{

            }
        }
        
    }*/
    public function index(Request $request)
    {
        $isUser = auth()->user()->permissions;
        if ($isUser) {
            return datatables()->of(Catalogue::all()->where('type_catalog_id', $request->type_catalog_id)->where('state','ACTIVO'))
            ->addColumn('Editar', function ($item) {
            return '<a class="btn btn-xs btn-primary text-white disabled" onclick="Edit('.$item->id.')" type="hidden"><i class="icon-pencil"></i></a>';
            })
            ->addColumn('Eliminar', function ($item) {
            return '<a class="btn btn-xs btn-danger text-white disabled" onclick="Delete(\''.$item->id.'\')"><i class="icon-trash"></i></a>';
            })
            ->rawColumns(['Editar','Eliminar'])  
            ->toJson();
        }
        else {
            return datatables()->of(Catalogue::all()->where('type_catalog_id', $request->type_catalog_id)->where('state','ACTIVO'))
            ->addColumn('Editar', function ($item) {
            return '<a class="btn btn-xs btn-primary text-white" onclick="Edit('.$item->id.')" type="hidden"><i class="icon-pencil"></i></a>';
            })
            ->addColumn('Eliminar', function ($item) {
            return '<a class="btn btn-xs btn-danger text-white" onclick="Delete(\''.$item->id.'\')"><i class="icon-trash"></i></a>';
            })
            ->rawColumns(['Editar','Eliminar'])  
            ->toJson();
        }

    }

    public function store(Request $request)
    {
        $rule = new CatalogueRequest();        
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails())
        {
            return response()->json(['success'=>false,'msg'=>$validator->errors()->all()]);
        } 
        else{
            Catalogue::create($request->all());
            return response()->json(['success'=>true,'msg'=>'Registro existoso.']);
        }
    }
    public function show($id)
    {
        $Catalogue = Catalogue::find($id);
        return $Catalogue->toJson();
    }
    public function edit(Request $request)
    {
       $Catalogue = Catalogue::find($request->id);
        return $Catalogue->toJson();
    }
    public function update(Request $request)
    {
        $rule = new CatalogueRequest();        
        $validator = Validator::make($request->all(), $rule->rules());
        if ($validator->fails())
        {
            return response()->json(['success'=>false,'msg'=>$validator->errors()->all()]);
        } 
        else{
            $Catalogue = Catalogue::find($request->id);
            $Catalogue->update($request->all());
            return response()->json(['success'=>true,'msg'=>'Registro actualizado existosamente.']);
        }
    }

    public function destroy(Request $request)
    {
        $Catalogue = Catalogue::find($request->id);
        $Catalogue->delete();
        return response()->json(['success'=>true,'msg'=>'Registro borrado.']);
    }

    // Return Views
    public function line() // linea
    {
        return view('catalogs.line');
    }
    public function deposit() // almacen
    {
        return view('catalogs.deposit');
    }
    public function zone() // departamento
    {
        return view('catalogs.zone');
    }
    public function industry() // industrias
    {
        return view('catalogs.industry');
    }
    // lista los catalogos depende del id que pase
    public function list(Request $request)
    {
        switch ($request->by)
        {
            case 'type_catalog_id':
                $list=Catalogue::All()
                ->where('type_catalog_id',$request->type_catalog_id)
                ->where('state','ACTIVO');
                return $list;
            break;
            case 'all':
                $list=Catalogue::All()->where('state','ACTIVO');
                return $list;
            break;         
            default:
            break;
        }
    }

}
