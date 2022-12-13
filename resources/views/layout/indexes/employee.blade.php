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
                                    <td>{{$employee->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{__('dash.mobile')}}</td>
                                    <td>{{$employee->mobile}}</td>
                                </tr>
                               
                            </tbody></table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="customTable">
                                
                                <tbody><tr>
                                    <td class="font-weight-bold">{{__('dash.email')}}</td>
                                    <td>{{$employee->email}}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{__('dash.national_id')}}</td>
                                    <td>{{$employee->national_id}}</td>
                                </tr>
                               
                            </tbody></table>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

       
        <div class="col-12">
            <div class="card">
               
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                          <h2>{{__('dash.charge')}}</h2>
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.name_user')}}</th>
                                        <th>{{__('dash.type')}}</th>
                                        <th>{{__('dash.amount')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                    </tr>
                                </thead>
                                <tbody id='data'>
                                    @foreach ($employee->senderWalletUsers as $e)
                                    <tr>
                                        <td>{{$e->user->name}}</td>
                                            <td>{{$e->type}}</td>
                                            <td>{{$e->amount}}</td>
                                            <td>{{$e->created_at->format('Y-m-d')}}</td>
                                    </tr>
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