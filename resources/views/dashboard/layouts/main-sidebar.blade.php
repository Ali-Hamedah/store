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