<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .container {
            width: 70%;
            margin: 30px auto
        }

    </style>
</head>

<body>
    <div class="container">


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
            <strong>shiping in :</strong> {{ $order->address->address }}
        </p>



        <p>
            @foreach ($order->orderItems as $item)
                <hr>
                <h1>Product</h1>
                <p>
                    <strong>Product Link : </strong> {{ $item->variant->product->slug }}
                </p>

                <p>
                    <strong>Product name : </strong> {{ $item->variant->product->name_ar }}
                </p>
                <p>
                    <strong>Quantity : </strong> {{ $item->quantity }}
                </p>

                <p>
                    <strong>Item price : </strong> {{ $item->item_price }}
                </p>
                <p>
                    <strong>total Item price : </strong> {{ $item->total_item_price }}
                </p>
            @endforeach
        </p>

        <p>
            <strong>shiping price : </strong> {{ $order->shipping_price }}
        </p>
        <p>
            <strong>Sub Total: </strong>{{ $order->subtotal }}
        </p>

        <p>
            <strong>Grand total : </strong> {{ $order->grand_total }}
        </p>
        <p style="color: #929292"> Thank you</p>
    </div>
</body>

</html>
