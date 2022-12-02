<h4>Foods</h4>
@foreach($foods as $food)
    <div class="food_item" style="display:flex;">
    <div class="img">
        <img src="/images/{{$food['image']}}" style="height: 100px; padding-right: 20px;"/>
    </div>
    <div class="content">
        <h4>{{$food['name']}}</h4>
        <p>Price : {{$food['price']}} Tk</p>
        <p style="margin-bottom: 0"><b><a href="/delete-food/{{$food['id']}}">Delete</a></b></p>
        @if ($edit)
        <p><b><a href="/edit-food/{{$food['id']}}">Edit</a></b></p>
        @endif
    </div>
    </div>
@endforeach