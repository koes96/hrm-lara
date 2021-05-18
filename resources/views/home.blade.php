        @include('template.head')
		<!--sidebar wrapper -->
        @include('template.sidebar')
		<!--start header -->
        @include('template.navbar')
		<!--end header -->
		<!--start page wrapper -->
		<div  class="page-wrapper">
			<div class="page-content">
				<router-view></router-view>
				{{-- <datatable-component></datatable-component> --}}
			</div>
		</div>
		<!--end page wrapper -->
        @include('template.footer')
        {{-- @include('template.script') --}}