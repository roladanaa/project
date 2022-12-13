@extends('layout.master')

@section('title',__('dash.index_roles'))
@section('title_page',__('dash.index_roles'))

@section('content')



<section id="basic-datatable">
    <div class="row">
        
        <div class="col-12">
            <div class="card">
               
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            @can('Create-role')
                            <a id="addRow" href="{{route('roles.create')}}" class="col-xl-2 col-md-12 col-sm-12 btn btn-primary mb-2 waves-effect waves-light"><i class="feather icon-plus"></i>&nbsp; {{__('dash.add_new')}}</a>
                            @endcan
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.name')}}</th>
                                        <th>{{__('dash.guard')}}</th>
                                        <th>{{__('dash.permission')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                        <th>{{__('dash.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($roles as $r)
                                        <tr>
                                            <td>{{$r->name}}</td>
                                            <td>{{$r->guard_name}}</td>
                                            <td>{{$r->permissions->count()}}</td>
                                            <td>{{$r->created_at->format('Y-m-d')}}</td>
                                            <td class="action-table">
                                                @can('Update-role')
                                                <a href="{{route('roles.edit',$r->id)}}"  class="btn bg-gradient-primary   waves-effect waves-light"><i class="fa-solid fa-pen-to-square"></i></i></a>
                                                @endcan
                                                @can('Show-role')
                                                <a href="{{route('roles.show',$r->id)}}"  class="btn bg-gradient-info   waves-effect waves-light"><i class="fa-solid fa-gears"></i></i></a>
                                                @endcan
                                                @can('Delete-role')
                                                <button type="button" class="btn bg-gradient-danger  waves-effect waves-light" onclick="performDelete(this,{{$r->id}})"><i class="fa fa-trash"></i></button>
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
        performDeleteWithTostar('/roles/'+id,{"_method" : 'DELETE'},el,'tr');
    }
</script>
@endsection