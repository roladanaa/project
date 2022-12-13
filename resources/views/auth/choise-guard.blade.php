@extends('layout.master2')
@section('body')

<section class=" flexbox-container">
    <div class="row">

        <div class="col-lg-4 col-md-6 col-sm-12">
            <a href="{{route('auth.login_page','point')}}">
                <div class="card text-white border-0 box-shadow-0">
                    <div class="coustomCartHigth">
                        <div class="card-img-overlay overflow-hidden overlay-danger coustomCardContent">
                            <h4 class=""><i class="fa-solid fa-money-check-dollar"></i></h4>
                            <span >{{__('dash.pay_points')}}</span>

                        </div>

                    </div>
                </div>
            </a>
        </div>
       
        <div class="col-lg-4 col-md-6 col-sm-12">
            <a href="{{route('auth.login_page','employee')}}">
                <div class="card text-white border-0 box-shadow-0">
                    <div class="coustomCartHigth">
                        <div class="card-img-overlay overflow-hidden overlay-success coustomCardContent">
                            <h4 class=""><i class="fa-solid fa-people-group"></i></h4>
                            <span >{{__('dash.employees')}}</span>

                        </div>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <a href="{{route('auth.login_page','compony')}}">
                <div class="card">
                    <div class="coustomCartHigth">
                        <div class="card-img-overlay overflow-hidden overlay-warning coustomCardContent">
                            <h4 class=" "><i class="fa-solid fa-building"></i></h4>
                            <span >{{__('dash.compony')}}</span>

                        </div>
                    </div>
                </div>
            </a>
        </div>
        {{-- <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="{{route('auth.login_page','users')}}">
                <div class="card text-white border-0 box-shadow-0">
                    <div class="coustomCartHigth">
                        <div class="card-img-overlay overflow-hidden overlay-info coustomCardContent">
                            <h4 class=""><i class="fa-solid fa-people-robbery"></i></h4>
                            <span >{{__('dash.users')}}</span>

                        </div>
                    </div>
                </div>
            </a>
        </div> --}}
    </div>
    
</section>



@endsection