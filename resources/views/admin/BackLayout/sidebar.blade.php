<!-- Brand Logo -->
<a href="{{route('dashboard')}}" class="brand-link">
<img src="{{ asset('dist/img/adminlogo.png') }}" alt="Catchin Munchies Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
<!-- <span class="brand-text font-weight-light">Catchin Munchies</span> -->
</a>
<!-- Sidebar -->
<div class="sidebar">
   <div class="form-inline">
   </div>
   <!-- Sidebar Menu -->
   <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library menu-open-->
         <li class="nav-item ">
            <a href="#" class="nav-link  {{ @($active_menu == 'UserManagement') ? 'active' : ''}}">
               <i class="fas fa-users"></i>
               <p>
                  Users Management
                  <i class="right fas fa-angle-left"></i>
               </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item {{ @($active_submenu == 'CustomerList') ? 'active' : ''}}">
                  <a href="{{route('admin.customer')}}" class="nav-link active">
                     <p>Customer List</p>
                  </a>
               </li>
               <li class="nav-item {{ @($active_submenu == 'VendorList') ? 'active' : ''}}">
                  <a href="{{route('admin.vendor')}}" class="nav-link active">
                     <p>Vendor List</p>
                  </a>
               </li>
            </ul>
         </li>
         <li class="nav-item">
            <a href="#" class="nav-link {{ @($active_menu == 'CategoryManagement') ? 'active' : ''}}">
               <i class="fas fa-list-alt"></i>
               <p>
                  Category Management
                  <i class="right fas fa-angle-left"></i>
               </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item {{ @($active_submenu == 'VendorList') ? 'active' : ''}}">
                  <a href="{{route('categories.add')}}" class="nav-link active">
                     <p>Add Category</p>
                  </a>
               </li>
               <li class="nav-item">
                  <a href="{{route('categories.index')}}" class="nav-link active">
                     <p>Category List</p>
                  </a>
               </li>
            </ul>
         </li>
         <li class="nav-item">
            <a href="#" class="nav-link {{ @($active_menu == 'CMSManagement') ? 'active' : ''}}">
               <i class="fas fa-list-alt"></i>
               <p>
                  CMS Management
                  <i class="right fas fa-angle-left"></i>
               </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                  <a href="{{route('admin.v1.cms.index')}}" class="nav-link active">
                     <p>List</p>
                  </a>
               </li>
            </ul>
         </li>
         <li class="nav-item">
            <a href="#" class="nav-link {{ @($active_menu == 'PaymentManagement') ? 'active' : ''}}">
               <i class="fas fa-list-alt"></i>
               <p>
                  Payment Management
                  <i class="right fas fa-angle-left"></i>
               </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                  <a href="{{route('payment.management')}}" class="nav-link active">
                     <p>List</p>
                  </a>
               </li>
            </ul>
         </li>
         <li class="nav-item">
            <a href="#" class="nav-link {{ @($active_menu == 'SiteSetting') ? 'active' : ''}}">
               <i class="fas fa-cog"></i>
               <p>
                  Site Setting
                  <i class="right fas fa-angle-left"></i>
               </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                  <a href="{{route('site-setting')}}" class="nav-link active">
                     <p>List</p>
                  </a>
               </li>
            </ul>
         </li>
      </ul>
   </nav>
   <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
