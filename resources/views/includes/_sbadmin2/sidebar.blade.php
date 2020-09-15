<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="http://laxyo.org/">
    <div class="sidebar-brand-icon rotate-n-15" style="transform: rotate(3deg)">
      <img class="img-profile rounded-circle" src="http://www.laxyo.com/images/favicon.png" style="width: 40px; ">
    </div>
    <div class="sidebar-brand-text mx-3">Laxyo <sup>ERP</sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{'/home'}}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
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
      <i class="fas fa-fw fa-cog"></i>
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
    <a class="nav-link" href="{{ route('manager_request') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Request For Item</span></a>
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
      <i class="fas fa-fw fa-cog"></i>
      <span>Request For Items (RFI)</span>
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
<!-- End of Sidebar -->
