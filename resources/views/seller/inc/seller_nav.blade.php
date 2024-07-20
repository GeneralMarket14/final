<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3 ml-0" data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler">
                <span></span>
            </button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
        
            @if (addon_is_activated('pos_system'))
                <!--<div class="d-flex justify-content-around align-items-center align-items-stretch ml-3">-->
                <!--    <div class="aiz-topbar-item">-->
                <!--        <div class="d-flex align-items-center">-->
                <!--            <a class="btn btn-icon btn-circle btn-light" href="{{ route('poin-of-sales.seller_index') }}" target="_blank" title="{{ translate('POS') }}">-->
                <!--                <i class="las la-print"></i>-->
                <!--            </a>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            @endif
        </div>
        <div class="d-flex justify-content-around align-items-center align-items-stretch">

            <div class="aiz-topbar-item ml-2">
            </div>

            {{-- language --}}
            @php
                if(Session::has('locale')){
                    $locale = Session::get('locale', Config::get('app.locale'));
                }
                else{
                    $locale = env('DEFAULT_LANGUAGE');
                }
            @endphp
      

            <!--<div class="aiz-topbar-item ml-2">-->
            <!--    <div class="align-items-stretch d-flex dropdown">-->
            <!--        <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">-->
            <!--            <span class="d-flex align-items-center">-->
            <!--                <span class="avatar avatar-sm mr-md-2">-->
            <!--                    <img-->
            <!--                        src="{{ uploaded_asset(Auth::user()->avatar_original) }}"-->
            <!--                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';"-->
            <!--                    >-->
            <!--                </span>-->
            <!--                <span class="d-none d-md-block">-->
            <!--                    <span class="d-block fw-500">{{Auth::user()->name}}</span>-->
            <!--                    <span class="d-block small opacity-60">{{Auth::user()->user_type}}</span>-->
            <!--                </span>-->
            <!--            </span>-->
            <!--        </a>-->
                
            <!--    </div>-->
            <!--</div><!-- .aiz-topbar-item -->
        </div>
    </div>
</div><!-- .aiz-topbar -->
