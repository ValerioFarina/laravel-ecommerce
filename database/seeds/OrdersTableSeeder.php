<?php

use App\Order;
use App\Payment;
use App\Product;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $all_products = Product::all();
        $product_ids = [];
        foreach ($all_products as $product) {
            $product_ids[] = $product->id;
        }

        for ($i=0; $i<100; $i++) {
            $new_order = new Order();
            $new_order->email = $faker->email;
            $new_order->name = $faker->name;
            $new_order->address = $faker->streetAddress;
            $new_order->city = $faker->city;
            $new_order->province = $faker->country;
            $new_order->postalcode = $faker->postcode;
            $new_order->quantity = $faker->numberBetween(1, 10);
            $new_order->created_at = $faker->dateTimeInInterval('-5 years', '+5 years');
            $new_order->updated_at = $new_order->created_at;

            $order_products = [];
            for ($j=0; $j<$new_order->quantity; $j++) {
                $order_products[] = $product_ids[array_rand($product_ids)];
            }

            $order_products = collect(array_count_values($order_products));

            $order_products = $order_products->mapWithKeys(function($item, $key) {
                return [
                    $key => ['quantity' => $item]
                ];
            });

            $new_order->amount = 0;
            foreach ($order_products as $product_id => $quantity) {
                $new_order->amount += Product::find($product_id)->price * $quantity['quantity'];
            }

            $new_order->save();

            $new_order->products()->sync($order_products);

            $payment = new Payment();
            $payment->order_id = $new_order->id;
            $payment->accepted = 1;
            $payment->stripe_id = $faker->lexify();
            $payment->created_at = $new_order->created_at;
            $payment->updated_at = $new_order->created_at;
            $payment->save();
        }
    }
}
