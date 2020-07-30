<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\FinalUser;
use App\CustomerType;
use App\Http\Requests\CustomerRequest;
use Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate(15);
        return view('customer/index_customer',['customers'=>$customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customersTypes = CustomerType::all(); 
        return view('customer/create_customer',['customersTypes'=>$customersTypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->all());
        if($customer)
        {
            FinalUser::create([
                'customer_id'=>$customer->id,
                'name'=>$customer->responsable_name,
                'last_name1'=>$customer->responsable_last_name1,
                'last_name2'=>$customer->responsable_last_name2,
                'email'=>$customer->email,
                'phone'=>$customer->phone,
                //'extension',
                'area_descripcion'=>'Responsable',
                'cp'=>$customer->cp,
                'asentamiento'=>$customer->asentamiento,
                'ciudad'=>$customer->ciudad,
                'municipio'=>$customer->municipio,
                'estado'=>$customer->estado,
                'calle_numero'=>$customer->calle_numero,
                'piso'=>$customer->piso,
                'interior'=>$customer->interior,
            ]);
            return redirect('show_customer/'.$customer->id)->with('mensaje','El cliente se creó con éxito.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $finalUsers = FinalUser::where('customer_id',$id)->get();
        $customer = Customer::findOrFail($id);
        return view('customer/show_customer',['customer'=>$customer,'finalUsers'=>$finalUsers]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $customersTypes = CustomerType::all();
        return view('customer/edit_customer',['customer'=>$customer,'customersTypes'=>$customersTypes]);
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
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        return redirect('show_customer/'.$customer->id)->with('mensaje','El cliente se actualizó con éxito.');
    }

    /**
     * confirm the specified resource before destroy.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function confirm(Request $request,$id)
    {
        $customer = Customer::findOrfail($id);
        return view('customer/confirm_customer',['customer'=>$customer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrfail($id);
        if($customer->delete())
        {
            $finalUsers =  FinalUser::where('customer_id',$id)->delete();
            return redirect('index_customer')->with('mensaje','El cliente se eliminó con éxito.');
        }else{
            return redirect('index_customer')->with('mensaje','Ocurrió un error al intentar eliminar el registro.');
        }
    }
}
