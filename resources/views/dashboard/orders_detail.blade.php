<tr>
    <td><a href="{{ route('orders.view', ['id'=>$order->id]) }}">{{ $order->id }}</a></td>
    <td>{{ $order->user->name}}</td>
    <td>{{ $order->user->mobile}}</td>
    <td>{{ $order->restaurant->name }}</td>
    <td>{{ $order->restaurant->contact_no }}</td>
    <td>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
</tr>