<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Reemplazo;
class ReemplazoController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $reemplazo = Reemplazo::create($request->all());
        if($reemplazo)
        {
            return redirect('show_service/' . $reemplazo->service_id)->with('mensaje', 'El reemplazo se agregó con éxito.');
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
        //
    }
    public function destroy($id)
    {
        //
    }
}
