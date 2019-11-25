<?php

namespace App\Http\Controllers;

use App\Seller;
use App\Http\Requests\SaveSellerRequest;
use App\TypeDocument;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sellers = Seller::paginate(10);
        return view('sellers.index', [
            'sellers' => $sellers
        ]);
    }

    public function create()
    {
        return view('sellers.create', [
            'seller' => new Seller,
            'type_documents' => TypeDocument::all()
        ]);
    }

    public function store(SaveSellerRequest $request)
    {
        Seller::create($request->validated());

        return redirect()->route('sellers.index')->with('message', 'Vendedor creado satisfactoriamente');
    }

    public function show(Seller $seller)
    {
        return view('sellers.show', [
            'seller' => $seller
        ]);
    }

    public function edit(Seller $seller)
    {
        return view('sellers.edit', [
            'seller' => $seller,
            'type_documents' => TypeDocument::all()
        ]);
    }

    public function update(SaveSellerRequest $request, Seller $seller)
    {
        $seller->update($request->validated());

        return redirect()->route('sellers.show', $seller)->with('message', 'Vendedor actualizado satisfactoriamente');
    }

    public function destroy(Seller $seller)
    {
        $seller->delete();

        return redirect()->route('sellers.index')->with('message', 'Vendedor eliminado satisfactoriamente');
    }
}
