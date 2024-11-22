
@extends('User/layout')

@section('title', 'Trang chủ')

@section('content')

<style>
    .banner{
    width: 100%;
    padding-top: 10px;
    height: 300px;
    display: flex;
    .anh-banner{
      width: 50%;
      img{
        width: 100%;
        height: 100%;
      }
    }
    .chu-banner{
      width: 50%;
      text-align: center;
      padding-top: 6pc;
    }
}
.row {
   margin-left: 16px;
}
</style>

  <div class="banner">
   <div class="anh-banner">
    <img src="https://up.yimg.com/ib/th?id=OIP.-QpCN_EcL8HPIhRIGv9LJAHaDK&pid=Api&rs=1&c=1&qlt=95&w=242&h=103" alt="">
    <img src="https://up.yimg.com/ib/th?id=OIP.0aRNPSLCUEDCPjyepOPwhAHaEK&pid=Api&rs=1&c=1&qlt=95&w=184&h=103" alt="">
   </div>
   <div class="chu-banner">
    <h3>Tìm hiểu về các loại sách</h3>
    <p>Tìm hiểu thêm về các loại sách văn hóa xã hội của thế giới cũng như Văn hóa Việt Nam</p>
   </div>
  </div>
  <h3 class="text text-center pt-3">Danh sách</h3>
       <div class="row">
        <div class="row g-3 gap-3 ml-5">
        
          @foreach ($posts as $post)
          <div class="card" style="width: 18rem;">
            <img src="{{$post->thumbnail}}" class="card-img-top" alt="..." width="60" height="200">
            <div class="card-body">
              <h5 class="card-title">{{ $post->title}}</h5>
              <p class="card-text">Tác giả: {{$post->author}}</p>
              <p class="card-text text-danger">Giá bán: {{$post->price}}</p>
              <div class="d-flex gap-3">
                <a href="{{route('detail', $post->id)}}" class="btn btn-primary">Chi tiết</a>
                <form action="{{ route('cart.addtocart', $post->id) }}" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $post->id }}">
                  <input type="hidden" name="thumbnail" value="{{ $post->thumbnail }}">
                  <input type="hidden" name="title" value="{{ $post->title }}">
                  <input type="hidden" name="author" value="{{ $post->author }}">
                  <input type="hidden" name="price" value="{{ $post->price }}">
                  <input type="submit" name="addtocart" class="btn btn-success" value="Add to Cart" class="buttonbtn">
              </form>
              
              </div>
            </div>
          </div> 
          @endforeach        
        </div>
        <h3 class="text text-center pt-3"><a href="{{route('list')}}" class="btn btn-success">Trang danh sách</a></h3>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
   
    const images = document.querySelectorAll('.anh-banner img');
    let currentIndex = 0;

   
    images.forEach((img, index) => {
        if (index !== 0) {
            img.style.display = 'none';
        }
    });

    
    function showNextImage() {
        images[currentIndex].style.display = 'none'; 
        currentIndex = (currentIndex + 1) % images.length; 
        images[currentIndex].style.display = 'block'; 
    }

    
    setInterval(showNextImage, 2000); 
});

</script>
@endsection