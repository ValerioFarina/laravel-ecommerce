<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>
    <h1>Order n. {{ $order->id }}</h1>
    <ul>
        <li>
            <strong>Email:</strong>
            {{ $order->email }}
        </li>
        <li>
            <strong>Name:</strong>
            {{ $order->name }}
        </li>
        <li>
            <strong>Address:</strong>
            {{ $order->address }}
        </li>
        <li>
            <strong>City:</strong>
            {{ $order->city }}
        </li>
        <li>
            <strong>Province:</strong>
            {{ $order->province }}
        </li>
        <li>
            <strong>Postal code:</strong>
            {{ $order->postalcode }}
        </li>
        <li>
            <strong>Quantity:</strong>
            {{ $order->quantity }}
        </li>
    </ul>
</body>
</html>
