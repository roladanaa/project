<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                            <table class='customTable'>
                                <tbody><tr>
                                    <td class="font-weight-bold">{{__('dash.name')}}</td>
                                    <td>{{$payPoint->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{__('dash.mobile')}}</td>
                                    <td>{{$payPoint->mobile}}</td>
                                </tr>
                               
                            </tbody></table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="customTable">
                                
                                <tbody><tr>
                                    <td class="font-weight-bold">{{__('dash.email')}}</td>
                                    <td>{{$payPoint->email}}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{__('dash.compony')}}</td>
                                    <td>{{$payPoint->compony->name}}</td>
                                </tr>
                               
                            </tbody></table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="fa-solid fa-people-group"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$payPoint->empCount}}</h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.employees')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$payPoint->totalCharge}}</h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.total_charge')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$payPoint->clients}}</h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.client')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="fa-solid fa-dollar-sign"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$payPoint->total}} </h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.total_mony')}}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="card">
               
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                          
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.employees')}}</th>
                                        <th>{{__('dash.name_user')}}</th>
                                        <th>{{__('dash.type')}}</th>
                                        <th>{{__('dash.amount')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                    </tr>
                                </thead>
                                <tbody id='data'>
                                @foreach ($employee as $e)
                                    @foreach ($e->senderWalletUsers as $s)
                                        <tr>
                                            <td>{{$e->name}}</td>
                                            <td>{{$s->user->name}}</td>
                                                <td>{{$s->type}}</td>
                                                <td>{{$s->amount}}</td>
                                                <td>{{$s->created_at->format('Y-m-d')}}</td>
                                        </tr>
                                    @endforeach
                                    
                                @endforeach
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>