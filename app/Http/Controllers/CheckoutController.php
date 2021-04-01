<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use Cartalyst\Stripe\Exception\CardErrorException;
use App\Order;
use App\Payment;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller
{
    public function index() {
        return view('guest.checkout.index');
    }

    public function store(Request $request) {
        if (!$request->input('order_id')) {
            $order = new Order();
            $order->fill($request->all());
            $order->quantity = Cart::count();
            $order->amount = str_replace(',', '', Cart::subtotal());
            $order->save();

            $products = Cart::content()->mapWithKeys(function($item) {
                return [
                    $item->model->id => ['quantity' => $item->qty]
                ];
            });

            $order->products()->sync($products);
        } else {
            $order = Order::find($request->input('order_id'));
            $order->update($request->all());
        }

        $payment = new Payment();
        $payment->order_id = $order->id;


        $contents = Cart::content()->map(function($item) {
            return $item->model->slug . ', ' . $item->qty;
        })->values()->toJson();

        try {
            $charge = Stripe::charges()->create([
                'amount' => Cart::subtotal(),
                'currency' => 'EUR',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::count()
                ]
            ]);

            foreach ($order->products as $product) {
                $items_number = Cart::content()->filter(function($item) use ($product) {
                    return $item->model->id == $product->id;
                })->first()->qty;

                $product->update(['quantity' => $product->quantity - $items_number]);
            }

            $payment->stripe_id = $charge['id'];
            $payment->accepted = 1;
            $payment->save();

            Mail::send(new OrderPlaced($order));

            Cart::destroy();

            return redirect()->route('guest.products.index')->with('success-payment-message', 'Payment has been successfully accepted');
        } catch (CardErrorException $e) {
            $payment->stripe_id = $e->getRawOutput()['error']['charge'];
            $payment->accepted = 0;
            $payment->save();

            return back()->with([
                'error-payment-message' => 'Payment failed. ' . $e->getRawOutput()['error']['message'],
                'order_id' => $order->id
            ]);
        }
    }
}
