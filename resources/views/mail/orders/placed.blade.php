<x-mail::message>
# Order Placed Successfully!

Thankyou for order. Your number order is {{$order->id}}

<x-mail::button :url="$url">
View Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
