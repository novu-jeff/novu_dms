
<ul class="sidebar-nav-list">
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" data-label="Dashboard" title="Dashboard">
            <span class="icon"><i class="lni lni-grid-alt"></i></span>
            <span class="text">Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('document_management.*') ? 'active' : '' }}">
        <a href="{{ route('document_management.index') }}"
           data-label="Document Management" title="Document Management">
            <span class="icon"><i class="lni lni-files"></i></span>
            <span class="text">Document Management</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('document_finder.*') ? 'active' : '' }}">
        <a href="{{ route('document_finder.index') }}"
           data-label="Document Finder" title="Document Finder">
            <span class="icon"><i class="lni lni-search-alt"></i></span>
            <span class="text">Document Finder</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('folders.*') ? 'active' : '' }}">
        <a href="{{ route('folders.index') }}"
           data-label="Folder Management" title="Folder Management">
            <span class="icon"><i class="lni lni-folder"></i></span>
            <span class="text">Folder Management</span>
        </a>
    </li>

    
@php
    $locationActive = request()->routeIs(
        'branches.*',
        'departments.*',
        'divisions.*',
        'sections.*'
    );
@endphp

<li class="nav-item nav-item-has-children {{ $locationActive ? 'active' : '' }}">
    <a href="#ddmenu_1"
       class="location-menu-toggle {{ $locationActive ? 'active' : '' }}"
       data-label="Location Management"
       title="Location Management"
       data-bs-toggle="collapse"
       data-bs-target="#ddmenu_1"
       aria-controls="ddmenu_1"
       aria-expanded="{{ $locationActive ? 'true' : 'false' }}">

        <span class="icon">
            <i class="lni lni-map-marker"></i>
        </span>

        <span class="text">Location Management</span>

        <i class="lni lni-chevron-down ms-auto location-chevron"></i>
    </a>

    <ul id="ddmenu_1"
        class="dropdown-nav collapse {{ $locationActive ? 'show' : '' }}">

        <li>
            <a href="{{ route('branches.index') }}"
               class="{{ request()->routeIs('branches.*') ? 'active' : '' }}">
                <span class="text">Branch</span>
            </a>
        </li>

        <li>
            <a href="{{ route('departments.index') }}"
               class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">
                <span class="text">Department</span>
            </a>
        </li>

        <li>
            <a href="{{ route('divisions.index') }}"
               class="{{ request()->routeIs('divisions.*') ? 'active' : '' }}">
                <span class="text">Division</span>
            </a>
        </li>

        <li>
            <a href="{{ route('sections.index') }}"
               class="{{ request()->routeIs('sections.*') ? 'active' : '' }}">
                <span class="text">Section</span>
            </a>
        </li>
    </ul>
</li>
{{-- Organization Settings --}}
<li class="nav-item {{ request()->routeIs('settings.organization.*') ? 'active' : '' }}">
    <a href="{{ route('settings.organization.edit') }}"
       data-label="Organization Settings"
       title="Organization Settings">
        <span class="icon">
            <i class="lni lni-cog"></i>
        </span>
        <span class="text">Organization Settings</span>
    </a>
</li>

</ul>
