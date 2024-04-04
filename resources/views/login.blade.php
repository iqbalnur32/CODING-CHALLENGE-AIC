<html>

<head>
  <title>Login</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style>
    html,
    body {
      height: 100%;
    }

    .global-container {
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f5f5f5;
    }

    form {
      padding-top: 10px;
      font-size: 14px;
      margin-top: 30px;
    }

    .card-title {
      font-weight: 300;
    }

    .btn {
      font-size: 14px;
      margin-top: 20px;
    }


    .login-form {
      width: 330px;
      margin: 20px;
    }

    .sign-up {
      text-align: center;
      padding: 20px 0 0;
    }

    .alert {
      margin-bottom: -30px;
      font-size: 13px;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div id="App">

    <div class="global-container">
      <div class="card login-form">
        <div class="card-body">
          <h3 class="card-title text-center">Log in Pages</h3>
          <div class="card-text">
            <form @submit.prevent="login">
            {{-- <form method="POST" action="{{ route('login.post') }}"> --}}
              @csrf
              <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" class="form-control form-control-sm" v-model="username" id="username" name="username" aria-describedby="emailHelp">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control form-control-sm" v-model="password" name="password" id="exampleInputPassword1">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <!-- Boostraps -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>

    var app = new Vue({
      el: '#App',
      data: {
        username: '',
        password: '',
      },

      methods: {
        login: function () {
          fetch('{{ route('login.post') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
              username: this.username,
              password: this.password
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.code === 200) {
              window.location.href = '{{ route('formPembayaranBonus.index') }}';
            } else {
              alert(data.message);
            }
          })
          .catch(error => console.log(error))
        }
      }
    });
  </script>

</body>
</html>