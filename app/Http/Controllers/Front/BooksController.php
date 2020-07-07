<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Book;
use App\BookDownload;

use Auth;
use DB;
use Session;

class BooksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => array(
            "getDownload"
        )]);
    }

    public function index()
    {
        $books = Book::get();
        return view("front.books.index", array(
            "books" => $books
        ));
    }

    public function getView($slug)
    {
        $book = Book::join("book_translations", "book_translations.book_id", "=", "books.id")
            ->where("book_translations.slug", $slug)->first(["books.*"]);

        if (!empty($book)) {
            $book_trans = $book->book_trans(App('lang'));
            if ($book_trans->slug != $slug)
                return redirect(App('urlLang') . 'pages/' . $book_trans->slug, 301);
            else {
                $isPaid = $book->isTotalPaid();
                return view('front.books.view', array(
                    "book" => $book, "book_trans" => $book_trans,
                    "isPaid" => $isPaid
                ));
            }
        } else {
            abort(404);
        }
    }

    public function getDownload($id)
    {
        $book = Book::findOrFail($id);

        $isPaid = $book->isTotalPaid();
        if ($isPaid) {

            // if (file_exists('uploads/kcfinder/upload/file/' . $book->pdf_book)) {
            $filename = 'uploads/kcfinder/upload/file/' . $book->pdf_book;

            readfile($filename);

            $bookDownload = new BookDownload();
            $bookDownload->user_id = Auth::user()->id;
            $bookDownload->book_id = $book->id;
            $bookDownload->save();
            // } else {
            //     return redirect()->back();
            // }
        } else {
            session()->flash("alert-danger", "هذا الكتاب غير مدفوع");
            return redirect()->back();
        }
    }
}

// $book = Book::findOrFail($id);

// $isPaid = $book->isTotalPaid();
// if ($isPaid) {

//     // if (file_exists('uploads/kcfinder/upload/file/' . $book->pdf_book)) {
//     $filename = 'uploads/kcfinder/upload/file/' . $book->pdf_book;
//     //  return $filename;



//     $bookDownload = new BookDownload();
//     $bookDownload->user_id = Auth::user()->id;
//     $bookDownload->book_id = $book->id;
//     $bookDownload->save();

//     header("Content-type: application/pdf");
//     $fichier = "uploads/kcfinder/upload/file/" . $book->pdf_book;
//     header("Content-Disposition: attachment; filename=$fichier");
//     return  readfile($fichier);

//     //  response()->file('uploads/kcfinder/upload/file/' . $book->pdf_book);
//     // } else {
//     //     return redirect()->back();
//     // }
// } else {
//     session()->flash("alert-danger", "هذا الكتاب غير مدفوع");
//     return redirect()->back();
// }