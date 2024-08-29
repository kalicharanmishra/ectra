<style>
    .active {
        color: #2DCBC8 !important;
    }
    .breadcrumbs{
        font-size: 16px;
    font-weight: 800;
    color: #fff;
    padding-left: 5px;
    }

    .menu-content li a{
        position: relative;
        margin-left: -40px;
    }

    .brand-text{
        font-size: 1.2rem !important;
    font-weight: 900 !important;
    }
</style>

<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="{{ asset('thrill/v1/images/backgrounds/02.jpg') }}">

    <div class="navbar-header">

        <ul class="nav navbar-nav flex-row">

            <li class="nav-item mr-auto">

                <a class="navbar-brand" href="{{ route('admin.v1.dashboard') }}">

                    <!-- <img class="brand-logo" alt="Chameleon admin logo" src="images/logo/logo.png"/> -->

                    <h3 class="brand-text">@if (Auth::user()->can('course_add')) Teachers' Dashboard @else Mohita @endif</h3>

                </a>

            </li>

            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>

        </ul>

    </div>

    <div class="navigation-background"></div>

    <div class="main-menu-content">

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            @if (Auth::user()->can('course_add')) 

            {{--<li class="nav-item">

                <a href="{{ route('admin.v1.tutor.listid',Auth::user()->id) }}">

                    <span class="menu-title" data-i18n="">My profile</span>

                </a>

            </li>--}}
            <li class="nav-item  @if($acti['active'] == "admin_dash") active @endif ">

                <a  href="{{ route('admin.v1.tutor.listid',Auth::user()->id) }}" >

                    <span class="menu-title" data-i18n="">Personal Profile</span>

                </a>

            </li>
{{--
            @else

            <li class="nav-item  @if($acti['active'] == "user_dash") active @endif ">

                <a  href="{{ route('admin.v1.student.listid',Auth::user()->id) }}" >

                    <span class="menu-title" data-i18n="">Personal Profile</span>

                </a>

            </li>--}}

            @endif
        
        @if(auth()->user()->roles->pluck('name')[0] == "user")
            <li class="nav-item  @if($acti['active'] == "stud_dash") active @endif ">

                <a  href="{{ route('admin.v1.student.listid',Auth::user()->id) }}" >

                    <span class="menu-title" data-i18n="">Personal Profile</span>

                </a>

            </li>
        @endif

            @if (auth()->user()->can('appuser_view'))

             <li class="nav-item @if($acti['active'] == "user_dash") active @endif ">

                <a href="{{ route('admin.v1.appuser.list') }}" >

                    <span class="menu-title" data-i18n="">Our Students</span>

                </a>

            </li>

            @endif

            @if (Auth::user()->can('course_add')) 
            <li class="nav-item  @if($acti['active'] == "admin_dash") active @endif ">

                <a  href="#" >

                    <span class="menu-title" data-i18n="">Professional Profile</span>

                </a>

            </li>
            @endif

            @if (auth()->user()->can('appuser_view'))

             <li class="nav-item @if($acti['active'] == "teach_dash") active @endif">

                <a  href="{{ route('admin.v1.tutor.list') }}" >

                    <span class="menu-title" data-i18n="">Our Teachers</span>

                </a>

            </li>

            @endif

            @if (auth()->user()->can('appuser_view'))

             <li class="nav-item @if($acti['active'] == "team_dash") active @endif">

                <a href="{{ route('admin.v1.admin.list') }}">

                    <span class="menu-title" data-i18n="">Our Team</span>

                </a>

            </li>

            @endif

            @if (auth()->user()->can('category_view'))

            <li class=" nav-item @if($acti['active'] == "course_clafi") active @endif">

                <a href="javascript:void(0)">

                    <span class="menu-title" data-i18n="">Course categories</span>

                </a>

                <ul class="menu-content">

                    

            <li>

                                <a class="menu-item" href="{{ route('admin.v1.category.list') }}" >

                                 Categories list</a>

            </li>
             <li>

                                <a class="menu-item" href="{{ route('admin.v1.category.list') }}" >

                                Add categories </a>

            </li>

                </ul>

            </li>

            @endif



            

          

        @if (auth()->user()->can('course_view'))

        <li class=" nav-item @if($acti['active'] == "course") active @endif">

            <a href="{{ route('admin.v1.course.list') }}">

                <span class="menu-title" data-i18n=""> Courses listed </span>

            </a>

{{--

            <ul class="menu-content">

                <li>

                    <a class="menu-item" href="{{ route('admin.v1.course.list') }}">@if (auth()->user()->can('course_add'))  My Courses @else  Courses List @endif</a>

                </li>

                @if (Auth::user()->can('course_add'))

                                        <li><a class="menu-item" href="{{ route('admin.v1.course.add') }}">@if (auth()->user()->can('course_add')) Add course @else Add @endif</a></li>

                                        @endif

            </ul>
--}}
        </li>
        @else
        <li class=" nav-item @if($acti['active'] == "course") active @endif">

            <a href="{{ route('admin.v1.course.list') }}">

                <span class="menu-title" data-i18n=""> Registered Courses </span>

            </a>

        </li>
        @endif



        @if (auth()->user()->can('course_add'))

        <li class=" nav-item @if($acti['active'] == "attend") active @endif">

                    <a class="menu-item" href="{{ url('admin/v1/attendance/attendance-list') }}/{{ auth()->user()->id }}">Attendence Details</a>

        </li>

        @else

        <li class=" nav-item @if($acti['active'] == "attend") active @endif">

                    <a class="menu-item" href="{{ route('admin.v1.attendence.list') }}">Attendence Details</a>

        </li>

        @endif

      

        <li class=" nav-item @if($acti['active'] == "contact") active @endif">

            <a class="menu-item" href="{{ route('admin.v1.contactus_inquiry') }}">Contact us inquiry</a>

        </li>
      



        @if (auth()->user()->can('course_view'))

        <li class=" nav-item @if($acti['active'] == "paymentdet") active @endif">

            <a href="javascript:void(0)">
                <span class="menu-title" data-i18n="">Payment details</span>
            </a>

            <ul class="menu-content">

                <li>
                    <a class="menu-item" href="{{ route('admin.v1.paymentdetail.studentlist') }}/{{ auth()->user()->id }}">Student wise</a>
                </li>

                @if (Auth::user()->can('course_add'))
                     <li><a class="menu-item" href="{{ route('admin.v1.paymentdetail.courselist') }}/{{ auth()->user()->id }}">Course wise</a></li>
                 @endif
            </ul>
        </li>
        @else
        <li class=" nav-item @if($acti['active'] == "paymentdet") active @endif">

            <a href="{{ route('admin.v1.paymentdetail.studentlist') }}/{{ auth()->user()->id }}">
                <span class="menu-title" data-i18n="">Payment details</span>
            </a>
        </li>

        @endif



    



        @if (auth()->user()->can('course_add'))

        <li class=" nav-item  @if($acti['active'] == "transac") active @endif">

                    <a class="menu-item" href="{{ url('admin/v1/transaction/transaction-list') }}/{{ auth()->user()->id }}">Transaction</a>

        </li>

        

        {{--
        @else
        <li class=" nav-item @if($acti['active'] == "transac") active @endif">

        <a class="menu-item" href="{{ route('admin.v1.attendence.listtransaction') }}">Transaction ss</a>

        </li>--}}

        @endif

        



        @if (auth()->user()->can('hashtag_view'))

        <li class=" nav-item @if($acti['active'] == "hash") active @endif">

            <a href="{{ route('admin.v1.hashtags.list') }}">

                <i class="ft-settings"></i>

                <span class="menu-title" data-i18n="">Hash Tags</span>

            </a>

        </li>

        @endif





       

        @if (auth()->user()->can('withdrawal_view')))

        <!-- <li class=" nav-item">

            <a href="{{ route('admin.v1.withdraw.list') }}">

                <i class="ft-settings"></i>

                <span class="menu-title" data-i18n="">Transaction history</span>

            </a>

        </li> -->

        @endif



        @if (auth()->user()->can('banner_view'))

        <li class=" nav-item  @if($acti['active'] == "banner") active @endif">

            <a href="{{ route('admin.v1.banner.list') }}">

                <span class="menu-title" data-i18n="">Banners</span>

            </a>

        </li>

        @endif

        @if (auth()->user()->can('currency_view'))



        <li class=" nav-item  @if($acti['active'] == "currency") active @endif">

            <a href="javascript:void(0)">

                <i class="ft-settings"></i>

                <span class="menu-title" data-i18n="">Currencies</span>

            </a>

            <ul class="menu-content">

                <li>

                    <a class="menu-item" href="{{ route('admin.v1.currencies.list') }}">List Currencies</a>

                </li>

                @if (Auth()->user()->role == 2 || (isset($permission->currency_add) && $permission->currency_add))

                <li>

                    <a class="menu-item" href="{{ route('admin.v1.currencies.add') }}">Add

                        Currencies</a>

                </li>

                @endif

            </ul>

        </li>

        @endif

        @if (auth()->user()->can('cms_view'))

        <li class=" nav-item  @if($acti['active'] == "cms") active @endif">

            <a href="{{ route('admin.v1.cms.index') }}">

                <span class="menu-title" data-i18n="">Content Mangement</span>

            </a>

        </li>

        @endif

        @if (auth()->user()->can('set_notification'))

        <li class=" nav-item  @if($acti['active'] == "set_noti") active @endif">

            <a href="{{ route('admin.v1.settings.set-notification') }}">

                <span class="menu-title" data-i18n="">Set Notifications</span>

            </a>

        </li>

        @endif

        @if (auth()->user()->can('sitesetting_view'))

        <li class=" nav-item  @if($acti['active'] == "set_view") active @endif">

            <a href="javascript:void(0)">

                <span class="menu-title" data-i18n="">Settings</span>

            </a>

            <ul class="menu-content">

                <li>

                    <a class="menu-item" href="{{ route('admin.v1.settings.list') }}">List</a>

                </li>

                @if (auth()->user()->can('access_permission'))

                <li>

                            <a class="menu-item" href="{{ route('admin.v1.settings.permission') }}">Permission</a>

                        </li>

                @endif

            </ul>

        </li>

        <!-- <li class=" nav-item">

                    <a href="javascript:void(0)">

                        <i class="ft-settings"></i>

                        <span class="menu-title" data-i18n="">Report Management</span>

                    </a>

                    <ul class="menu-content">

                        <li>

                            <a class="menu-item" href="{{ route('admin.report.users') }}">Users</a>

                            <a class="menu-item" href="{{ route('admin.report.videos') }}">Videos</a>

                        </li>

                    </ul>

                </li> -->

        @endif







        {{-- <li class=" nav-item">

                <a href="">

                    <i class="icon-volume-2"></i>

                    <span class="menu-title" data-i18n="">Videos</span>

                </a>

            </li>

            <li class=" nav-item">

                <a href="">

                    <i class="ft-settings"></i>

                    <span class="menu-title" data-i18n="">Settings</span>

                </a>

                <ul class="menu-content">

                    <li>

                        <a class="menu-item" href="">Site settings</a>

                    </li>

                </ul>

            </li> --}}

        </ul>

    </div>

</div>


<!-- <script>
    document.querySelectorAll(".nav-item").forEach((ele) =>
  ele.addEventListener("click", function (event) {
    event.preventDefault();
    document.querySelectorAll(".nav-item")
      .forEach((ele) => ele.classList.remove("active"));
    this.classList.add("active")
  })
);
</script> -->