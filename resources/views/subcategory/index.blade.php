@extends('layout.master')

@section('title',__('dash.index_subcategory'))
@section('title_page',__('dash.index_subcategory'))

@section('content')



<section id="basic-datatable">
    <div class="row">
        
        <div class="col-12">
            <div class="card">
               
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            @can('Create-subcategory')
                            <a id="addRow" href="{{route('sub_categories.create')}}" class="col-xl-2 col-md-12 col-sm-12 btn btn-primary mb-2 waves-effect waves-light"><i class="feather icon-plus"></i>&nbsp; {{__('dash.add_new')}}</a>
                            @endcan
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.image')}}</th>
                                        <th>{{__('dash.name')}}</th>
                                        <th>{{__('dash.category')}}</th>
                                        <th>{{__('dash.city')}}</th>
                                        <th>{{__('dash.state')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                        <th>{{__('dash.actions')}}</th>
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
                                            <td class="action-table">
                                                @can('Show-subcategory')
                                                <a href="{{route('sub_categories.show',$c->id)}}"  class="btn bg-gradient-info  waves-effect waves-light"><i class="fa fa-eye"></i></a>
                                                @endcan
                                                @can('Update-subcategory')
                                                <a href="{{route('sub_categories.edit',$c->id)}}"  class="btn bg-gradient-primary   waves-effect waves-light"><i class="fa-solid fa-pen-to-square"></i></i></a>
                                                @endcan
                                                @can('Delete-subcategory')
                                                @if($c->status =='active')
                                                {{-- Show block btn where status user active --}}
                                                <button type="button" class="btn bg-gradient-danger waves-effect waves-light" onclick="performChangeStatus({{$c->id}})"><i class="fa fa-lock"></i></button>
                                                @else
                                                {{-- Show active btn where status user block --}}
                                                <button type="button" class="btn bg-gradient-success waves-effect waves-light" onclick="performChangeStatus({{$c->id}})"><i class="fa fa-unlock"></i></button>
                                                @endif
                                                <button type="button" class="btn bg-gradient-danger  waves-effect waves-light" onclick="performDelete(this,{{$c->id}})"><i class="fa fa-trash"></i></button>
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
        performStoreWithTostar('/sub_categories/status/'+id);
    }

    function performDelete(el,id){
        performDeleteWithTostar('/sub_categories/'+id,{"_method" : 'DELETE'},el,'tr');
    }
</script>
@endsection