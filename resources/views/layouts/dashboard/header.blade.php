<!--Header-part-->
<div id="header">
    <h1><a href="index.php">.</a></h1>
</div>
<!--close-Header-part-->


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse ">
    <ul class="nav">

        <li class="dropdown" id="profile-messages">
            <a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
                <i class="icon icon-user"></i>
                <span class="text">
                    @if (Auth::user()->gender == 'male')
                        M.
                    @else
                        Mme.
                    @endif
                    {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
                </span><b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('profile_edit') }}"><i class="icon-user"></i> {{ __('Edit Profile') }}</a></li>
                <li class="divider"></li>
                {{-- <li><a href="{{ route('settings') }}"><i class="icon-cog"></i> {{ __('Account Setting') }}</a></li>
                <li class="divider"></li> --}}
                <li><a href="{{route('logout')}}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="icon-key"></i> {{ __('Disconnection') }}</a></li>
                </ul>
            </li>
            <li>
            
                   
                    <a href="{{route('logout')}}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="icon-share-alt"></i> {{ __('Disconnection') }}</a>
                     <form  id="logout-form" method="POST" action="{{ route('logout') }}" tyle="display: none;">
                        @csrf
                </form>
         
          </li>
    </ul>
</div>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone sidebar_slid"><i class="icon icon-list-ul"></i> Menu</a>
    <ul class="sidebar_slid_ul">
        <li class="{{ request()->segment(1) == '' ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><i class="icon icon-home"></i> <span>{{ __('Dashboard') }}</span></a>
        </li>
        
        @cannot('Manager.Manager+.Delegue.Responsable-Delegue.Acheteur', Auth::user())
        <li class="{{ (request()->segment(1) == 'clients') ? 'active' : ''  }}">
            <a href="{{ route('clients.index') }}" class="tip" title="Client"><i class="icon icon-plus"></i><span>Client</span></a>
        </li>
        @endcannot

        @can('admin.administration.client.ecriture', Auth::user())
            <li class="{{ (request()->segment(1) == 'recouvrement') ? 'active' : ''  }}">
                <a href="{{ route('recouvrement.index') }}" class="tip" title="Recouvrement"><i class="icon icon-bar-chart"></i><span>{{ __('Recovery')}}</span></a>
            </li>
            <li class="{{ (request()->segment(1) == 'chequesencours') ? 'active' : ''  }}">
                <a href="{{ route('clients.chequesencours') }}" class="tip" title="Cheque En Cours"><i class="icon icon-money"></i><span>{{ __('Checks In Progress') }}</span></a>
            </li>
        @endcan

        @can('admin.Manager+.Manager.Responsable.Delegue', Auth::user())
            <li class="submenus_plng {{(request()->segment(1) == 'plannings') ? 'active' : '' }}"> 
                <a> <i class="icon icon-calendar"></i><span>Planning</span> </a>
                <ul class="submenu_ul_plng">
                    <li class="{{ (request()->segment(2) == 'doctors') ? 'active' : ''  }}">
                        <a href="{{ route('plannings.doctors') }}" class="tip" title="{{ __('Planning')}} médecin"> <i class="icon icon-table"></i><span>  {{ __('Planning')}} Médecin</span></a>
                    </li>

                    <li class="{{ (request()->segment(2) == 'pharmacies') ? 'active' : ''  }}">
                        <a href="{{ route('plannings.index.pharmacies') }}" class="tip" title="{{ __('Planning')}}"><i class="icon icon-calendar"></i><span>  {{ __('Planning')}} Pharmacies</span></a>
                    </li>
                </ul>
            </li>

            <li class="submenus_vst {{(request()->segment(1) == 'visites') ? 'active' : '' }}"> 
                <a> <i class="icon icon-user-md"></i><span>Visites</span> </a>
                <ul class="submenu_ul_vst">
                    <li class="{{ (request()->segment(2) == 'doctor') ? 'active' : ''  }}">
                        <a href="{{ route('visites.index.doctor') }}" class="tip" title="{{ __('Visites')}} médecin"><i class="icon icon-user-md"></i><span> Visites Médecins</span></a>
                    </li>
                
                    <li class="{{ (request()->segment(2) == 'pharmacy') ? 'active' : ''  }}">
                        <a href="{{ route('visites.index.pharmacy') }}" class="tip" title="{{ __('Visites')}}"><i class="icon icon-beaker"></i><span> {{ __('Visites')}}</span></a>
                    </li>
                </ul>
            </li>
            @can('admin.manage', Auth::user())

            <li class="{{ (request()->segment(1) == 'objectifs') ? 'active' : ''  }}">
                <a href="{{ route('objectifs.index') }}" class="tip" title="Objectifs"><i class="icon icon-bar-chart"></i><span>Objectifs</span></a>
            </li>

            <li class="{{ (request()->segment(1) == 'limites') ? 'active' : ''  }}">
                <a href="{{ route('limites.index') }}" class="tip" title="Limites"><i class="icon icon-bar-chart"></i><span>Limites</span></a>
            </li>
            @endcan

            <li class="{{ (request()->segment(1) == 'rapports') ? 'active' : ''  }}">
                <a href="{{ route('rapports.index') }}" class="tip" title="Rapport"><i class="icon icon-bar-chart"></i><span>Tableau De Bord</span></a>
            </li>
        @endcan

        {{-- @can('admin.Manager+.Manager.Acheteur', Auth::user())

        <li class="submenus1 {{(request()->segment(1) == 'adv') ? 'active' : '' }}"> 
            <a> <i class="icon icon-book"></i><span>ADV</span> </a>
            <ul class="submenu_ul1">
                @can('admin.Manager+.Manager', Auth::user())
                <li class="{{ (request()->segment(1) == 'advs') ? 'active' : ''  }}">
                    <a href="{{ route('advs.index') }}" class="tip" title="Advs"><i class="icon icon-book"></i><span>Advs</span></a>
                </li>
            @endcan
                @can('admin.Manager', Auth::user())
                    <li class="{{ (request()->segment(2) == 'accepte') ? 'active' : ''  }}">
                        <a href="{{ route('advs.accepte') }}" class="tip" title="Advs"><i class="icon icon-book"></i><span>Accepté</span></a>
                    </li>
                @endcan
                
                @can('admin.Manager+', Auth::user())
                    <li class="{{ (request()->segment(2) == 'valide') ? 'active' : ''  }}">
                        <a href="{{ route('advs.valider') }}" class="tip" title="Validé"><i class="icon icon-plus"></i><span>Validé</span></a>
                    </li>
                @endcan
                
                @can('admin.Acheteur', Auth::user())
                    <li class="{{ (request()->segment(2) == 'cree') ? 'active' : ''  }}">
                        <a href="{{ route('advs.cree') }}" class="tip" title="cree"><i class="icon icon-plus"></i><span>crée</span></a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'commander') ? 'active' : ''  }}">
                        <a href="{{ route('advs.pour.commande') }}" class="tip" title="Commander"><i class="icon icon-shopping-cart"></i><span>Comander</span></a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'livrer') ? 'active' : ''  }}">
                        <a href="{{ route('advs.pour.livrer') }}" class="tip" title="Livrer"><i class="icon icon-truck"></i><span>Livrer</span></a>
                    </li>
                @endcan
                
                @can('admin.Manager+.Manager.Acheteur', Auth::user())
                    <li class="{{ (request()->segment(2) == 'historique') ? 'active' : ''  }}">
                        <a href="{{ route('advs.historique') }}" class="tip" title="Historique"><i class="icon icon-book"></i><span>Historique</span></a>
                    </li>
                @endcan
            </ul>
        </li>
        @endcan
 --}}

        @can('admin.manage', Auth::user())
            <li class="submenus2 {{(request()->segment(1) == 'roles'or request()->segment(1) == 'villes' or 
                                request()->segment(1) == 'specialties'or request()->segment(1) == 'docotrs' or
                                request()->segment(1) == 'ugs'or request()->segment(1) == 'resaux' or 
                                request()->segment(1) == 'products'or request()->segment(1) == 'classes' or 
                                request()->segment(1) == 'dcis'or 
                                request()->segment(1) == 'getusersinfo'or
                                request()->segment(1) == 'fournisseurs'or 
                                request()->segment(1) == 'grossistes'or 
                                request()->segment(1) == 'users' or request()->segment(1) == 'regions'  ) ? 'active' : '' }}"> 
                                <a> <i class="icon icon-cog"></i> <span>Configuration</span> </a>
                <ul class="submenu_ul2">
                    <li class=""><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
                    <li class=""><a href="{{ route('getUsersInfo') }}">{{ __('Users') }} info</a></li>
                    <li class=""><a href="{{ route('roles.index') }}">{{ __('Roles') }}</a></li>
                    <li class=""><a href="{{ route('regions.index') }}">{{__('Regions')}}</a></li>
                    <li class=""><a href="{{ route('villes.index') }}">{{__('Cities')}}</a></li>
                    <li class=""><a href="{{ route('fournisseurs.index') }}">Fournisseurs</a></li>
                    <li class=""><a href="{{ route('grossistes.index') }}">Grossistes</a></li>

                    <li class=""><a href="{{ route('natures.index') }}">Natures</a></li>

                    <li class=""><a href="{{ route('regionmcs.index') }}">Regions MC</a></li>
                    <li class=""><a href="{{ route('numugs.index') }}">Num UG</a></li>

                    <li class=""><a href="{{ route('ugs.index') }}">UG</a></li>
                    <li class=""><a href="{{ route('resaux.index') }}">Reseaux</a></li>
                    <li class=""><a href="{{ route('affecter.index') }}">Affecter</a></li>
                    <li class=""><a href="{{ route('products.index') }}">Produits</a></li>
                    <li class=""><a href="{{ route('classes.index') }}">Classes</a></li>
                    <li class=""><a href="{{ route('dcis.index') }}">DCI</a></li>
                    <li class=""><a href="{{ route('plvs.index') }}">PLV</a></li>
                    <li class="{{ request()->segment(1) == 'specialties' ? 'active' : '' }}"><a href="{{ route('specialties.index') }}" >Spécialités </a></li>
                    <li class="{{ request()->segment(1) == 'docotrs' ? 'active' : '' }}"><a href="{{ route('doctors.index') }}" >Médecins </a></li>


                    <li class=""><a href="{{ route('users.animateurs') }}">Animateurs</a></li>
                    <li><a href="{{ route('exercices.index') }}" >Exercices</a></li>  
                    <li><a href="{{ route('categories.index') }}" >Categories</a></li>  

                </ul>
            </li>
        @endcan
    </ul>
</div>

<script>
    $( document ).ready(function() {
        var check_sub1 = true;
        var check_sub2 = true;
        var check_side = true;
        var check_plng = true;
        var check_vst = true;

        $(".submenu_ul1").slideUp();
        $(".submenu_ul2").slideUp();
        $(".submenu_ul_plng").slideUp();
        $(".submenu_ul_vst").slideUp(); 

        if ($(window).width() < 479){
            $(".sidebar_slid_ul").slideUp();
        }
        
        // WINDOWS RSIZE submenu
        $(window).resize(function() {
            if ($(window).width() < 479){
                $(".sidebar_slid_ul").slideUp();
                $(".submenu_ul1").slideUp();
                $(".submenu_ul2").slideUp();
            }else{
                $(".sidebar_slid_ul").slideDown();
            }
        });

        // Planning submenu
        $(".submenus_plng").click(function() {
            //var menu_ul = $(this).siblings('.submenu_ul');
            if(check_plng == true){
                $('.submenu_ul_plng').slideDown();
                check_plng = false;
            }else{
                $('.submenu_ul_plng').slideUp();
                check_plng = true;
            }
        });

        // Visite submenu
        $(".submenus_vst").click(function() {
            //var menu_ul = $(this).siblings('.submenu_ul');
            if(check_vst == true){
                $('.submenu_ul_vst').slideDown();
                check_vst = false;
            }else{
                $('.submenu_ul_vst').slideUp();
                check_vst = true;
            }
        });

        // ADV submenu
        $(".submenus1").click(function() {
            //var menu_ul = $(this).siblings('.submenu_ul');
            if(check_sub1 == true){
                $('.submenu_ul1').slideDown();
                check_sub1 = false;
            }else{
                $('.submenu_ul1').slideUp();
                check_sub1 = true;
            }
        });

        // MOBILE MENU 
        $(".sidebar_slid").click(function() {
            //var menu_ul = $(this).siblings('.submenu_ul');
            if ($(window).width() < 479){
                if(check_side == true){
                    $('.sidebar_slid_ul').slideDown();
                    check_side = false;
                }else{
                    $('.sidebar_slid_ul').slideUp();
                    check_side = true;
                }
            }else{
                $('.sidebar_slid_ul').slideDown();
            }
        });

        // CONFIGURATION submenu
        $(".submenus2").click(function() {
            if(check_sub2 == true){
                $(this).closest('ul').find('.submenu_ul2').slideDown();
                check_sub2 = false;
            }else{
                $(this).closest('ul').find('.submenu_ul2').slideUp();
                check_sub2 = true;
            }
        });
        
    });
</script>


<!--sidebar-menu-->
