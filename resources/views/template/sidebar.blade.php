<!--sidebar wrapper -->
<div  class="sidebar-wrapper" data-simplebar="true">
	<div class="sidebar-header">
		<div>
			<img src="#" class="logo-icon" alt="logo icon">
		</div>
		<div>
			<h4 class="logo-text">Syndron</h4>
		</div>
		<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
		</div>
	</div>
	<!--navigation-->



	<ul class="metismenu" id="menu">
		<li>
			<a href="#">
				<div class="parent-icon"><i class='bx bx-home-circle'></i>
				</div>
				<div class="menu-title">Dashboard </div>
			</a>
		</li>
		<li class="menu-label">Core Human Resources</li>
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class='bx bx-cart'></i>
				</div>
				<div class="menu-title">Master Core HR</div>
			</a>
			<ul>
				<li> <router-link to="data-jabatan"><i class="bx bx-right-arrow-alt"></i>Jabatan</router-link>
				</li>
				<li> <router-link to="data-grade"><i class="bx bx-right-arrow-alt"></i>Grade</router-link>
				</li>
				<li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Golongan</a>
				</li>
				<li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Peringatan</a>
				</li>
				<li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Pendidikan</a>
				</li>
				<li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Cuti</a>
				</li>
				<li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Gaji</a>
				</li>
			</ul>
		</li>
		@foreach ($akses as $v)
		<li class="menu-label">{{$v->judul}}</li>
		<li>
			<a href="javascript:;" class="has-arrow">
				<div class="parent-icon"><i class='bx bx-cart'></i>
				</div>
				<div class="menu-title">{{$v->menu}}</div>
			</a>
			<ul>
				@foreach ($sub as $va)
				<li> <a href="{{$va->url}}"><i class="bx bx-right-arrow-alt"></i>{{$va->title}}</a>
				</li>
				@endforeach
			</ul>
		</li>
		@endforeach
	</ul>
	<!--end navigation-->
</div>
<!--end sidebar wrapper -->