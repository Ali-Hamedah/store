  <!-- Sidebar Menu -->
   <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           @can('view category')
                 <x-sidebar 
           classType="layer-group" 
           title="Categories" 
           :links="[
               ['url' => route('dashboard.categories.index'), 'label' => 'Categories'],
               ['url' => route('dashboard.categories.trash'), 'label' => 'Categories Trash']
           ]" 
       />
           @endcan
       
           @can('view product')
       <x-sidebar 
           classType="shopping-bag" 
           title="Products" 
           :links="[
               ['url' => route('dashboard.products.index'), 'label' => 'Products'],
               // ['url' => route('dashboard.products.trash'), 'label' => 'Products Trash']
           ]" 
       />
@endcan
       @can('view order')
       <x-sidebar 
       classType="shopping-cart 9" 
       title="Orders" 
       :links="[
           ['url' => route('dashboard.orders.index'), 'label' => 'Orders'],
          //  ['url' => route('dashboard.orders.trash'), 'label' => 'Categories Trash']
       ]" 
   />
@endcan
 @can('view coupon')
   <x-sidebar 
   classType="fa fa-tags" 
   title="Coupons" 
   :links="[
       ['url' => route('dashboard.product_coupons.index'), 'label' => 'Coupons'],
      //  ['url' => route('dashboard.orders.trash'), 'label' => 'Categories Trash']
   ]" 
/>
@endcan
@can('view review')
<x-sidebar 
classType="fa-solid fa-star" 
title="Reviews"  
:links="[
    ['url' => route('dashboard.product_reviews.index'), 'label' => 'Reviews'],
   //  ['url' => route('dashboard.orders.trash'), 'label' => 'Categories Trash']
]" 
/>
@endcan
@can('view customer')
<x-sidebar 
classType="fa-solid fa-star" 
title="Customer"  
:links="[
    ['url' => route('dashboard.customers.index'), 'label' => 'Customer'],
   //  ['url' => route('dashboard.orders.trash'), 'label' => 'Categories Trash']
]" 
/>
@endcan
@can('view permission')
<x-sidebar 
classType="fa-solid fa-star" 
title="Permissions"  
:links="[
    ['url' => route('dashboard.permissions.index'), 'label' => 'Permissions'],
   //  ['url' => route('dashboard.orders.trash'), 'label' => 'Categories Trash']
]" 
/>
@endcan
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Simple Link
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->