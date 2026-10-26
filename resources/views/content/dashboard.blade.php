@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')
@section('page-style')
    <style>
        .avatar svg {
            height: 20px;
            width: 20px;
            font-size: 1.45rem;
            flex-shrink: 0;
        }

        .dark-layout .avatar svg {
            color: #fff;
        }

        .cursor {
            cursor: pointer;
        }

        .revenue-div-border-style {
            border: 2px solid;
            border-left: 0;
            border-top: 0;
            border-bottom: 0;
        }

        .revenue-title-border-style {
            border: 1px solid red;
            border-top: 0;
            border-right: 0;
            border-left: 0;
            padding-bottom: 3px;
        }
    </style>
@endsection

@section('content')

    <section id="dashboard-card">


        <div class="row">
            <div class="col-lg-4 col-12">
                {{-- <h4> Today's Download : {{ $todaysDownload ?? 0 }}</h4> --}}
                <x-card title="Users">
                    <div id="users"></div>
                </x-card>
            </div>
            <div class="col-lg-4 col-12">
                <x-card title="Total">
                    <div id="membership"></div>
                </x-card>
            </div>
            {{-- <div class="col-lg-4 col-12">
                <x-card title="Video Memberships">
                    <div class="col-lg-12 col-12 text-right">
                        <a href="{{ route('admin.membershiptransactions.index') }}?type=video_membership"
                            class="btn btn-primary btn-sm">View
                            Transaction</a>
                    </div>
                    <div id="video-membership"></div>
                </x-card>
            </div> --}}
            <div class="col-lg-4 col-12">
                <x-card title="Revenue">
                    <div id="ecommerce"></div>
                </x-card>
            </div>
        </div>

        <x-card>
            <div class="row">
                <div class="col-4 text-center revenue-div-border-style">
                    <h4 class="d-inline-block mb-2 revenue-title-border-style">
                        Today's</h4>
                    <h2>{{ $todaysRevenue ?? 400 }}</h2>
                </div>
                <div class="col-4 text-center revenue-div-border-style">
                    <h4 class="d-inline-block mb-2 revenue-title-border-style">
                        This Month's</h4>
                    <h2>{{ $thisMonthRevenue ?? 1000 }}</h2>
                </div>
                <div class="col-4 text-center">
                    <h4 class="d-inline-block mb-2 revenue-title-border-style">
                        Lifetime</h4>
                    <h2>{{ $lifetimeRevenue ?? 200000 }}</h2>
                </div>
            </div>

        </x-card>
        <div class="row match-height">
            <div onclick="location.href='{{ route('admin.users.index') }}'" class="col-lg-4 col-sm-6 col-12">
                <div class="card cursor-pointer">
                    <div class="card-header">
                        <div>
                            <h2 class="font-weight-bolder mb-0">{{ $totalUsers ?? 0 }}</h2>
                            <h6 class="card-text">Total </h6>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather='truck'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="location.href='" class="col-lg-4 col-sm-6 col-12">
                <div class="card cursor-pointer">
                    <div class="card-header">
                        <div>
                            <h2 class="font-weight-bolder mb-0">{{ $totalVendors ?? 0 }}</h2>
                            <h6 class="card-text">Total</h6>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather='cpu'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="location.href='" class="col-lg-4 col-sm-6 col-12">
                <div class="card cursor-pointer">
                    <div class="card-header">
                        <div>
                            <h2 class="font-weight-bolder mb-0">{{ $totalPincodes ?? 0 }}</h2>
                            <h6 class="card-text">Total</h6>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather='cpu'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="location.href='" class="col-lg-4 col-sm-6 col-12">
                <div class="card cursor-pointer">
                    <div class="card-header">
                        <div>
                            <h2 class="font-weight-bolder mb-0">{{ $totalClothes ?? 0 }}</h2>
                            <h6 class="card-text">Total</h6>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather='cpu'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="location.href='" class="col-lg-4 col-sm-6 col-12">
                <div class="card cursor-pointer">
                    <div class="card-header">
                        <div>
                            <h2 class="font-weight-bolder mb-0">{{ $totalServices ?? 0 }}</h2>
                            <h6 class="card-text">Total</h6>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather='cpu'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="location.href='" class="col-lg-4 col-sm-6 col-12">
                <div class="card cursor-pointer">
                    <div class="card-header">
                        <div>
                            <h2 class="font-weight-bolder mb-0">{{ $totalBanners ?? 0 }}</h2>
                            <h6 class="card-text">Total</h6>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather='cpu'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.2.0/apexcharts.min.js"
        integrity="sha512-3+Gl3bmoEkUSCMsEZARlhT4bnq4/MD78aCvs07GULmDOEBpdHYVQF6bz8pIpEg+luEww2gXsOwuhvXUl0i+N4g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const userCount = [2, 4, 6, 7];
        const userDate = ["2024-10-01", "2024-10-02", "2024-10-03", "2024-10-04"];
        initBarChart({
            selector: '#users',
            categories: userDate,
            data: userCount,
            label: 'Users'
        });
        const membershipCount = [1000, 2000, 3000, 4000];
        const membershipDate = ["2024-10-01", "2024-10-02", "2024-10-03", "2024-10-04"];
        initBarChart({
            selector: '#membership',
            categories: membershipDate,
            data: membershipCount,
            label: 'Memberships'
        });
        const ecommerceOrdersCount = [100, 200, 300, 400];
        const ecommerceOrdersDate = ["2024-10-01", "2024-10-02", "2024-10-03", "2024-10-04"];
        initBarChart({
            selector: '#ecommerce',
            categories: ecommerceOrdersDate,
            data: ecommerceOrdersCount,
            label: 'Ecommerce'
        });
        const videoMembershipCount = [2, 4, 6, 7];
        const videoMembershipDate = ["2024-10-01", "2024-10-02", "2024-10-03", "2024-10-04"];
        initChart({
            selector: '#video-membership',
            categories: videoMembershipDate,
            data: videoMembershipCount,
            label: 'Video Memberships'
        });
    </script>


    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        var pusher = new Pusher('1cdf1e7644ae7f3d2a26', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('order_placed_vendor_9');
        channel.bind('my-event', function(data) {
            console.log(JSON.stringify(data));
        });
    </script>
@endsection
