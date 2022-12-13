@extends('layout.master')

@section('title',__('dash.index_charge'))
@section('title_page',__('dash.index_charge'))

@section('content')



<section id="basic-datatable">
    <div class="row">
        
        <div class="col-12">
            <div class="card">
               
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            @can('Create-charge')
                            <a id="addRow" href="{{route('charge.create')}}" class="col-xl-2 col-md-12 col-sm-12 btn btn-primary mb-2 waves-effect waves-light"><i class="feather icon-plus"></i>&nbsp; {{__('dash.add_new')}}</a>
                            @endcan
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('dash.name_user')}}</th>
                                        <th>{{__('dash.description')}}</th>
                                        <th>{{__('dash.amount')}}</th>
                                        <th>{{__('dash.type')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($charges as $r)
                                        <tr>
                                            <td>{{++$loop->index}}</td>
                                            <td>{{$r->user->name}}</td>
                                            <td>{{$r->description}}</td>
                                            <td>{{$r->amount}}</td>
                                            <td>{{$r->type}}</td>
                                            <td>{{$r->created_at->format('Y-m-d')}}</td>
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
        performDeleteWithTostar('/roles/'+id,{"_method" : 'DELETE'},el,'tr');
    }
</script>
@endsection