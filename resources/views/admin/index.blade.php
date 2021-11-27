@extends('admin.layouts.admin')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            @include('admin.includes.bread_cumb',['title'=>'DASHBOARD'])
            <div class="row">
                <div class="col-lg-12">
                    <div style="min-height: 82vh;">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                            <div class="col">
                                <div class="card radius-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0">Revenue</p>
                                                <h4 class="my-1">$4805</h4>
                                                <p class="mb-0 font-13"><i class="bx bxs-up-arrow align-middle"></i>$34 from last week</p>
                                            </div>
                                            <div class="widgets-icons ms-auto"><i class="bx bxs-wallet"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0">Total Customers</p>
                                                <h4 class="my-1">8.4K</h4>
                                                <p class="mb-0 font-13"><i class="bx bxs-up-arrow align-middle"></i>$24 from last week</p>
                                            </div>
                                            <div class="widgets-icons ms-auto"><i class="bx bxs-group"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0">Store Visitors</p>
                                                <h4 class="my-1">59K</h4>
                                                <p class="mb-0 font-13"><i class="bx bxs-down-arrow align-middle"></i>$34 from last week</p>
                                            </div>
                                            <div class="widgets-icons ms-auto">
                                                <i class="bx bxs-binoculars"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0">Bounce Rate</p>
                                                <h4 class="my-1">34.46%</h4>
                                                <p class="mb-0 font-13"><i class="bx bxs-down-arrow align-middle"></i>12.2% from last week</p>
                                            </div>
                                            <div class="widgets-icons ms-auto"><i class="bx bx-line-chart-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0">Chrome Users</p>
                                                <h4 class="my-1">42K</h4>
                                            </div>
                                            <div class="ms-auto font-35 text-white"><i class="bx bxl-chrome"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0">Github Users</p>
                                                <h4 class="my-1">56M</h4>
                                            </div>
                                            <div class="ms-auto font-35 text-white"><i class="bx bxl-github"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0">Firefox Users</p>
                                                <h4 class="my-1">42M</h4>
                                            </div>
                                            <div class="ms-auto font-35 text-white"><i class="bx bxl-firefox"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0">Shopify Users</p>
                                                <h4 class="my-1">85M</h4>
                                            </div>
                                            <div class="ms-auto font-35 text-white"><i class="bx bxl-shopify"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--start overlay-->
            <div class="overlay"></div>
            <!--end overlay-->
        </div>
        <!-- End container-fluid-->
    </div>
    <!--End content-wrapper-->

@endsection



