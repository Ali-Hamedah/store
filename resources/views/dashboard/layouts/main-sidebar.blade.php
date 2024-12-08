  <!-- Sidebar Menu -->
   <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <x-sidebar 
           classType="layer-group" 
           title="Categories" 
           :links="[
               ['url' => route('dashboard.categories.index'), 'label' => 'Categories'],
               ['url' => route('dashboard.categories.trash'), 'label' => 'Categories Trash']
           ]" 
       />
       
       <x-sidebar 
           classType="shopping-bag" 
           title="Products" 
           :links="[
               ['url' => route('dashboard.products.index'), 'label' => 'Products'],
               // ['url' => route('dashboard.products.trash'), 'label' => 'Products Trash']
           ]" 
       />

       <x-sidebar 
       classType="shopping-cart 9" 
       title="Orders" 
       :links="[
           ['url' => route('dashboard.orders.index'), 'label' => 'Orders'],
          //  ['url' => route('dashboard.orders.trash'), 'label' => 'Categories Trash']
       ]" 
   />

   <x-sidebar 
   classType="fa fa-tags" 
   title="Coupons" 
   :links="[
       ['url' => route('dashboard.product_coupons.index'), 'label' => 'Coupons'],
      //  ['url' => route('dashboard.orders.trash'), 'label' => 'Categories Trash']
   ]" 
/>

<x-sidebar 
classType="fa-solid fa-star" 
title="Reviews"  
:links="[
    ['url' => route('dashboard.product_reviews.index'), 'label' => 'Reviews'],
   //  ['url' => route('dashboard.orders.trash'), 'label' => 'Categories Trash']
]" 
/>

<x-sidebar 
classType="fa-solid fa-star" 
title="Customer"  
:links="[
    ['url' => route('dashboard.customer.index'), 'label' => 'Customer'],
   //  ['url' => route('dashboard.orders.trash'), 'label' => 'Categories Trash']
]" 
/>
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