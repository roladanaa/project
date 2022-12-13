@extends('layout.master')

@section('title',__('dash.create_paypoint'))
@section('title_page',__('dash.create_paypoint'))

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
                                            <input type="text" id="name_ar" class="form-control" placeholder="{{__('dash.name_ar')}}"  required>
                                            <label for="name_ar">{{__('dash.name_ar')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="name_en" class="form-control" placeholder="{{__('dash.name_en')}}"  required>
                                            <label for="name_en">{{__('dash.name_en')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="email" class="form-control" placeholder="{{__('dash.email')}}"  required>
                                            <label for="email">{{__('dash.email')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="mobile" class="form-control" placeholder="{{__('dash.mobile')}}"  required>
                                            <label for="mobile">{{__('dash.mobile')}}</label>
                                        </div>
                                    </div>




                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <label for="compony_id">{{__('dash.compony')}}</label>

                                            <select class="select2 form-control select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" id="compony_id">
                                                <option value="-1">{{__('dash.compony')}}</option>
                                                @foreach ($compony as $c)
                                                    <option value="{{$c->id}}">{{$c->name}}</option>
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
                                                    <option value="{{$r->id}}">{{$r->name}}</option>
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
        let name_ar = document.getElementById('name_ar').value;
        let name_en = document.getElementById('name_en').value;
        let email = document.getElementById('email').value;
        let mobile = document.getElementById('mobile').value;
        let compony_id = document.getElementById('compony_id').value;
        let role_id = document.getElementById('role_id').value;

        let dataObj = {
            name_ar : name_ar,
            name_en : name_en,
            email : email,
            mobile : mobile,
            compony_id : compony_id,
            role_id : role_id

        };

        performStoreWithTostar('/pay_points',dataObj,'form');
    }
</script>
@endsection