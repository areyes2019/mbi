<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function list($id)
    {
        $query = Contact::where('type',$id)->get();
        return $query;
    }
    public function page($id)
    {
        return view('contacts/index');   
    }
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validated =  $request->validate([
            'type'      =>  'required',
            'name'      =>  'max:35|required',
            'email'     =>  'nullable|regex:/(.+)@(.+)\.(.+)/i',
            'phone'     =>  'nullable|numeric|min:10',
            'mobile'    =>  'required|numeric|min:10',
            'address'   =>  'nullable|max:30',
            'zone'      =>  'nullable',
            'zip'       =>  'nullable|numeric|min:5',
            'tax_id'    =>  'nullable|max:18',
            'store_id'  =>  'nullable',
            'company'   =>  ''
        ],[
            'type.required'=>'El tipo de contacto es obligatorio',
            'name.alpha'=>'No se aceptan numero',
            'name.max'=>'El nombre no debe tener mas de 35 caracteres',
            'name.required'=>'El nombre es obligatirio',
            'email.email'=>'No es un formato de correo aceptable',
            
            'phone.numeric'=>'El campo solo debe contener números',
            'phone.min'=>'El campo mobil debe tener por lo menos 10 dígitos',

            'mobile.required'=>'Debes registrar un número de celular',
            'mobile.numeric'=>'El campo solo debe contener números',
            'mobile.min'=>'El campo télefono debe contar por lo menos con 10 dígitos',

            'address.max'=>'Máximo 30 caractéres',
            'zip.min'=>'El código postal debe contener 5 números',
            'zip.numeric'=>'El Código Postal no debe tener letras',
        ]);

        
        Contact::create($validated);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $query = Contact::where('idContact', $id)->delete();
        if ($query) {
            return true;
        }
    }
    public function contact_show($id)
    {
        $query = Contact::where('idContact',$id)->get();
        return $query;
    }
    public function contact_update(Request $request, $id)
    {
        $query = Contact::where('idContact',$id)->update([
                'type'      =>$request->type,
                'company'   =>$request->company,
                'name'      =>$request->name,
                'email'     =>$request->email,
                'phone'     =>$request->phone,
                'mobile'    =>$request->mobile,
                'address'   =>$request->address,
                'zone'      =>$request->zone,
                'zip'       =>$request->zip,
                'tax_id'    =>$request->tax_id
        ]);
        if ($query) {
            return true;
        }
    }
}
