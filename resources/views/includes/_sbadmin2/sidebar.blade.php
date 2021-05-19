<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="https://laxyo.org/" style="background-color: #dbf4fd">
    <div class="sidebar-brand-icon rotate-n-15" style="transform: rotate(1deg); ">
      <img class="img-profile " src="https://www.laxyo.org/images/logos/logo.png" height="25">
    </div>
    <!-- <div class="sidebar-brand-text mx-3"><sup>ERP</sup></div> -->
  </a>
  <li class="nav-item active" style="background-color: #dbf4fd">
    
      @php $avatar = 'https://hrms.laxyo.org/storage/'.trim(Session::get('avatar'), 'public'); @endphp
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{$avatar}}" alt="User Image" width="100" height="100">
    <div>
      <span style="margin-right: 10px; font-family: bold; font-size: 15px; color: #404040;">{{ ucwords(auth()->user()->name) }}
      </span>
    </div>
  </div>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active" style="background-color: #dbf4fd; color: #404040">
    <a class="nav-link" href="{{'/home'}}">
      <i class="fas fa-fw fa-tachometer-alt" style="color: #404040"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading" style="color: #404040">
    Interface
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
	
	@role("purchase_superadmin")
	<!-- <li class="nav-item">
	    <a class="nav-link" href="{{ '/role' }}">
	      <i class="fa fa-lock" aria-hidden="true"></i>
	      <span>Assign Role</span></a>
	  </li>
	
	  <li class="nav-item">
	    <a class="nav-link" href="{{ '/members' }}">
	      <i class="fa fa-plus" aria-hidden="true"></i>
	      <span>Members</span></a>
	  </li> -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
      <i class="fas fa-fw fa-shopping-cart"></i>
      <span>Items</span>
    </a>
    <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('item.create') }}">Create Item</a>
        <a class="collapse-item" href="{{ route('item.index') }}">Items Listing</a>
      </div>
    </div>
  </li>
  
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog" ></i>
      <span>Vendors</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('vendor.create') }}">Create Vendor</a>
        <a class="collapse-item" href="{{ route('vendor.index') }}">Vendor Listing</a>
      </div>
    </div>
  </li>

	<li class="nav-item">
    <a class="nav-link" href="{{ route('store_item.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Warehouse Items</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('items_approval') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Request for Items</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('quotation_received_leveltwo') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Received Quotation</span></a>
  </li>

	<!-- <li class="nav-item">
    <a class="nav-link" href="{{ route('purchase.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Purchase</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ '/item_purchase_history' }}">
      <i class="fa fa-history" aria-hidden="true"></i>
      <span>Purchase History</span></a>
  </li> -->

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">Setting</div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
      <i class="fas fa-fw fa-folder"></i>
      <span>Masters</span>
    </a>
    <div id="collapse2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ '/um' }}">Units of Measurement</a>
        <a class="collapse-item" href="{{ '/category' }}">Items Category</a>
        <a class="collapse-item" href="{{ '/subcategory' }}">Items Subcategory</a>
        <a class="collapse-item" href="{{ '/warehouse' }}">Warehouses</a>
        <a class="collapse-item" href="{{ '/gst_state_code' }}">GST States</a>
        <a class="collapse-item" href="{{ '/department' }}">Department</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
	@endrole
	
	@role("purchase_admin")
	<li class="nav-item">
    <a class="nav-link" href="{{ route('manager_approval') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>RFI by Users</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('quotation_received_levelone') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Received Quotation</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('store_item.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Warehouse Items</span></a>
  </li>
	@endrole

	@role("purchase_manager")
	<li class="nav-item">
    <a class="nav-link" href="{{ route('user_request') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>RFI by Users</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dispatch_item') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Ready to Dispatch</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('manager_request') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Request For Item</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('disable-to-dispatch') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Unavailable Item</span></a>
  </li>

  <!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
      <i class="fas fa-fw fa-cog"></i>
      <span>Request For Item</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('request_for_item.create') }}">Create RFI</a>
        <a class="collapse-item" href="{{ route('request_for_item.index') }}">RFI Listing</a>
      </div>
    </div>
  </li> -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('store_item.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Warehouse Items</span></a>
  </li>


	<li class="nav-item">
    <a class="nav-link" href="{{ route('rfq.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>View Request Quotations</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('approval_quotation') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Approval Quotation</span></a>
  </li>
  @endrole

  {{-- @role(4)
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
      <i class="fas fa-fw fa-cog"></i>
      <span>Request For Items (RFI)</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('request_for_item.create') }}">Create RFI</a>
        <a class="collapse-item" href="{{ route('request_for_item.index') }}">RFI Listing</a>
      </div>
    </div>
  </li>
  @endrole --}}

	@role("purchase_user")
	<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog" style="color: #404040"></i>
      <span style="color: #404040">Request For Items (RFI)</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('request_for_item.create') }}">Create RFI</a>
        <a class="collapse-item" href="{{ route('request_for_item.index') }}">RFI Listing</a>
      </div>
    </div>
  </li>
	@endrole
	
	@role("store_admin")
  <li class="nav-item admin_css">
    <a class="nav-link" href="{{ route('store_item.index') }}">
      <i class="fas fa-fw fa-shopping-cart"></i>
      <span class="admin_css">Items</span>
    </a>
  </li>
  
	<li class="nav-item">
    <a class="nav-link" href="{{ route('store_management.index') }}">
      <i class="fas fa-fw fa-chart-area admin_css"></i>
      <span class="admin_css">PO Received</span></a>
  </li>
    <li class="nav-item">
    <a class="nav-link" href="{{ route('item_of_stock') }}">
      <i class="fas fa-fw fa-chart-area admin_css"></i>
      <span class="admin_css">Your Stock</span></a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="{{ route('un_item_of_stock') }}">
      <i class="fas fa-fw fa-chart-area admin_css"></i>
      <span class="admin_css">Req Item unable</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('view_grn') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span class="admin_css">Generate GRN</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('receiving') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span class="admin_css">Stock Transfer</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('approve_dc') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span class="admin_css">Approve Stock Transfer</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('users') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span class="admin_css">User Management</span></a>
  </li>
	@endrole

  <!-- @role("ratlam_warehouse"||"indore_warehouse")
  <li class="nav-item">
    <a class="nav-link" href="{{ route('store_item.index') }}">
      <i class="fas fa-fw fa-shopping-cart"></i>
      <span>Items</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('store_management.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>PO Received</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('view_grn') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Generate GRN</span></a>
  </li>
  @endrole -->

  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<style type="text/css">

.app-sidebar__user {
    display: flex;
    align-items: center;
    padding: 10px;
    margin-bottom: 20px;
    color: #fff;
}

img.app-sidebar__user-avatar {
    border-radius: 50% !important;
    margin-right: 15px;
}

.toggled .sidebar-brand img {
    width: 102%;
    height: 1%;
}

.toggled img.app-sidebar__user-avatar {
    width: 97%;
    height: 1%;
    /* margin-right: 29%; */
}
.bg-gradient-primary {
  background-color: #dbf4fd;
}
.sidebar-dark .nav-item.active .nav-link, .admin_css{
  color: #404040;
}

</style>

<!-- End of Sidebar -->
