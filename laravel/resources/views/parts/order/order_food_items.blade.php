<h4>Ordered Foods</h4>
@foreach($foods as $food)
    <div class="food_item" style="display:flex;">
    <div class="img">
        <img src="/images/{{$food['image']}}" style="height: 50px; padding-right: 20px;"/>
    </div>
    <div class="content">
        <p style="margin-bottom:0px"><b>Name : </b>{{$food['name']}} x{{$food['quantity']}}</p>
        <p><b>Price :</b> {{$food['price']}} Tk</p>
    </div>
    </div>
@endforeach