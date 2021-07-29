<h2>Hello User,</h2>
Email received from: {{ $order->user->name }}

order information:

Name: {{ $order->user->name }}
Order: {{ $order->code }}
shiping at : {{ $order->address->address }}
shiping_price : {{ $order->shipping_price }}
subTotal: {{ $order->subtotal }}
grand_total: {{ $order->grand_total }}

Thank you 