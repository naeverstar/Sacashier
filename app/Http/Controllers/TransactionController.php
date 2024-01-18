<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
// use Carbon\Carbon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // item with 0 stock will not be shown
        $items = Item::where('stock', '>' , 0)->get();

        // $items = Item::all();
        // session()->flush();
        return view('transaction', compact('items'));
    }

    public function add($id)
    {
        $item = Item::findorfail($id);

        $cart = session()->get('cart');
        // $cart = session('cart');
        // return $cart;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
            $cart[$id]['subtotal'] = $item->price * $cart[$id]['qty'];
        } else {
            if($item->stock > 0) {
                $cart[$id] = [
                    "id"        => $item->id,
                    "name"      => $item->name,
                    "qty"       => 1,
                    "subtotal"  => $item->price,
                ];
            } else {
                return redirect()->back()->with('error', 'Stock Item is Empty');
            }
        }

        session()->put('cart', $cart);

        // return session('cart');

        return redirect()->back()->with('success', 'Successfully added Item to Cart');
    }

    public function delete($id)
    {
        $cart = session('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Successfully removed Item from Cart');
    }

    public function cartUpdate(Request $request)
    {
        $item = Item::findorfail($request->id);
        $cart = session('cart');

        if ($request->qty > 0) {
            if($request->qty <= $item->stock) {
                $cart[$request->id]['qty'] = $request->qty;
                $cart[$request->id]['subtotal'] = $item->price * $request->qty;
                // $cart[$request->id]['subtotal'] *= $cart[$request->id]['qty'];
                session()->put('cart', $cart);
            } else {
                return redirect()->back()->with('error', 'Item Quantity is more than Stock');
                // no popup bc blade
            }
        } else {
            $this->delete($request->id);
        }

        return redirect()->back()->with('success', 'Successfully updated Cart');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Transaction::create([
            'user_id'   => Auth::id(),
            'date'      => Carbon::now(),
            'total'     => (int)$request->total,
            'pay_total' => $request->pay_total,
        ]);


        $items = session('cart');

        // $pay_total = $request->pay_total;
        // dd($pay_total);

        foreach($items as $item) {
            TransactionDetail::create([
                'transaction_id' => Transaction::latest()->first()->id,
                'item_id'        => $item['id'],
                'qty'            => $item['qty'],
                'subtotal'       => $item['subtotal'],
            ]);

            $product = Item::find($item['id']);
            $stock   = $product->stock - $item['qty'];
            $product->update(['stock' => $stock]);
        }

        // if ($request->total > $request->pay_total) {
        //     return redirect()->route('transaction.show', Transaction::latest()->first()->id);
        // }

        session()->forget('cart');
        return redirect()->route('transaction.show', Transaction::latest()->first()->id)
            ->with('success', 'Checkout is Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('invoice', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
