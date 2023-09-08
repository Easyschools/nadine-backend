<!DOCTYPE html>
<html lang="en">

<head>
    <title>Arabic Book</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content=""/>
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded"/>
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset("assets/images/favicon.ico")}}" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">


</head>
<body>
<!-- [ auth-signin ] start -->
<div class="auth-wrapper" id="app">
    <div class="auth-content">
        <div class="card">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <img src="assets/images/logo-dark.png" alt="" class="img-fluid mb-4">
                        <h4 class="mb-3 f-w-400">Signin</h4>
                        <div class="form-group mb-3">
                            <label class="floating-label" for="Email">Email address</label>
                            <input type="text" v-model="email" class="form-control" id="Email"  placeholder="">
                        </div>
                        <div class="form-group mb-4">
                            <label class="floating-label" for="Password">Password</label>
                            <input type="password" v-model="password" class="form-control" id="Password" placeholder="">
                        </div>
                        <div class="form-group mb-4" v-if="show">
                            <p class="text-danger">invalid email or password</p>
                        </div>

                        <button type="button" class="btn btn-block btn-primary mb-4" @click="login">Signin</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="{{asset("assets/js/vendor-all.min.js")}}"></script>
<script src="{{asset("assets/js/plugins/bootstrap.min.js")}}"></script>
<script src="{{asset("assets/js/ripple.js")}}"></script>
<script src="{{asset("assets/js/pcoded.min.js")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
<script>
    var app = new Vue({
        el: '#app',
        data:{
            email:'',
            password:'',
            show:false
        },
        methods:{
            login:function(){
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.post('/admin/do-login',{
                    password:this.password,
                    email:this.email,
                    _token:"{{csrf_token()}}",
                })
                    .then((response) =>{
                        console.log('success');
                        window.location.href = '/admin/home/';
                    })
                    .catch( (error) =>{
                        this.show=true;
                    })
            }
        }
    })
</script>

</body>
</html>
