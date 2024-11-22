<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index() {
        $posts = DB::table('books')->join('categories', 'category_id', '=', 'categories.id')->select('books.*', 'name')
        ->limit(10)->get();
   
        return view('Admin/index', compact('posts'));
       }
    // Delete
    public function destroy($id) {
        $post = DB::table('books')->find($id);
        DB::table('books')->where('id', $id)->delete();

        return redirect()->route('index', $post->category_id);
    }

   // Form thêm mới
   public function create() {
    // Lấy tất cả danh mục từ bảng categories
    $categories = DB::table('categories')->get();
    
    // Trả về view và truyền danh mục
    return view('Admin/create', compact('categories')); 
}

// Lưu dữ liệu
public function store(Request $request) {
    $data = [
          'title' => $request['title'],
          'thumbnail' => $request['thumbnail'],
          'author' => $request['author'],
          'publisher' => $request['publisher'],
          'publication' => $request['publication'],
          'price' => $request['price'],
          'quantity' => $request['quantity'],
          'category_id' => $request['category_id'],
    ];
    DB::table('books')->insert($data);
    return redirect()->route('index');
}

// form edit

public function edit($id) {
    $book = DB:: table('books')->where('id', $id)->first();
    $categories = DB::table('categories')->get();
    return view('Admin/edit', compact('book', 'categories'));
}

// Cập nhật dữ liệu
public function update(Request $request) {
    $data = [
          'title' => $request['title'],
          'thumbnail' => $request['thumbnail'],
          'author' => $request['author'],
          'publisher' => $request['publisher'],
          'publication' => $request['publication'],
          'price' => $request['price'],
          'quantity' => $request['quantity'],
          'category_id' => $request['category_id'],
    ];
    DB::table('books')->where('id', $request['id'])->update($data);
    return redirect()->route('index');
}


// Trang user

// Hiển thị trang chủ
public function home() {
    $posts = DB::table('books')->join('categories', 'category_id', '=', 'categories.id')->select('books.*', 'name')
        ->limit(8)->get();
    return view('User/home', compact('posts'));
   }

   // Hiển thị trang chi tiết
   public function show($id) {
    $post = DB::table('books')
              ->join('categories', 'books.category_id', '=', 'categories.id')
              ->select('books.*', 'categories.name as name')
              ->where('books.id', $id)
              ->first();
    if ($post == null) {
        return abort(404); 
    }
    $categories = DB::table('categories')->get();
    return view('User/detail', compact('post', 'categories'));
}

// Hiển thị tất cả các sách
public function list() {
    $categories = DB::table('categories')->get();
    $posts = DB::table('books')->join('categories', 'category_id', '=', 'categories.id')->select('books.*', 'name')
        ->paginate(12);
    return view('User/list-book', compact('posts', 'categories'));
   }

   public function list_dm($id) {
    $categories = DB::table('categories')->get();
    $posts = DB::table('books')
        ->join('categories', 'books.category_id', '=', 'categories.id')
        ->select('books.*', 'categories.name as category_name')
        ->where('books.category_id', $id)
        ->latest('books.id')
        ->paginate(12);

    return view('User/list-book', compact('posts', 'categories'));
}




public function addToCart(Request $request, $bookId)
{
    
    if (!is_numeric($bookId) || $bookId <= 0) {
        return redirect()->back()->with('error', 'ID sách không hợp lệ');
    }

   
    $book = DB::table('books')->find($bookId);

    if (!$book) {
        return redirect()->back()->with('error', 'Sách không tìm thấy');
    }

    
    $cart = session()->get('cart', []);

    
    if (isset($cart[$bookId])) {
        $cart[$bookId]['quantity']++;
    } else {
        
        $cart[$bookId] = [
            'title' => $book->title,
            'author' => $book->author,
            'price' => number_format($book->price, 2), 
            'quantity' => 1,
    
            'thumbnail' => $book->thumbnail ?? 'default-thumbnail.jpg',
        ];
    }

    session()->put('cart', $cart);

    return redirect()->route('cart.view')->with('success', 'Sách đã được thêm vào giỏ hàng thành công!');
}



public function viewCart()
{
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return view('addtocart', ['message' => 'Giỏ hàng của bạn hiện đang trống']);
    }

    return view('User/addtocart', compact('cart'));
}

// Tìm kiếm
public function search(Request $request) {
    $query = $request->input('query');
    $categories = DB::table('categories')->get();

    $posts = DB::table('books')
        ->join('categories', 'books.category_id', '=', 'categories.id')
        ->select('books.*', 'categories.name')
        ->where('books.title', 'LIKE', "%{$query}%") 
        ->orWhere('books.author', 'LIKE', "%{$query}%") 
        ->paginate(12);

    return view('User/list-book', compact('posts', 'categories'));
}

}
