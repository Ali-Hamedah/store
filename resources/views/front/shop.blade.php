<x-FrontLayout title="Store">
   <!-- Start Breadcrumbs -->
   <div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">Shop List</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                    <li><a href="{{route('frontend.shop')}}">Shop</a></li>
                    <li>Shop List</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<livewire:front.shop-products-component :slug="$slug ?? null" />

</x-FrontLayout>
