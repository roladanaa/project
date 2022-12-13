@extends('layout.master')

@section('title',__('dash.create_roles'))
@section('title_page',__('dash.create_roles'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" id="form">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="name" class="form-control" placeholder="{{__('dash.name')}}"  required>
                                            <label for="name_ar">{{__('dash.name')}}</label>
                                        </div>
                                    </div>




                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <label for="guard">{{__('dash.guard')}}</label>

                                            <select class="select2 form-control select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" id="guard">
                                                <option value="-1">{{__('dash.guard')}}</option>
                                                @foreach (config('auth.guards') as $k => $f)
                                                    <option value="{{$k}}">{{$k}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    
                                    
                                   
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" onclick="performStore()">{{__('dash.save')}}</button>
                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">{{__('dash.reset')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function performStore(){
        let name = document.getElementById('name').value;
        let guard = document.getElementById('guard').value;

        let dataObj = {
            name : name,
            guard : guard,

        };

  
        performStoreWithTostar('/roles',dataObj,'form');
    }
</script>
@endsection