<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\sales;
use App\Models\sales_products;
use Illuminate\Http\Request;

class SalesProductsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {


        //Creamos la nueva venta
        $new_sale = sales::create([
            'users_id' => $request->users_id,
            'date' => $request->date,
            'number' => $request->number,
            'iva' => $request->iva,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
        ]);

        //Insertamos el numero de la factura
        $new_sale->number = $new_sale->date . '-' . $new_sale->id;

        $articles_inserted = [];
        $articles_updated = [];

        $articulos = json_decode($request->articulos);

        //Ingresamos los productos de la venta
        foreach ($articulos as $p) {
            $new_sales_product = sales_products::create([
                'sales_id' => $new_sale->id,
                'products_id' => $p->products_id,
                'price' => $p->price,
                'amount' => $p->amount,
                'iva' => $p->iva,
                'subtotal' => $p->subtotal,
                'total' => $p->total,
            ]);

            array_push($articles_inserted, $new_sales_product);

            //Buscamos el producto para restar su stock
            $product = Product::find($new_sales_product->products_id);
            $product->stock -= $new_sales_product->amount;
            $product->save();

            array_push($articles_updated, $product);
        }

        return response([
            'message' => 'Venta exitosa!',
            'new_sale' => $new_sale,
            'articles_inserted' => $articles_inserted,
            'articles_updated' => $articles_updated,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sales_products  $sales_products
     * @return \Illuminate\Http\Response
     */
    public function show(sales_products $sales_products) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sales_products  $sales_products
     * @return \Illuminate\Http\Response
     */
    public function edit(sales_products $sales_products) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sales_products  $sales_products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sales_products $sales_products) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sales_products  $sales_products
     * @return \Illuminate\Http\Response
     */
    public function destroy(sales_products $sales_products) {
        //
    }
}
