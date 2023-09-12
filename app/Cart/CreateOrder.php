<?php

namespace App\Cart;

use App\Enums\OrderOrigin;
use App\Enums\OrderStatus;
use App\Models\DeliveryAddress;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use App\Models\OrderProductAdditional;
use App\Models\OrderProductReplacement;
use App\Models\StoreCustomer;
use App\Models\StoreOrder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Utils\Helper;

class CreateOrder {

    private $customer;
    private $products;
    private $delivery;
    private $address;
    private $payment;

    public function setCustomer($customer)
    {
        $this->customer = [
            'name' => Helper::captalizeName($customer['name']),
            'document' => Helper::clearAllIsNotNumber($customer['cpf']),
            'email' => Str::lower($customer['email']),
            'cellphone' => Helper::clearAllIsNotNumber($customer['cellphone']),
        ];

        return $this;
    }

    public function setPayment($type)
    {
        $this->payment = [
            'payment_type_id' => $type
        ];

        return $this;
    }

    public function setDelivery($type, ?String $observation = null)
    {
        $this->delivery = [
            'type' => $type,
            'observation' => $observation
        ];

        return $this;
    }

    public function setAddress($address)
    {
        $this->address = [
            'street' => $address['street'],
            'number' => $address['number'],
        ];

        return $this;
    }

    public function setProducts(Collection $products)
    {
        $this->products = $products;
        return $this;
    }

    public function create()
    {
        $customer = StoreCustomer::query()
            ->create(array_merge($this->customer, [
                'user_store_id' => '18d61b11-2f3e-34db-93ad-6e3692cac7e8',
            ]));

        $order = StoreOrder::query()
            ->create([
                'user_store_id' => '18d61b11-2f3e-34db-93ad-6e3692cac7e8',
                'customer_id' => $customer->id,
                'status' => OrderStatus::OPEN,
                'origin' => OrderOrigin::CUSTOMER
            ]);

        foreach ($this->products as $product) {
            OrderProduct::query()
                ->create([
                    'order_id' => $order->id,
                    'product_id' => $product->model->id,
                    'amount' => $product->amount,
                    'value' => $product->getValue()
                ]);

            foreach ($product->additionals as $additional) {
                OrderProductAdditional::query()
                    ->create([
                        'order_id' => $order->id,
                        'product_additional_id' => $additional->model->id,
                        'value' => $additional->getValue(),
                        'amount' => 2
                    ]);
            }

            foreach ($product->replacements as $replacement) {
                OrderProductReplacement::query()
                    ->create([
                        'order_id' => $order->id,
                        'replacement_id' => $replacement->model->id,
                        'value' => $replacement->getValue()
                    ]);
            }
        }

        $delivery = OrderDelivery::query()
            ->create(array_merge($this->delivery, [
                'order_id' => $order->id
            ]));

        DeliveryAddress::query()
            ->create(array_merge($this->address, [
                'delivery_id' => $delivery->id
            ]));

        OrderPayment::query()
            ->create(array_merge($this->payment, [
                'order_id' => $order->id
            ]));
    }
}
