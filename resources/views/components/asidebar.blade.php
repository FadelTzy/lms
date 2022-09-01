<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">LMS</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Menu</li>
        <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
            <a href="{{ route('admin') }}" class="nav-link "><i
                    class="fas fa-fire"></i><span>Dashboard</span></a>
        </li>
     
        <li class="menu-header">Manajemen Data</li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Data User</span></a>
            <ul class="dropdown-menu">
              <li><a class="nav-link" href="{{route('mahasiswa.index')}}">Data Mahasiswa</a></li>
              <li><a class="nav-link" href="{{route('dosen.index')}}">Data Dosen </a></li>
              <li><a class="nav-link" href="{{route('admin.index')}}">Data Admin</a></li>
            </ul>
          </li>
        <li class="nav-item {{ Request::segment(2) == 'data-matkul' ? 'active' : '' }}">
            <a href=" {{ route('matkul.index') }}" class="nav-link"><i class="fas fa-columns"></i>
                <span>Data Mata Kuliah</span></a>

        </li>
        <li class="nav-item {{ Request::segment(2) == 'data-pembelajaran' ? 'active' : '' }}">
            <a href=" {{ route('pembelajaran.index') }}" class="nav-link"><i class="fas fa-columns"></i>
                <span>Data Pembelajaran</span></a>

        </li>

        <li class="menu-header">Manajemen Admin</li>
        <li class="{{ Request::segment(2) == 'data-pengaturan' ? 'active' : '' }}"><a class="nav-link"
            href="{{ route('pengaturan.index') }}"><i class="fas fa-pencil-ruler"></i>
            <span>Pengaturan</span></a></li>
        <li class="{{ Request::segment(1) == 'profil' ? 'active' : '' }}"><a class="nav-link"
            href="{{ url('profil') }}"><i class="fas fa-pencil-ruler"></i>
            <span>Profil Admin</span></a></li>
     
    </ul>

    <div class=" mb-4 p-3 hide-sidebar-mini">
        <a href="#" id="" onclick="logsout()" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Keluar
        </a>
        <form method="POST" id="flog" class="" action="{{ route('logout') }}">
            @csrf
        </form>
    </div>
</aside>
<script>
    function logsout() {
        var x = document.getElementById('flog');
        x.submit();
    }
</script>
