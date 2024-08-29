<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var coursesLink = document.getElementById('courses-link');
        var coursesSection = document.getElementById('getcourses');

        coursesLink.addEventListener('click', function(e) {
            e.preventDefault();
            coursesSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    });
</script>


<style>
    .sub_menu_main_heading span {
        text-transform: lowercase !important;
    }

    em {
        font-size: 11px;
        font-style: normal;
    }

    .sign_in_btn {
        background: transparent !important;
        border: 1px solid #fff !important;
        font-weight: 900 !important;
    }

    .sign_up_btn {
        color: #a30a0a !important;
        font-weight: 900 !important;
        background: #fff;
    }

    .mydashboard {
        color: #a30a0a !important;
        font-weight: 900 !important;
        height: 43px;
        display: flex !important;
        align-items: center; 
        background: #fff;
        /* display: block !important; */
    }

    @media (max-width: 500px) {

        .sign_in_btn {
            background: transparent !important;
            border: 1px solid #a30a0a !important;
            color: #a30a0a !important;
        }

        .sign_up_btn {
            color: #fff !important;
            background: #a30a0a;
        }
    }
</style>

<div class="header header-light dark-text">

    <div class="container-fluid">

        <nav id="navigation" class="navigation navigation-landscape">

            <div class="nav-header">

                <a class="nav-brand" href="{{ route('front.index') }}">

                    <h2 style="color:#fff; margin-bottom: 0px;">Etcetra</h2>

                </a>

                <div class="nav-toggle"></div>

                <div class="mobile_nav">
                    <ul>
                        
                        @auth
                            <ul class="nav-menu nav-menu-social">
                                
                                <li class="add-listing theme-bg">

                                    @role('user')
                                        <a href="{{ route('admin.v1.dashboard') }}" class="mydashboard">My dashboard</a>
                                    @else
                                        <a href="{{ route('admin.v1.dashboard') }}" class="mydashboard">Dashboard</a>
                                    @endrole
                                    <a href="{{ route('logout') }}"><i class="ft-power"></i> Logout</a>
                                </li>
                            </ul>
                            @else
                            <li>
                                <a href="/login" class="crs_yuo12">
                                    <span class="embos_45" style="color: #fff"><i class="fas fa-sign-in-alt"></i></span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

            </div>

            <div class="nav-menus-wrapper">

                <ul class="nav-menu">



                    <li><a href="{{ route('front.index') }}" class="">Home</a></li>


                    </li>

                    <li>
                        {{-- <a href="{{ route('front.course') }}">Courses<span class="submenu-indicator"></span></a> --}}
                        
                        {{-- <a href="#getcourses" id="courses-link" style="cursor: pointer">Courses</a> --}}
                        <a href="/#getcourses" class="">Courses</a>
                        
                        {{-- add class to show dropdowm (nav-dropdown nav-submenu) --}}
                        {{-- <ul class="courser_header_table d-none"style="overflow-x:auto; ">
                           
                            <table>
                                <thead class="table-primary">
                                    <tr>
                                        <td>
                                            <h2 class="sub_menu_main_heading">Classifications</h2>
                                        </td>
                                        <td>
                                            <h2 class="sub_menu_main_heading">Categories</h2>
                                        </td>
                                        <td colspan="24">
                                            <h2 class="sub_menu_main_heading">Sub <span> categoriess</span></h2>
                                        </td>
                                    </tr>
                                </thead>




                                <?php $category = App\Models\Categories::with('childcat')
                                    ->where('parent', null)
                                    ->select('id', 'name')
                                    ->orderBy('order', 'ASC')
                                    ->get()
                                    ->toArray(); ?>
                                @foreach ($category as $key => $subcat)
                                    <tbody
                                        class="@if ($key == 1 || $key == 7) table-secondary 
									@elseif($key == 2)table-success 
									@elseif($key == 3 || $key == 8)table-danger 
									@elseif($key == 4 || $key == 9)table-info 
									@elseif($key == 5 || $key == 10)table-warning 
									@elseif($key == 0 || $key == 6)table-primary @endif"
                                        style="@if ($key == 1 || $key == 7) background-color:#d8dde4 
									@elseif($key == 2)table-success 
									@elseif($key == 3 || $key == 8)table-danger 
									@elseif($key == 4 || $key == 9)table-info 
									@elseif($key == 5 || $key == 10)table-warning 
									@elseif($key == 0 || $key == 6)background-color:#96beeb @endif">

                                        <tr>
                                            <th rowspan="6" class="first_col_headings"> <a
                                                    href="{{ route('front.category', ['category' => $subcat['name']]) }}">{{ $subcat['name'] }}
                                                </a></th>
                                        </tr>


                                        @foreach ($subcat['childcat'] as $ssubcat)
                                            <tr
                                                style="@if ($key == 1 || $key == 7) background-color:#d8dde4 
									   @elseif($key == 2)table-success 
									   @elseif($key == 3 || $key == 8)table-danger 
									   @elseif($key == 4 || $key == 9)table-info 
									   @elseif($key == 5 || $key == 10)table-warning 
									   @elseif($key == 0 || $key == 6)background-color:#96beeb @endif">

                                                <td class="second_col"
                                                    style="@if ($key == 1 || $key == 7) background-color:#d8dde4 @elseif($key == 2)table-success 
										@elseif($key == 3 || $key == 8)table-danger 
										@elseif($key == 4 || $key == 9)table-info 
										@elseif($key == 5 || $key == 10)table-warning 
										@elseif($key == 0 || $key == 6)background-color:#96beeb @endif">
                                                    <a
                                                        href="{{ route('front.category', ['category' => $ssubcat['name']]) }}">
                                                        {{ $ssubcat['name'] }}</a>
                                                </td>

                                                @if ($ssubcat['childcat'])
                                                    @foreach ($ssubcat['childcat'] as $sssubcat)
                                                        <?php $countdata = count($ssubcat['childcat']) ? count($ssubcat['childcat']) : 1;
                                                        $totcolspan = 24;
                                                        $finalcolspan = $totcolspan / $countdata;
                                                        $finaroundspan = round($finalcolspan);
                                                        ?>
                                                        <td colspan="{{ $finaroundspan }}" class="third_col col-auto"
                                                            style="
												@if ($key == 1 || $key == 7) background-color:#e4e5e7 
												@elseif($key == 2)table-success 
												@elseif($key == 3 || $key == 8)table-danger 
												@elseif($key == 4 || $key == 9)table-info 
												@elseif($key == 5 || $key == 10)table-warning 
												@elseif($key == 0 || $key == 6)background-color:#92c1f5 @endif">
                                                            <a
                                                                href="{{ route('front.course', ['category' => $sssubcat['name']]) }}">
                                                                {{ $sssubcat['name'] }} </a></td>
                                                    @endforeach
                                                @else
                                                    <td colspan="24" class="third_col col-auto"
                                                        style="
												@if ($key == 1 || $key == 7) background-color:#e4e5e7 
												@elseif($key == 2)table-success 
												@elseif($key == 3 || $key == 8)table-danger 
												@elseif($key == 4 || $key == 9)table-info 
												@elseif($key == 5 || $key == 10)table-warning 
												@elseif($key == 0 || $key == 6)background-color:#92c1f5 @endif">
                                                    </td>
                                                @endif

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                @endforeach


                            </table>
                        </ul> --}}
                    </li>


                    {{-- <li><a href="{{ route('front.about') }}">About Us<span class="submenu-indicator"></span></a></li> 	--}}
                    <li><a href="{{ route('front.how_it_works') }}">How it works</a></li>

                </ul>

                @guest

                    <ul class="nav-menu nav-menu-social align-to-right">



                    <li class="add-listing" style=" top: 14px;">
                            <a href="/login" class="sign_in_btn" >
                                {{-- data-toggle="modal" data-target="#login" --}}

                                {{-- <i class="fas fa-sign-in-alt mr-1"></i> --}}
                                <span class="dn-lg">Sign In <br><em>(Existing users)</em></span>

                            </a>

                        </li>


                        <!-- <li class="add-listing" style=" top: 14px;">
                            <a href="/login" class="sign_in_btn" data-toggle="modal" data-target="#login">
                                {{-- data-toggle="modal" data-target="#login" --}}

                                {{-- <i class="fas fa-sign-in-alt mr-1"></i> --}}
                                <span class="dn-lg">Sign In <br><em>(Existing users)</em></span>

                            </a>

                        </li> -->

                        <li class="add-listing theme-bg" style=" top: 14px;">

                            <a href="{{ route('front.signup') }}" class="sign_up_btn">Sign Up <br> <em>(New users)</em></a>

                        </li>

                    </ul>

                @endguest



                @auth

                    <ul class="nav-menu nav-menu-social align-to-right">
                        @if (Auth()->user()->role == 2)
                        <li class="dropdown dropdown-user nav-item">

                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="avatar avatar-online">
                                <!--<i class="ft-users float-right"></i>-->
                                Hello {{ auth()->user()->name }}
                            </span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">

                            <div class="arrow_box_right">

                                @if (Auth()->user()->role == 2 || (isset($permission->changepassword) && $permission->changepassword))

                                    <a class="dropdown-item" href="{{ route('admin.v1.appuser.changepassword') }}">

                                        <i class="ft-lock"></i>Change Password</a>

                                    <div class="dropdown-divider"></div>

                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}">

                                    <i class="ft-power"></i> Logout

                                </a>

                            </div>

                        </div>

                    </li>
                    @endif
                        <li class="add-listing theme-bg">

                            @role('user')
                                <a href="{{ route('admin.v1.dashboard') }}" >My dashboard</a>
                            @else
                                <a href="{{ route('admin.v1.dashboard') }}" class="mydashboard">Dashboard</a>
                            @endrole
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"><i class="ft-power"></i> Logout</a>
                        </li>
                        
                    </ul>

                @endauth



            </div>

        </nav>

    </div>




</div>

<!-- End Navigation -->

<div class="clearfix"></div>

<!-- ============================================================== -->

<!-- Top header  -->
</div>
