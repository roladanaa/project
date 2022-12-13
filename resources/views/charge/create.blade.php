@extends('layout.master')

@section('title',__('dash.create_charge'))
@section('title_page',__('dash.create_charge'))

@section('content')
<section id="multiple-column-form ">
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
                                    


                                    <div class="col-12" id="infoEle" >
                                       
                                    </div>



                                    <div class="col-md-6 col-12" >
                                        <div class="form-label-group">
                                            <input type="text" id="mobile" class="form-control" placeholder="{{__('dash.mobile')}}"  required>
                                            <label for="mobile">{{__('dash.mobile')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="amount" class="form-control" placeholder="{{__('dash.amount')}}"  required>
                                            <label for="amount">{{__('dash.amount')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="description" class="form-control" placeholder="{{__('dash.description')}}"  required>
                                            <label for="description">{{__('dash.description')}}</label>
                                        </div>
                                    </div>
                                   
                                    <div class="row col-12">
                                        
                                        <div class="col-md-8 col-12" id="codeEle" style="display: none">
                                            <div class="form-label-group">
                                                <p class='text-danger' id="alertAmount"></p>
                                                <input type="text" id="code" class="form-control" placeholder="{{__('dash.code')}}"  required>
                                                <label for="code">{{__('dash.code')}}</label>
    
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="btnSendCode" style="display: none">
                                            <button type="button"  class="btn btn-success mr-1 mb-1 waves-effect waves-light" onclick="sendCode()" style=" margin: 11px; ">{{__('dash.send')}}</button>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                   
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" onclick="performCharge()">{{__('dash.save')}}</button>
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

document.getElementById('mobile').onchange = function(){
    getUserInfo();
}

    function getUserInfo(){
        let mobile = document.getElementById('mobile').value;
        let infoEle = document.getElementById('infoEle');
        let btnSendCode = document.getElementById('btnSendCode');
        let codeEle = document.getElementById('codeEle');
        let dataObj = {
            mobile : mobile,
        };

        try{
                sweetLoad();
                axios.post('/charge/user/info',dataObj).then(function(response){
                    let info = response.data;
                    let htmlInfoUser = `
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="users-view-image mb-1" style=" width: 150px; height: 120px; ">
                                    <img src="{{asset('assets/images/wallet.png')}}" class="users-avatar-shadow w-100 h-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                </div>
                                <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                    <table class="customTable">
                                        <tbody><tr>
                                            <td class="font-weight-bold">{{__('dash.name')}}</td>
                                            <td>${info.name}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{__('dash.email')}}</td>
                                            <td>${info.email}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{__('dash.national_id')}}</td>
                                            <td>${info.national_id}</td>
                                        </tr>
                                    </tbody></table>
                                </div>
                                <div class="col-12 col-md-12 col-lg-5">
                                    <table class="ml-0 ml-sm-0 ml-lg-0">
                                        <tbody class="customTable"><tr>
                                            <td class="font-weight-bold"> {{__('dash.mobile')}}</td>
                                            <td>${info.mobile}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{__('dash.balance')}}</td>
                                            <td>${info.wallet.balance}</td>
                                        </tr>
                                    </tbody></table>
                                </div>
                                
                            </div>
                        </div>
                    </div>`;

                    infoEle.innerHTML = htmlInfoUser;

                    btnSendCode.style.display = 'block';
                    codeEle.style.display = 'block';
                    removSweet();
                }).catch(function(error){
                    toastr.error(error.response.data.message,error.response.data.title, { "progressBar": true });
                    removSweet();
                });
            }catch(error){
                removSweet();
                errorSweet('حدث خطأ اثناء تنفيذ العملية');
            }



    



    }

    function sendCode(){
        performStoreWithTostar('/charge/send-code',{});
    }

    function performCharge(){
        let mobile = document.getElementById('mobile').value;
        let amount = document.getElementById('amount').value;
        let code = document.getElementById('code').value;
        let description = document.getElementById('description').value;
        let dataObj = {
            mobile : mobile,
            amount : amount,
            code : code,
            description : description
        };
        performStoreWithTostar('/charge',dataObj);

    }

</script>
@endsection