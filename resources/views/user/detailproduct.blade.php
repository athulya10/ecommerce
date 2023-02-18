<div class="latest-products">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Latest Products</h2>
              <a href="products.html">view all products <i class="fa fa-angle-right"></i></a>

              <form action="{{url('search')}}" method="get" class="form-inline" style="float:right; padding:10px;">
                <input class="form-control" type="search" name="search" placeholder="search">
                <input type="submit" value="search" class="btn btn-success">
              </form>
            </div>
          </div>

          
          <div class="col-md-4">
            <div class="product-item">
              <a href="#"><img height="300" width="150" src="/productimage/{{$data->image}}" alt=""></a>
              <div class="down-content">
                <a href="#"><h4>{{$data->title}}</h4></a>
                <h6>&#8377;{{$data->price}}</h6>
                <p>{{$data->description}}</p>

               <form action="{{url('addcart',$product->id)}}" method="POST"> 
                @csrf
                <input type="number" value="1" min="1" class="form-control" style="width:100px" name="quantity">
                <br>
                <input style="color:black" class="btn btn-primary" type="submit" value="Add Cart">


               </form>
                
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>