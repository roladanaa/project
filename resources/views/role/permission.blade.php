
@extends('layout.master')

@section('title',__('dash.permission'))
@section('title_page',__('dash.permission'))

@section('content')
<section class="page-users-view">
    <div class="row">
      

        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom mx-2 px-0">
                    <h6 class="border-bottom py-1 mb-0 font-medium-2"><i class="feather icon-lock mr-50 "></i>{{__('dash.permission')}}
                    </h6>
                </div>
                <div class="card-body px-75">
                    <div class="table-responsive users-view-permission">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('dash.permission')}}</th>
                                    <th>{{__('dash.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $pr )
                                <tr class="tableCustomRow">
                                    <td>{{++$loop->index}}</td>
                                    <td>{{$pr->name}}</td>
                                    <td>
                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="per-{{$pr->id}}" onclick="performGivPermission({{$pr->id}})" class="custom-control-input"  @checked($pr->assign)>
                                            <label class="custom-control-label" for="per-{{$pr->id}}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                              
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- permissions end -->
    </div>
</section>
@endsection
{{-- 
 --}}
@section('scripts')
<script>
    function performGivPermission(id){

        let dataObj = {
            permission_id : id,
            _method : 'PUT'
        };

        performStoreWithTostar('/roles/{{$role->id}}/giv-permission',dataObj)

    }
</script>
@endsection

