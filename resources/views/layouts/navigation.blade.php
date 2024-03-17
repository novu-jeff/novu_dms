<ul>
    <!--
    <li class="nav-item @if(request()->routeIs('home')) active @endif">
        <a href="{{ route('home') }}">
              <span class="icon">
                <svg width="22" height="22" viewBox="0 0 22 22">
                  <path
                          d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z"
                  />
                </svg>
              </span>
            <span class="text">{{ __('Dashboard') }}</span>
        </a>
    </li>
    -->

    <li class="nav-item @if(request()->routeIs('document_management.index')) active @endif">
        <a href="{{ route('document_management.index') }}">
              <span class="icon">
                <?xml version="1.0" encoding="utf-8"?>
                <!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <svg fill="#1C2033" width="22" height="22" version="1.1" id="lni_lni-book" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                <g>
                    <path d="M39.6,50.1H24.4c-1.2,0-2.3,1-2.3,2.3s1,2.3,2.3,2.3h15.3c1.2,0,2.3-1,2.3-2.3S40.9,50.1,39.6,50.1z"/>
                    <path d="M24.1,34.3h15.8c2.3,0,4.3-1.9,4.3-4.3v-5.9c0-2.3-1.9-4.3-4.3-4.3H24.1c-2.3,0-4.3,1.9-4.3,4.3V30
                        C19.9,32.3,21.8,34.3,24.1,34.3z M24.4,24.4h15.3v5.4H24.4V24.4z"/>
                    <path d="M17,6.3h35.4c1.2,0,2.3-1,2.3-2.3s-1-2.3-2.3-2.3H17c-4,0-7.2,3.1-7.5,7c0,0.1,0,0.2,0,0.3v47c0,3.4,2.9,6.1,6.5,6.1h32.9
                        c2.8,0,5.1-2.3,5.1-5.1V17c0-2.8-2.3-5.1-5.1-5.1H16.7c0,0,0,0,0,0c0,0,0,0,0,0c-1.7,0-2.7-1-2.7-2.6C13.9,7.6,15.3,6.3,17,6.3z
                         M16.6,16.4C16.6,16.4,16.7,16.4,16.6,16.4C16.7,16.4,16.7,16.4,16.6,16.4h32.2c0.3,0,0.6,0.3,0.6,0.6v40.2c0,0.3-0.3,0.6-0.6,0.6
                        H15.9c-1.1,0-2-0.7-2-1.6V16C14.7,16.3,15.6,16.4,16.6,16.4z"/>
                </g>
                </svg>


              </span>
            <span class="text">{{ __('Document Management') }}</span>
        </a>
    </li>

    <li class="nav-item @if(request()->routeIs('document_finder.index')) active @endif">
        <a href="{{ route('document_finder.index') }}">
              <span class="icon">
                <?xml version="1.0" encoding="utf-8"?>
                <!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <svg fill="#1C2033" width="22" height="22" version="1.1" id="lni_lni-keyword-research" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                <g>
                    <path d="M60.7,50.6L47.6,37.5c-1.9-1.9-5-2-7.1-0.3l-5.1-5.1c5.8-7.4,5.3-18.1-1.5-24.9c-7.3-7.3-19.3-7.3-26.6,0s-7.3,19.3,0,26.6
                        c3.7,3.7,8.5,5.5,13.3,5.5c4.1,0,8.2-1.3,11.6-4l5.1,5.1c-1.8,2.1-1.7,5.2,0.3,7.1l13.1,13.1c1,1,2.4,1.5,3.7,1.5
                        c1.3,0,2.7-0.5,3.7-1.5l2.6-2.6C62.7,56,62.7,52.7,60.7,50.6z M10.4,30.7c-5.6-5.6-5.6-14.7,0-20.3c2.8-2.8,6.5-4.2,10.1-4.2
                        s7.3,1.4,10.1,4.2c5.6,5.6,5.6,14.7,0,20.3C25.1,36.3,16,36.3,10.4,30.7z M57.5,54.9l-2.6,2.6c-0.3,0.3-0.8,0.3-1.1,0L40.7,44.4
                        c-0.3-0.3-0.3-0.8,0-1.1l2.6-2.6c0.1-0.1,0.3-0.2,0.5-0.2s0.4,0.1,0.5,0.2l13.1,13.1C57.8,54.1,57.8,54.6,57.5,54.9z"/>
                    <path d="M15.6,19.2h4.9c1.2,0,2.3-1,2.3-2.3s-1-2.3-2.3-2.3h-4.9c-1.2,0-2.3,1-2.3,2.3S14.3,19.2,15.6,19.2z"/>
                    <path d="M25.8,22.1H15.6c-1.2,0-2.3,1-2.3,2.3s1,2.3,2.3,2.3h10.2c1.2,0,2.3-1,2.3-2.3S27,22.1,25.8,22.1z"/>
                </g>
                </svg>

              </span>
            <span class="text">{{ __('Document Finder') }}</span>
        </a>
    </li>

    <li class="nav-item @if(request()->routeIs('folders.index')) active @endif">
        <a href="{{ route('folders.index') }}">
            <span class="icon">
                <?xml version="1.0" encoding="utf-8"?>
                <!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <svg fill="#1C2033" width="22" height="22" version="1.1" id="lni_lni-folder" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                <path d="M61,19.6v-3.3c0-3.4-2.7-6.1-6.1-6.1H32.7l-0.3-0.8c-0.7-1.8-2.4-2.9-4.3-2.9H7.9c-3.4,0-6.1,2.7-6.1,6.1v38.9
                    c0,3.4,2.7,6.1,6.1,6.1h48.3c3.4,0,6.1-2.7,6.1-6.1V22.7C62.3,21.5,61.8,20.4,61,19.6z M54.9,14.6c0.9,0,1.6,0.7,1.6,1.6v1.9H35.9
                    l-1.4-3.5H54.9z M57.8,51.5c0,0.9-0.7,1.6-1.6,1.6H7.9c-0.9,0-1.6-0.7-1.6-1.6V12.5c0-0.9,0.7-1.6,1.6-1.6L28.2,11l4.1,10.2
                    c0.3,0.9,1.2,1.4,2.1,1.4h23.3c0,0,0.1,0,0.1,0.1V51.5z"/>
                </svg>


            </span>
            <span class="text">{{ __('Folder Management') }}</span>
        </a>
    </li>

    <li class="nav-item nav-item-has-children">
        <a class="collapsed" href="#0" class="" data-bs-toggle="collapse" data-bs-target="#ddmenu_1"
           aria-controls="ddmenu_1" aria-expanded="true" aria-label="Toggle navigation">
            <span class="icon">
                <?xml version="1.0" encoding="utf-8"?>
                <!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <?xml version="1.0" encoding="utf-8"?>
                <!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <svg fill="#1C2033" width="22" height="22" version="1.1" id="lni_lni-map-marker" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                <g>
                    <path d="M32,1.8C18.2,1.8,7,12.6,7,25.9C7,36,20.4,52,28.3,60.6c1,1.1,2.3,1.6,3.7,1.6c1.4,0,2.7-0.6,3.7-1.6
                        C43.6,52,57,36,57,25.9C57,12.6,45.8,1.8,32,1.8z M32.4,57.6c-0.2,0.2-0.5,0.2-0.8,0C21.9,47,11.5,33.2,11.5,25.9
                        c0-10.8,9.2-19.6,20.5-19.6s20.5,8.8,20.5,19.6C52.5,33.2,42.1,47,32.4,57.6z"/>
                    <path d="M32,15.7c-6,0-10.9,4.9-10.9,10.9S26,37.6,32,37.6s10.9-4.9,10.9-10.9S38,15.7,32,15.7z M32,33.1c-3.6,0-6.4-2.9-6.4-6.4
                        s2.9-6.4,6.4-6.4s6.4,2.9,6.4,6.4S35.6,33.1,32,33.1z"/>
                </g>
                </svg>



            </span>
            <span class="text">Location Management</span>
        </a>
        <ul id="ddmenu_1" class="dropdown-nav collapse" style="">
            <li>
                <a href="{{ route('branches.index') }}">Branch</a>
            </li>
            <li>
                <a href="{{ route('departments.index') }}">Department</a>
            </li>
            <li>
                <a href="{{ route('divisions.index') }}">Division</a>
            </li>
            <li>
                <a href="{{ route('sections.index') }}">Section</a>
            </li>
        </ul>
    </li>
</ul>
