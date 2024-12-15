<div>
    <!-- Start Product Grids -->
    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- Start Product Sidebar -->
                    <div class="product-sidebar">
                        <!-- Start Single Widget -->
                        <div class="single-widget search">
                            <h3>Search Product</h3>
                            <form action="#">
                                <input type="text" placeholder="Search Here...">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <div class="single-widget">
                            <h3>All Categories</h3>
                            <ul class="list">
                                @foreach ($shop_categories_menu as $category)
                                    <li>
                                        <a href="javascript:void(0);" wire:click="changeCategory({{ $category->id }})">
                                            {{ $category->name }}
                                        </a>
                                        <span>({{ $category->products()->count() ?? 0 }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="single-widget">
                            <h3>All Tags</h3>
                            <ul class="list">
                                @foreach ($shop_tags_menu as $tag)
                                    <li>
                                        <a href="javascript:void(0);" wire:click="changeTag({{ $tag->id }})">
                                            {{ $tag->name }}
                                        </a>
                                        <span>({{ $tag->products()->count() ?? 0 }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- End Single Widget -->
                      
                      
                     
                    </div>
                    <!-- End Product Sidebar -->
                </div>
                <div class="col-lg-9 col-12">
                    <div class="product-grids-head">Sort by:
                        <div class="product-grid-topbar">
                            <div class="row align-items-center">
                                <div class="col-lg-7 col-md-8 col-12">
                                    <div class="product-sorting">
                                        <label for="sorting">Sort by:</label>
                                        <select wire:model="sortingBy" class="form-control" wire:change="loadProducts">
                                            <option value="default">Default sorting</option>
                                            <option value="popularity">Popularity</option>
                                            <option value="low-high">Price: Low to High</option>
                                            <option value="high-low">Price: High to Low</option>
                                        </select>
                                        
                                        <h3 class="total-show-product">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</h3>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-5 col-md-4 col-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link " id="nav-grid-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-grid" type="button" role="tab"
                                                aria-controls="nav-grid" aria-selected="true"><i
                                                    class="lni lni-grid-alt"></i></button>
                                            <button class="nav-link active" id="nav-list-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-list" type="button" role="tab"
                                                aria-controls="nav-list" aria-selected="false"><i
                                                    class="lni lni-list"></i></button>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade" id="nav-grid" role="tabpanel"
                                aria-labelledby="nav-grid-tab">
                                <div class="row">

                                    @foreach ($products as $product)
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="single-product">
                                                <div class="product-image">
                                                    <img src="{{ $product->firstMedia ? asset('assets/products/' . $product->firstMedia->file_name) : asset('assets/no_image.jpg')  }}"
                                                        alt="{{ $product->name }}">
                                                    @if ($product->discount)
                                                        <span class="sale-tag">-{{ $product->discount }}%</span>
                                                    @endif
                                                    <div class="button">
                                                        <a href="{{ route('products.show', $product->slug) }}"
                                                            class="btn">
                                                            <i class="lni lni-cart"></i> Add to Cart
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <span
                                                        class="category">{{ $product->category->name ?? 'N/A' }}</span>
                                                    <h4 class="title">
                                                        <a
                                                            href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                                    </h4>
                                                    <ul class="review">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <li>
                                                                <i
                                                                    class="lni {{ $i <= $product->rating ? 'lni-star-filled' : 'lni-star' }}"></i>
                                                            </li>
                                                        @endfor
                                                        <li><span>{{ $product->rating }} Review(s)</span></li>
                                                    </ul>
                                                    <div class="price">
                                                        <span>${{ $product->price }}</span>
                                                        @if ($product->original_price)
                                                            <span
                                                                class="discount-price">${{ $product->original_price }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane show active fade" id="nav-list" role="tabpanel"
                                aria-labelledby="nav-list-tab">
                                <div class="row">
                                    @if (!empty($products))
                                        @foreach ($products as $product)
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <!-- Start Single Product -->
                                                <div class="single-product">
                                                    <div class="row align-items-center">

                                                        <!-- Check if there are products available -->


                                                        <!-- Product Image -->
                                                        <div class="col-lg-4 col-md-4 col-12">
                                                            <div class="product-image">
                                                                <img src="{{ $product->firstMedia ? asset('assets/products/' . $product->firstMedia->file_name) : asset('assets/no_image.jpg') }}"
                                                                    alt="{{ $product->name }}">

                                                                <!-- Product Discount -->
                                                                @if ($product->discount)
                                                                    <span
                                                                        class="sale-tag">-{{ $product->discount }}%</span>
                                                                @endif

                                                                <div class="button">
                                                                    <a href="{{ route('products.show', $product->slug) }}"
                                                                        class="btn">
                                                                        <i class="lni lni-cart"></i> Add to Cart
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Product Info -->
                                                        <div class="col-lg-8 col-md-8 col-12">
                                                            <div class="product-info">
                                                                <!-- Product Category -->
                                                                <span
                                                                    class="category">{{ $product->category->name ?? 'N/A' }}</span>

                                                                <!-- Product Title -->
                                                                <h4 class="title">
                                                                    <a
                                                                        href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                                                </h4>

                                                                <!-- Product Reviews -->
                                                                <ul class="review">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <li>
                                                                            <i
                                                                                class="lni {{ $i <= $product->rating ? 'lni-star-filled' : 'lni-star' }}"></i>
                                                                        </li>
                                                                    @endfor
                                                                    <li><span>{{ $product->reviews_count ?? 0 }}
                                                                            Review(s)</span></li>
                                                                </ul>

                                                                <!-- Product Price -->
                                                                <div class="price">
                                                                    <span>${{ $product->price }}</span>
                                                                    @if ($product->original_price)
                                                                        <span
                                                                            class="discount-price">${{ $product->original_price }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Single Product -->
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Message when no products are available -->
                                        <p>No products available in this category.</p>
                                    @endif
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <!-- Pagination -->
                                    <div class="pagination left">
                                        <ul class="pagination-list">
                                           
                                            <li> {!! $products->appends(request()->all())->onEachSide(2)->links() !!}</li>
                                        </ul>
                                    </div>
                                    <!--/ End Pagination -->
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
<!-- End Product Grids -->

</div>
