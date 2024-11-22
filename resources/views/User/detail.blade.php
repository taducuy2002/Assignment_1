@extends('User/layout')

@section('title', $post->title)

@section('content')

<div>
        <div class="card">
            <div class="card-body">
            <div>
                <h3>Tên tác phẩm: {{ $post->title }}</h3>
                <div class="d-flex"><h3>Trang bìa: </h3> <img src="{{$post->thumbnail}}" alt="{{ $post->title}}" width="100"></div>
                <div class="d-flex">
                    <h3>Tác giả:  {{ $post->author }}</h3>
                </div>
                <div class="d-flex" >
                    <h3>Nhà xuất bản:{{ $post->publisher }}</h3>
                </div>
                <div class="d-flex">
                  <h3>Ngày xuất bản:   {{ $post->publication }}</h3>
                </div>
                <div class="d-flex">
                    <h3>Giá bán: {{ $post->price }}</h3>
                </div>
                <div class="d-flex">
                   <h3>Số lượng:  {{ $post->quantity }}</h3>
                </div>
                <div>
                    <h3>Thể loại: {{ $post->name }}</h3>
                </div>
             </div>
        </div>
    </div>
    <a href="{{route('home')}}" class="btn btn-primary">Quay lại</a>
</div>

@endsection