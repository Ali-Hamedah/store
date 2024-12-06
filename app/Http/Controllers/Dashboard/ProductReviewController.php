<?php

namespace App\Http\Controllers\Dashboard;


use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReviewRequest;

class ProductReviewController extends Controller
{
    public function index()
    {

        $reviews = ProductReview::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);
        return view('dashboard.product_reviews.index', compact('reviews'));
    }

    public function create()
    {
       

        //
    }

    public function store(Request $request)
    {
        

        //
    }

    public function show(ProductReview $productReview)
    {
      
        return view('dashboard.product_reviews.show', compact('productReview'));
    }

    public function edit(ProductReview $productReview)
    {
      

        return view('dashboard.product_reviews.edit', compact('productReview'));
    }

    public function update(ProductReviewRequest $request, ProductReview $productReview)
    {
       

        $productReview->update($request->validated());

        return redirect()->route('dashboard.product_reviews.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(ProductReview $productReview)
    {
     

        $productReview->delete();

        return redirect()->route('dashboard.product_reviews.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
