@extends('seller.layouts.app')

@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 text-primary">{{ translate('Dashboard') }}</h1>
            </div>
        </div>
    </div>

    <!--<div class="row">-->
    <!--    <div class="col-sm-6 col-md-6 col-xxl-3">-->
    <!--        <div class="card shadow-none mb-4 bg-primary py-4">-->
    <!--            <div class="card-body">-->
    <!--                <div class="row align-items-center">-->
    <!--                    <div class="col">-->
    <!--                        <p class="small text-muted mb-0">-->
    <!--                            <span class="fe fe-arrow-down fe-12"></span>-->
    <!--                            <span class="fs-14 text-light">{{ translate('Products') }}</span>-->
    <!--                        </p>-->
    <!--                        <h3 class="mb-0 text-white fs-30">-->
    <!--                            {{ \App\Models\Product::where('user_id', Auth::user()->id)->count() }}-->
    <!--                        </h3>-->

    <!--                    </div>-->
    <!--                    <div class="col-auto text-right">-->
    <!--                        <svg xmlns="http://www.w3.org/2000/svg" width="64.001" height="64" viewBox="0 0 64.001 64">-->
    <!--                            <path id="Path_66" data-name="Path 66"-->
    <!--                                d="M146.431,117.56l-26.514-10.606a8.014,8.014,0,0,0-5.944,0L87.458,117.56a4,4,0,0,0-2.514,3.714v34.217a4,4,0,0,0,2.514,3.714l26.514,10.606a8.013,8.013,0,0,0,5.944,0L146.431,159.2a4,4,0,0,0,2.514-3.714V121.274a4,4,0,0,0-2.514-3.714m-31.714-8.748a5.981,5.981,0,0,1,4.456,0l26.1,10.44a1,1,0,0,1,0,1.858l-12.332,4.932-30.654-12.26Zm1.228,59.633L88.2,157.347a2,2,0,0,1-1.258-1.856V122.6l29,11.6Zm1-36L88.612,121.11a1,1,0,0,1,0-1.858L99.6,114.858l30.654,12.262Zm30,23.048a2,2,0,0,1-1.258,1.856l-27.742,11.1V134.2l13-5.2V146.61a1.035,1.035,0,0,0,2-.466V128.2l14-5.6Z"-->
    <!--                                transform="translate(-84.944 -106.382)" fill="#FFFFFF" />-->
    <!--                        </svg>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <div class="col-sm-6 col-md-6 col-xxl-3">-->
    <!--        <div class="card shadow-none mb-4 bg-primary py-4">-->
    <!--            <div class="card-body">-->
    <!--                <div class="row align-items-center">-->
    <!--                    <div class="col">-->
    <!--                        <p class="small text-muted mb-0">-->
    <!--                            <span class="fe fe-arrow-down fe-12"></span>-->
    <!--                            <span class="fs-14 text-light">{{ translate('Rating') }}</span>-->
    <!--                        </p>-->
    <!--                        <h3 class="mb-0 text-white fs-30">-->
    <!--                            {{ Auth::user()->shop->rating }}-->
    <!--                        </h3>-->

    <!--                    </div>-->
    <!--                    <div class="col-auto text-right">-->
    <!--                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="61.143" viewBox="0 0 64 61.143">-->
    <!--                            <path id="Path_57" data-name="Path 57"-->
    <!--                                d="M63.286,22.145a2.821,2.821,0,0,0-1.816-.926L43.958,19.455a2.816,2.816,0,0,1-2.294-1.666L34.574,1.68a2.813,2.813,0,0,0-5.148,0l-7.09,16.11a2.813,2.813,0,0,1-2.292,1.666L2.53,21.219a2.813,2.813,0,0,0-1.59,4.9l13.13,11.72a2.818,2.818,0,0,1,.876,2.7l-3.734,17.2a2.812,2.812,0,0,0,4.166,3.026L30.584,51.9a2.8,2.8,0,0,1,2.832,0l15.206,8.864a2.813,2.813,0,0,0,4.166-3.026l-3.734-17.2a2.818,2.818,0,0,1,.876-2.7l13.13-11.72a2.813,2.813,0,0,0,.226-3.972m-1.5,2.546L48.658,36.413a4.717,4.717,0,0,0-1.47,4.524l3.732,17.2a.9.9,0,0,1-1.336.97l-15.2-8.866a4.729,4.729,0,0,0-4.758,0L14.416,59.109a.9.9,0,0,1-1.336-.97l3.732-17.2a4.717,4.717,0,0,0-1.47-4.524L2.212,24.691a.9.9,0,0,1,.51-1.57l17.512-1.766a4.721,4.721,0,0,0,3.85-2.8l7.09-16.11a.9.9,0,0,1,1.652,0l7.09,16.11a4.721,4.721,0,0,0,3.85,2.8l17.512,1.766a.9.9,0,0,1,.51,1.57"-->
    <!--                                transform="translate(0 0)" fill="#FFFFFF" />-->
    <!--                        </svg>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
      
    <!--</div>-->

    <!--<div class="row">-->
    <!--    <div class="col-sm-6 col-md-6 col-lg-3 mb-4">-->
    <!--        <div class="card shadow-none h-450px mb-0 h-100">-->
    <!--            <div class="card-body">-->
    <!--                <div class="card-title text-primary fs-16 fw-600">-->
    <!--                    {{ translate('Category wise product count') }}-->
    <!--                </div>-->
    <!--                <hr>-->
    <!--                <ul class="list-group">-->
    <!--                    @foreach (\App\Models\Category::all() as $key => $category)-->
    <!--                        @if (count($category->products->where('user_id', Auth::user()->id)) > 0)-->
    <!--                            <li class="d-flex justify-content-between align-items-center my-2 text-primary fs-13">-->
    <!--                                {{ $category->getTranslation('name') }}-->
    <!--                                <span class="">-->
    <!--                                    {{ count($category->products->where('user_id', Auth::user()->id)) }}-->
    <!--                                </span>-->
    <!--                            </li>-->
    <!--                        @endif-->
    <!--                    @endforeach-->
    <!--                </ul>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <div class="col-sm-6 col-md-6 col-lg-3 mb-4">-->
    <!--        @if (addon_is_activated('seller_subscription'))-->
    <!--            <div class="card">-->
    <!--                <div class="card-body">-->
    <!--                    <div class="card-title">-->
    <!--                        <h6 class="mb-0">{{ translate('Purchased Package') }}</h6>-->
    <!--                    </div>-->
    <!--                    @if (Auth::user()->shop->seller_package)-->
    <!--                        <div class="d-flex">-->
    <!--                            <div class="col-3">-->
    <!--                                <img src="{{ uploaded_asset(Auth::user()->shop->seller_package->logo) }}"-->
    <!--                                    class="img-fluid mb-4 w-64px">-->
    <!--                            </div>-->
    <!--                            <div class="col-9">-->
    <!--                                <a class="fw-600 mb-3 text-primary">{{ translate('Current Package') }}:</a>-->
    <!--                                <h6 class="text-primary">-->
    <!--                                    {{ Auth::user()->shop->seller_package->name }}-->
    <!--                                    </h3>-->
    <!--                                    <p class="mb-1 text-muted">{{ translate('Product Upload Limit') }}:-->
    <!--                                        {{ Auth::user()->shop->product_upload_limit }} {{ translate('Times') }}-->
    <!--                                    </p>-->
    <!--                                    <p class="text-muted mb-4">{{ translate('Package Expires at') }}:-->
    <!--                                        {{ Auth::user()->shop->package_invalid_at }}-->
    <!--                                    </p>-->
    <!--                                    <div class="">-->
    <!--                                        <a href="{{ route('seller.seller_packages_list') }}"-->
    <!--                                            class="btn btn-soft-primary">{{ translate('Upgrade Package') }}</a>-->
    <!--                                    </div>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    @else-->
    <!--                        <h6 class="fw-600 mb-3 text-primary">{{ translate('Package Not Found') }}</h6>-->
    <!--                    @endif-->

    <!--                </div>-->
    <!--            </div>-->
    <!--        @endif-->
    <!--        <div-->
    <!--            class="card mb-0 @if (addon_is_activated('seller_subscription')) px-4 py-5 @else p-5 h-100 @endif d-flex align-items-center justify-content-center">-->
    <!--            @if (Auth::user()->shop->verification_status == 0)-->
    <!--                <div class="my-n4 py-1 text-center">-->
    <!--                    <img src="{{ static_asset('assets/img/non_verified.png') }}" alt=""-->
    <!--                        class="w-xxl-130px w-90px d-block">-->
    <!--                    <a href="{{ route('seller.shop.verify') }}"-->
    <!--                        class="btn btn-sm btn-primary">{{ translate('Verify Now') }}</a>-->
    <!--                </div>-->
    <!--            @else-->
    <!--                <div class="my-2 py-1">-->
    <!--                    <img src="{{ static_asset('assets/img/verified.png') }}" alt="" width="">-->
    <!--                </div>-->
    <!--            @endif-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    <div class="row">
        <!--<div class="col-sm-6 col-md-6 col-lg-3">-->
        <!--    <a href="{{ route('seller.money_withdraw_requests.index') }}"-->
        <!--        class="card mb-4 p-4 text-center bg-soft-primary h-180px">-->
        <!--        <div class="fs-16 fw-600 text-primary">-->
        <!--            {{ translate('Money Withdraw') }}-->
        <!--        </div>-->
        <!--        <div class="m-3">-->
        <!--            <svg id="Group_22725" data-name="Group 22725" xmlns="http://www.w3.org/2000/svg" width="48" height="48"-->
        <!--                viewBox="0 0 48 48">-->
        <!--                <path id="Path_108"-->
        <!--                    d="M24,28.5A1.538,1.538,0,0,1,25.5,30v6a1.5,1.5,0,0,1-3,0V30A1.538,1.538,0,0,1,24,28.5"-->
        <!--                    fill="#2E294E" />-->
        <!--                <path id="Path_109"-->
        <!--                    d="M36,21H33V43.5A1.538,1.538,0,0,1,31.5,45h-15A1.538,1.538,0,0,1,15,43.5V21H12V43.5A4.481,4.481,0,0,0,16.5,48h15A4.481,4.481,0,0,0,36,43.5Z"-->
        <!--                    fill="#2E294E" />-->
        <!--                <path id="Path_110"-->
        <!--                    d="M43.5,0H4.5A4.481,4.481,0,0,0,0,4.5v9A4.481,4.481,0,0,0,4.5,18h39A4.481,4.481,0,0,0,48,13.5v-9A4.481,4.481,0,0,0,43.5,0M45,13.5A1.538,1.538,0,0,1,43.5,15H4.5A1.538,1.538,0,0,1,3,13.5v-9A1.538,1.538,0,0,1,4.5,3h39A1.538,1.538,0,0,1,45,4.5Z"-->
        <!--                    fill="#2E294E" />-->
        <!--                <path id="Path_111" d="M28.5,21h-9a4.5,4.5,0,0,0,9,0" fill="#2E294E" />-->
        <!--            </svg>-->
        <!--        </div>-->
        <!--    </a>-->
        <!--</div>-->
        <div class="col-sm-6 col-md-6 col-lg-3">
            <a href="{{ route('seller.products') }}" class="card mb-4 p-4 text-center h-180px">
                <div class="fs-16 fw-600 text-primary">
                   Product Management
                </div>
                <div class="m-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                        <g id="Group_22724" data-name="Group 22724" transform="translate(-1284 -875)">
                            <rect id="Rectangle_17080" data-name="Rectangle 17080" width="2" height="48" rx="1"
                                transform="translate(1307 875)" fill="#2E294E" />
                            <rect id="Rectangle_17081" data-name="Rectangle 17081" width="2" height="48" rx="1"
                                transform="translate(1332 898) rotate(90)" fill="#2E294E" />
                        </g>
                    </svg>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card mb-4 p-4 text-center bg-soft-primary">
                <div class="fs-16 fw-600 text-primary">
                Setttings
                </div>
                <div class=" m-3">
                    <svg id="Group_31" data-name="Group 31" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                        viewBox="0 0 32 32">
                        <path id="Path_78" data-name="Path 78"
                            d="M2,25.723a1,1,0,0,0,.629.928L16,32l3.361-1.344a.5.5,0,0,0-.186-.965.491.491,0,0,0-.185.036L16,30.923l-13-5.2v-11.6a4.428,4.428,0,0,1-1-.2Z"
                            fill="#2E294E" />
                        <path id="Path_79" data-name="Path 79"
                            d="M19.681,24.189a.5.5,0,0,0-.5-.5.493.493,0,0,0-.186.036l-3,1.2L7.432,21.5a.5.5,0,0,0-.65.278.512.512,0,0,0-.035.186.5.5,0,0,0,.314.464L16,26l3.367-1.347a.5.5,0,0,0,.314-.464"
                            fill="#2E294E" />
                        <path id="Path_80" data-name="Path 80"
                            d="M31.5,25.126h-.087a1.368,1.368,0,0,1-.967-2.336l.061-.061a.5.5,0,0,0,0-.707l-.265-.265-.264-.264a.5.5,0,0,0-.707,0l-.061.06a1.368,1.368,0,0,1-2.336-.967V20.5a.5.5,0,0,0-.5-.5h-.748a.5.5,0,0,0-.5.5v.086a1.368,1.368,0,0,1-2.336.967l-.061-.06a.5.5,0,0,0-.707,0l-.265.264-.265.265a.5.5,0,0,0,0,.707l.061.061a1.368,1.368,0,0,1-.967,2.336H20.5a.5.5,0,0,0-.5.5v.748a.5.5,0,0,0,.5.5h.086a1.368,1.368,0,0,1,.967,2.336l-.061.061a.5.5,0,0,0,0,.707l.265.264.265.265a.5.5,0,0,0,.707,0l.061-.061a1.368,1.368,0,0,1,2.336.968V31.5a.5.5,0,0,0,.5.5h.748a.5.5,0,0,0,.5-.5v-.086a1.368,1.368,0,0,1,2.336-.968l.061.061a.5.5,0,0,0,.707,0l.264-.265.265-.264a.5.5,0,0,0,0-.707l-.061-.061a1.368,1.368,0,0,1,.967-2.336H31.5a.5.5,0,0,0,.5-.5v-.748a.5.5,0,0,0-.5-.5M29.171,29a2.373,2.373,0,0,0,.118.285,2.368,2.368,0,0,0-3.171,1.078,2.22,2.22,0,0,0-.118.285,2.369,2.369,0,0,0-3-1.481,2.516,2.516,0,0,0-.285.118A2.367,2.367,0,0,0,21.348,26a2.369,2.369,0,0,0,1.48-3,2.344,2.344,0,0,0-.118-.285,2.37,2.37,0,0,0,3.172-1.077A2.516,2.516,0,0,0,26,21.348a2.367,2.367,0,0,0,3,1.48,2.28,2.28,0,0,0,.285-.118,2.37,2.37,0,0,0,1.077,3.172,2.457,2.457,0,0,0,.286.118,2.367,2.367,0,0,0-1.481,3"
                            fill="#2E294E" />
                        <path id="Path_81" data-name="Path 81" d="M27.5,26A1.5,1.5,0,1,0,26,27.5,1.5,1.5,0,0,0,27.5,26"
                            fill="#2E294E" />
                        <path id="Path_82" data-name="Path 82"
                            d="M16,0A46.43,46.43,0,0,1,0,8.4v2a3.451,3.451,0,0,0,5.333,2.133,3.452,3.452,0,0,0,5.333,2.134A3.453,3.453,0,0,0,16,16.8a3.451,3.451,0,0,0,5.333-2.133,3.451,3.451,0,0,0,5.333-2.134A3.454,3.454,0,0,0,32,10.4v-2A46.421,46.421,0,0,1,16,0M31.021,10.194a2.452,2.452,0,0,1-3.788,1.515,1,1,0,0,0-1.545.618A2.453,2.453,0,0,1,21.9,13.843a1,1,0,0,0-1.545.618A2.451,2.451,0,0,1,16,15.434a2.452,2.452,0,0,1-4.355-.973,1,1,0,0,0-1.545-.618,2.454,2.454,0,0,1-3.789-1.516,1,1,0,0,0-1.184-.772,1.015,1.015,0,0,0-.361.154A2.451,2.451,0,0,1,.978,10.194V9.148A47.458,47.458,0,0,0,16,1.277,47.442,47.442,0,0,0,31.021,9.148Z"
                            fill="#2E294E" />
                    </svg>
                </div>
                <a href="{{ route('seller.shop.index') }}" class="btn btn-primary">
                    {{ translate('Go to setting') }}
                </a>
            </div>
        </div>



        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card mb-4 p-4 text-center bg-soft-primary">
                <div class="fs-16 fw-600 text-primary">
                Customer List
                </div>
                <div class=" m-3">
                    <!--<svg id="Group_31" data-name="Group 31" xmlns="http://www.w3.org/2000/svg" width="32" height="32"-->
                    <!--    viewBox="0 0 32 32">-->
                    <!--    <path id="Path_78" data-name="Path 78"-->
                    <!--        d="M2,25.723a1,1,0,0,0,.629.928L16,32l3.361-1.344a.5.5,0,0,0-.186-.965.491.491,0,0,0-.185.036L16,30.923l-13-5.2v-11.6a4.428,4.428,0,0,1-1-.2Z"-->
                    <!--        fill="#2E294E" />-->
                    <!--    <path id="Path_79" data-name="Path 79"-->
                    <!--        d="M19.681,24.189a.5.5,0,0,0-.5-.5.493.493,0,0,0-.186.036l-3,1.2L7.432,21.5a.5.5,0,0,0-.65.278.512.512,0,0,0-.035.186.5.5,0,0,0,.314.464L16,26l3.367-1.347a.5.5,0,0,0,.314-.464"-->
                    <!--        fill="#2E294E" />-->
                    <!--    <path id="Path_80" data-name="Path 80"-->
                    <!--        d="M31.5,25.126h-.087a1.368,1.368,0,0,1-.967-2.336l.061-.061a.5.5,0,0,0,0-.707l-.265-.265-.264-.264a.5.5,0,0,0-.707,0l-.061.06a1.368,1.368,0,0,1-2.336-.967V20.5a.5.5,0,0,0-.5-.5h-.748a.5.5,0,0,0-.5.5v.086a1.368,1.368,0,0,1-2.336.967l-.061-.06a.5.5,0,0,0-.707,0l-.265.264-.265.265a.5.5,0,0,0,0,.707l.061.061a1.368,1.368,0,0,1-.967,2.336H20.5a.5.5,0,0,0-.5.5v.748a.5.5,0,0,0,.5.5h.086a1.368,1.368,0,0,1,.967,2.336l-.061.061a.5.5,0,0,0,0,.707l.265.264.265.265a.5.5,0,0,0,.707,0l.061-.061a1.368,1.368,0,0,1,2.336.968V31.5a.5.5,0,0,0,.5.5h.748a.5.5,0,0,0,.5-.5v-.086a1.368,1.368,0,0,1,2.336-.968l.061.061a.5.5,0,0,0,.707,0l.264-.265.265-.264a.5.5,0,0,0,0-.707l-.061-.061a1.368,1.368,0,0,1,.967-2.336H31.5a.5.5,0,0,0,.5-.5v-.748a.5.5,0,0,0-.5-.5M29.171,29a2.373,2.373,0,0,0,.118.285,2.368,2.368,0,0,0-3.171,1.078,2.22,2.22,0,0,0-.118.285,2.369,2.369,0,0,0-3-1.481,2.516,2.516,0,0,0-.285.118A2.367,2.367,0,0,0,21.348,26a2.369,2.369,0,0,0,1.48-3,2.344,2.344,0,0,0-.118-.285,2.37,2.37,0,0,0,3.172-1.077A2.516,2.516,0,0,0,26,21.348a2.367,2.367,0,0,0,3,1.48,2.28,2.28,0,0,0,.285-.118,2.37,2.37,0,0,0,1.077,3.172,2.457,2.457,0,0,0,.286.118,2.367,2.367,0,0,0-1.481,3"-->
                    <!--        fill="#2E294E" />-->
                    <!--    <path id="Path_81" data-name="Path 81" d="M27.5,26A1.5,1.5,0,1,0,26,27.5,1.5,1.5,0,0,0,27.5,26"-->
                    <!--        fill="#2E294E" />-->
                    <!--    <path id="Path_82" data-name="Path 82"-->
                    <!--        d="M16,0A46.43,46.43,0,0,1,0,8.4v2a3.451,3.451,0,0,0,5.333,2.133,3.452,3.452,0,0,0,5.333,2.134A3.453,3.453,0,0,0,16,16.8a3.451,3.451,0,0,0,5.333-2.133,3.451,3.451,0,0,0,5.333-2.134A3.454,3.454,0,0,0,32,10.4v-2A46.421,46.421,0,0,1,16,0M31.021,10.194a2.452,2.452,0,0,1-3.788,1.515,1,1,0,0,0-1.545.618A2.453,2.453,0,0,1,21.9,13.843a1,1,0,0,0-1.545.618A2.451,2.451,0,0,1,16,15.434a2.452,2.452,0,0,1-4.355-.973,1,1,0,0,0-1.545-.618,2.454,2.454,0,0,1-3.789-1.516,1,1,0,0,0-1.184-.772,1.015,1.015,0,0,0-.361.154A2.451,2.451,0,0,1,.978,10.194V9.148A47.458,47.458,0,0,0,16,1.277,47.442,47.442,0,0,0,31.021,9.148Z"-->
                    <!--        fill="#2E294E" />-->
                    <!--</svg>-->
                </div>
                <a href="{{ route('seller.shop.index') }}" class="btn btn-primary">
                   Goto Customer List
                </a>
            </div>
        </div>
        
        
                <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
            @if (addon_is_activated('seller_subscription'))
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h6 class="mb-0">{{ translate('Purchased Package') }}</h6>
                        </div>
                        @if (Auth::user()->shop->seller_package)
                            <div class="d-flex">
                                <div class="col-3">
                                    <img src="{{ uploaded_asset(Auth::user()->shop->seller_package->logo) }}"
                                        class="img-fluid mb-4 w-64px">
                                </div>
                                <div class="col-9">
                                    <a class="fw-600 mb-3 text-primary">{{ translate('Current Package') }}:</a>
                                    <h6 class="text-primary">
                                        {{ Auth::user()->shop->seller_package->name }}
                                        </h3>
                                        <p class="mb-1 text-muted">{{ translate('Product Upload Limit') }}:
                                            {{ Auth::user()->shop->product_upload_limit }} {{ translate('Times') }}
                                        </p>
                                        <p class="text-muted mb-4">{{ translate('Package Expires at') }}:
                                            {{ Auth::user()->shop->package_invalid_at }}
                                        </p>
                                        <div class="">
                                            <a href="{{ route('seller.seller_packages_list') }}"
                                                class="btn btn-soft-primary">{{ translate('Upgrade Package') }}</a>
                                        </div>
                                </div>
                            </div>
                        @else
                            <h6 class="fw-600 mb-3 text-primary">{{ translate('Package Not Found') }}</h6>
                        @endif

                    </div>
                </div>
            @endif
            <div
                class="card mb-0 @if (addon_is_activated('seller_subscription')) px-4 py-5 @else p-5 h-100 @endif d-flex align-items-center justify-content-center">
                @if (Auth::user()->shop->verification_status == 0)
                    <div class="my-n4 py-1 text-center">
                        <img src="{{ static_asset('assets/img/non_verified.png') }}" alt=""
                            class="w-xxl-130px w-90px d-block">
                        <a href="{{ route('seller.shop.verify') }}"
                            class="btn btn-sm btn-primary">{{ translate('Verify Now') }}</a>
                    </div>
                @else
                    <div class="my-2 py-1">
                        <img src="{{ static_asset('assets/img/verified.png') }}" alt="" width="">
                    </div>
                @endif
            </div>
        </div>

        
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-title text-primary">
                <h6 class="mb-0">{{ translate('Top 12 Products') }}</h6>
            </div>
            <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"
                data-md-items="3" data-sm-items="2" data-arrows='true'>
                @foreach ($products as $key => $product)
                    <div class="carousel-box">
                        <div
                            class="aiz-card-box border border-light rounded shadow-sm hov-shadow-md mb-2 has-transition bg-white">
                            <div class="position-relative">
                                <a href="{{ route('product', $product->slug) }}" class="d-block">
                                    <img class="img-fit lazyload mx-auto h-210px"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                        alt="{{ $product->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </a>
                            </div>
                            <div class="p-md-3 p-2 text-left">
                                <div class="fs-15">
                                    @if (home_base_price($product) != home_discounted_base_price($product))
                                        <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
                                    @endif
                                    <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
                                </div>
                                <div class="rating rating-sm mt-1">
                                    {{ renderStarRating($product->rating) }}
                                </div>
                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                                    <a href="{{ route('product', $product->slug) }}"
                                        class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        AIZ.plugins.chart('#graph-1', {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($last_7_days_sales as $key => $last_7_days_sale)
                        '{{ $key }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Sales ($)',
                    data: [
                        @foreach ($last_7_days_sales as $key => $last_7_days_sale)
                            '{{ $last_7_days_sale }}',
                        @endforeach
                    ],

                    backgroundColor: ['#2E294E', '#2E294E', '#2E294E', '#2E294E', '#2E294E', '#2E294E',
                        '#2E294E'
                    ],
                    borderColor: ['#2E294E', '#2E294E', '#2E294E', '#2E294E', '#2E294E', '#2E294E',
                        '#2E294E'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#E0E0E0',
                            zeroLineColor: '#E0E0E0'
                        },
                        ticks: {
                            fontColor: "#AFAFAF",
                            fontFamily: 'Roboto',
                            fontSize: 10,
                            beginAtZero: true
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            fontColor: "#AFAFAF",
                            fontFamily: 'Roboto',
                            fontSize: 10
                        },
                        barThickness: 7,
                        barPercentage: .5,
                        categoryPercentage: .5,
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
@endsection
