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
                                    <td>{{$compony->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{__('dash.mobile')}}</td>
                                    <td>{{$compony->mobile}}</td>
                                </tr>
                               
                            </tbody></table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="customTable">
                                
                                <tbody><tr>
                                    <td class="font-weight-bold">{{__('dash.email')}}</td>
                                    <td>{{$compony->email}}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{__('dash.city')}}</td>
                                    <td>{{$compony->city->name}}</td>
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
                                <i class="fa-solid fa-location-pin"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$pays->count()}}</h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.pay_points')}}</p>
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
                                <i class="fa-solid fa-city"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$city->count()}}</h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.cities')}}</p>
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
                        <h2 class="text-bold-700">{{$users->count()}}</h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.users')}}</p>
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
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$category->count()}}</h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.category')}}</p>
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
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$subCategory->count()}}</h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.add_institutions')}}</p>
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
                        <h2 class="text-bold-700">{{$employee->count()}} </h2>
                        <p class="mb-0 line-ellipsis">{{__('dash.employees')}}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="card">
               
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <h2>{{__('dash.pay_points')}}</h2>
                          
                            {{-- PayPoints --}}
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.name')}}</th>
                                        <th>{{__('dash.email')}}</th>
                                        <th>{{__('dash.mobile')}}</th>
                                        <th>{{__('dash.compony')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($pays as $p)
                                        <tr>
                                            <td>{{$p->name}}</td>
                                            <td>{{$p->email}}</td>
                                            <td>{{$p->mobile}}</td>
                                            <td>{{$p->compony->name}}</td>
                                            <td>{{$p->created_at->format('Y-m-d')}}</td>
                                            
                                        </tr>
                                    @endforeach
                                    
                                    
                                </tbody>
                            </table>
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
                          <h2>{{__('dash.add_institutions')}}</h2>
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.image')}}</th>
                                        <th>{{__('dash.name')}}</th>
                                        <th>{{__('dash.category')}}</th>
                                        <th>{{__('dash.city')}}</th>
                                        <th>{{__('dash.state')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($subCategory as $c)
                                        <tr>
                                            <td><div class="avatar mr-1 avatar-lg">
                                                <img src="{{Storage::url($c->image)}}" alt="avtar img holder">
                                            </div></td>
                                            <td>{{$c->name}}</td>
                                            <td>{{$c->category->name}}</td>
                                            <td>{{$c->city->name}}</td>
                                            <td>{{$c->state}}</td>
                                            <td>{{$c->created_at->format('Y-m-d')}}</td>
                                            
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