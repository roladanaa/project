@extends('layout.master')

@section('title',__('dash.edit_employee'))
@section('title_page',__('dash.edit_employee'))

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
                                            <input type="text" id="name" class="form-control" placeholder="{{__('dash.name')}}"  value="{{$employee->name}}">
                                            <label for="name">{{__('dash.name')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="national_id" class="form-control" placeholder="{{__('dash.national_id')}}"  value="{{$employee->national_id}}">
                                            <label for="national_id">{{__('dash.national_id')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="email" class="form-control" placeholder="{{__('dash.email')}}"  value="{{$employee->email}}">
                                            <label for="email">{{__('dash.email')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="mobile" class="form-control" placeholder="{{__('dash.mobile')}}"  value="{{$employee->mobile}}">
                                            <label for="mobile">{{__('dash.mobile')}}</label>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <label for="city_id">{{__('dash.city')}}</label>
                                            <select class="select2 form-control select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" id="city_id">
                                                <option value="-1">{{__('dash.city')}}</option>
                                                @foreach ($city as $c)
                                                    <option value="{{$c->id}}" @selected($c->id == $employee->city_id)>{{$c->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <label for="role_id">{{__('dash.role')}}</label>
                                            <select class="select2 form-control select2-hidden-accessible" data-select2-id="2" tabindex="-1" aria-hidden="true" id="role_id">
                                                <option value="-1">{{__('dash.role')}}</option>
                                                @foreach ($roles as $r)
                                                    <option value="{{$r->id}}" @selected($employee->hasRole($r))>{{$r->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    
                                    
                                   
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" onclick="performUpdate()">{{__('dash.save')}}</button>
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
    function performUpdate(){
        let name = document.getElementById('name').value;
        let national_id = document.getElementById('national_id').value;
        let email = document.getElementById('email').value;
        let mobile = document.getElementById('mobile').value;
        let city_id = document.getElementById('city_id').value;
        let role_id = document.getElementById('role_id').value;

        let dataObj = {
            name : name,
            national_id : national_id,
            email : email,
            mobile : mobile,
            city_id : city_id,
            role_id : role_id
            _method : 'PUT'

        };

  
        performUpdateWithTostar('/employees/{{$employee->id}}',dataObj);
    }
</script>
@endsection