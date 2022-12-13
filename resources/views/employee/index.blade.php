@extends('layout.master')

@section('title',__('dash.index_employee'))
@section('title_page',__('dash.index_employee'))

@section('content')



<section id="basic-datatable">
    <div class="row">
        
        <div class="col-12">
            <div class="card">
               
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            @can('Create-employee')
                                <a id="addRow" href="{{route('pay_points.create')}}" class="col-xl-2 col-md-12 col-sm-12 btn btn-primary mb-2 waves-effect waves-light"><i class="feather icon-plus"></i>&nbsp; {{__('dash.add_new')}}</a>
                            @endcan
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.name')}}</th>
                                        <th>{{__('dash.email')}}</th>
                                        <th>{{__('dash.mobile')}}</th>
                                        <th>{{__('dash.national_id')}}</th>
                                        <th>{{__('dash.pay_points')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                        <th>{{__('dash.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($employee as $e)
                                        <tr>
                                            <td>{{$e->name}}</td>
                                            <td>{{$e->email}}</td>
                                            <td>{{$e->mobile}}</td>
                                            <td>{{$e->national_id}}</td>
                                            <td>{{$e->PayPoint->name}}</td>
                                            <td>{{$e->created_at->format('Y-m-d')}}</td>
                                            <td class="action-table">
                                                @can('Read-report')
                                                <a href="{{route('employees.show',$e->id)}}"  class="btn bg-gradient-info   waves-effect waves-light"><i class="fa-solid fa-file-invoice-dollar"></i></i></a>
                                                @endcan
                                                @can('Update-employee')
                                                <a href="{{route('employees.edit',$e->id)}}"  class="btn bg-gradient-primary   waves-effect waves-light"><i class="fa-solid fa-pen-to-square"></i></i></a>
                                                @endcan
                                                @can('Delete-employee')
                                                <button type="button" class="btn bg-gradient-danger  waves-effect waves-light" onclick="performDelete(this,{{$e->id}})"><i class="fa fa-trash"></i></button>
                                                @endcan
                                            </td>
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
@endsection

@section('scripts')
<script>
 
    function performDelete(el,id){
        performDeleteWithTostar('/pay_points/'+id,{"_method" : 'DELETE'},el,'tr');
    }
</script>
@endsection