<?php

namespace App\Http\Controllers;

use App\Seller;
use App\TypeDocument;
use Illuminate\Http\Request;
use App\Http\Requests\SaveSellerRequest;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $sellers = Seller::with(["type_document"])
            ->seller($request->get('seller_id'))
            ->typedocument($request->get('type_document_id'))
            ->document($request->get('document'))
            ->email($request->get('email'))
            ->orderBy('name')
            ->paginate(10);
        return response()->view('sellers.index', [
            'sellers' => $sellers,
            'request' => $request,
            'side_effect' => __('Se borrarán todas sus facturas asociadas')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return response()->view('sellers.create', [
            'seller' => new Seller,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveSellerRequest $request) {
        $result = Seller::create($request->validated());

        return redirect()->route('sellers.show', $result->id)->withSuccess(__('Vendedor creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller) {
        return response()->view('sellers.show', [
            'seller' => $seller,
            'side_effect' => __('Se borrarán todas sus facturas asociadas')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller) {
        return response()->view('sellers.edit', [
            'seller' => $seller,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveSellerRequest $request
     * @param Seller $seller
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SaveSellerRequest $request, Seller $seller) {
        $seller->update($request->validated());

        return redirect()->route('sellers.show', $seller)->withSuccess(__('Vendedor actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Seller $seller
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Seller $seller) {
        $seller->delete();

        return redirect()->route('sellers.index')->withSuccess(__('Vendedor eliminado satisfactoriamente'));
    }
}
