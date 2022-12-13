@extends('layout.master')

@section('title',__('dash.index_user'))
@section('title_page',__('dash.index_user'))

@section('content')



<section id="basic-datatable">
    <div class="row">
        
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.name')}}</th>
                                        <th>{{__('dash.email')}}</th>
                                        <th>{{__('dash.mobile')}}</th>
                                        <th>{{__('dash.national_id')}}</th>
                                        <th>{{__('dash.state')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                        <th>{{__('dash.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($users as $u)
                                        <tr>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->email}}</td>
                                            <td>{{$u->mobile}}</td>
                                            <td>{{$u->national_id}}</td>
                                            <td>{{$u->state}}</td>
                                            <td>{{$u->created_at->format('Y-m-d')}}</td>
                                            <td class="action-table">
                                                @can('Create-role')
                                                <a href="{{route('users.permissions',$u->id)}}"  class="btn bg-gradient-info   waves-effect waves-light"><i class="fa-solid fa-gears"></i></i></a>
                                                @endcan
                                                @can('Read-report')
                                                <a href="{{route('users.show',$u->id)}}"  class="btn bg-gradient-info   waves-effect waves-light"><i class="fa-solid fa-file-invoice-dollar"></i></i></a>
                                                @endcan
                                                @can('Delete-user')
                                                @if($u->status =='active')
                                                {{-- Show block btn where status user active --}}
                                                        <button type="button" class="btn bg-gradient-danger waves-effect waves-light" onclick="performChangeStatus({{$u->id}})"><i class="fa fa-lock"></i></button>
                                                @else
                                                {{-- Show active btn where status user block --}}
                                                        <button type="button" class="btn bg-gradient-success waves-effect waves-light" onclick="performChangeStatus({{$u->id}})"><i class="fa fa-unlock"></i></button>
                                                @endif
                                                <button type="button" class="btn bg-gradient-danger  waves-effect waves-light" onclick="performDelete(this,{{$u->id}})"><i class="fa fa-trash"></i></button>
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
  function performChangeStatus(id){
        performStoreWithTostar('/users/status/'+id);
    }

    function performDelete(el,id){
        performDeleteWithTostar('/users/'+id,{"_method" : 'DELETE'},el,'tr');
    }
</script>
@endsection