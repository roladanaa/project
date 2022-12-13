@extends('layout.master')

@section('title','Report')
@section('title_page',__('dash.reports'))

@section('content')
<section class="invoice-print mb-1">
    <div class="row">

        <fieldset class="col-12 col-md-5 mb-1 mb-md-0">
            
        </fieldset>
        <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
            <button class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light"> <i class="feather icon-file-text"></i> Print</button>
        </div>
    </div>
</section>
<section class="card invoice-page">
    <div id="invoice-template" class="card-body">
        <!-- Invoice Company Details -->
        <div id="invoice-company-details" class="row">
            <div class="col-sm-6 col-12 text-left pt-1">
                <div class="media pt-1">
                    <img src="{{asset('app-assets/images/logo/logo.png')}}" alt="company logo">
                    <h2 class="brand-text mb-0" style="color :#7367F0">{{__('dash.app_name')}}</h2>
                </div>
            </div>
            <div class="col-sm-6 col-12 text-right">
                <h1>Invoice</h1>
                <div class="invoice-details mt-2">
                    <h6 class="mt-2">INVOICE DATE</h6>
                    <p>{{now()->format('Y-m-d')}}</p>
                </div>
            </div>
        </div>
        <!--/ Invoice Company Details -->

        <!-- Invoice Recipient Details -->
        <div id="invoice-customer-details" class="row pt-2">
            <div class="col-sm-6 col-12 text-left">
                
            </div>
            <div class="col-sm-6 col-12 text-right">
                <h5>User.</h5>
                <div class="company-info my-2">
                    <p>{{$user->name}}</p>
                    <p>{{$user->national_id}}</p>
                </div>
                <div class="company-contact">
                    <p>
                        <i class="feather icon-mail"></i>
                        {{$user->email}}
                    </p>
                    <p>
                        <i class="feather icon-phone"></i>
                        {{$user->mobile}}
                    </p>
                </div>
            </div>
        </div>
        <!--/ Invoice Recipient Details -->

        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-1 invoice-items-table">
            <div class="row">
                <h2>Pay </h2>
                <div class="table-responsive col-12">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{__('dash.name_user')}}</th>
                                <th>{{__('dash.amount')}}</th>
                                <th>{{__('dash.type')}}</th>
                                <th>{{__('dash.add_date2')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->senderWalletUsers as $e)
                                
                            <tr>
                                <td>{{$e->user->name}}</td>
                                <td>{{$e->amount}} USD</td>
                                <td>{{$e->type}}</td>
                                <td>{{$e->created_at->format('Y-m-d')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
<br>
            <div class="row">
                <h2>Charge Account </h2>
                <div class="table-responsive col-12">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{__('dash.name_user')}}</th>
                                <th>{{__('dash.amount')}}</th>
                                <th>{{__('dash.type')}}</th>
                                <th>{{__('dash.add_date2')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->reseverWalletUsers as $e)
                                
                            <tr>
                                <td>{{!is_null($e->object->PayPoint) ? $e->object->PayPoint->name : $e->object->name }}</td>
                                <td>{{$e->amount}} USD</td>
                                <td>{{$e->type}}</td>
                                <td>{{$e->created_at->format('Y-m-d')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <br>
            <div class="row">
                <h2>Pay Institutions </h2>
                <div class="table-responsive col-12">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{__('dash.add_institutions')}}</th>
                                <th>{{__('dash.amount')}}</th>
                                <th>{{__('dash.type')}}</th>
                                <th>{{__('dash.add_date2')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->walletSubCategores as $e)
                                
                            <tr>
                                <td>{{$e->subCategory->name}}</td>
                                <td>{{$e->balance}} USD</td>
                                <td>Pay</td>
                                <td>{{$e->created_at->format('Y-m-d')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="invoice-total-details" class="invoice-total-table">
            <div class="row">
                <div class="col-7 offset-5">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    {{-- <th>TOTAL</th> --}}
                                    {{-- <td>{{$employee->total}} USD</td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

       

    </div>
</section>
@endsection

@section('scripts')
<script>
    
</script>
@endsection