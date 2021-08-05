<h2>Hello User,</h2>
<p>Email received from: {{ $order->user->name }}</p>
<h2>
    order information:
</h2>
<p>
    <strong>Name: </strong> {{ $order->user->name }}
</p>
<p>
    <strong> Order:
    </strong> {{ $order->code }}
</p>
<p>
    <strong>shiping at :</strong> {{ $order->address->address }}
</p>

<p>
    <strong>shiping_price : </strong> {{ $order->shipping_price }}
</p>
<p>
    <strong>subTotal: </strong>{{ $order->subtotal }}
</p>

<p>
    <strong>grand_total : </strong> {{ $order->grand_total }}
</p>
<p style="color: #d1d1d1"> Thank you</p>
