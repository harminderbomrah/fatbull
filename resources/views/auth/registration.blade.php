@include('partials/_header')
<div class="container col-4 mr-auto justify-content-center login-center form">
  <form action="/register" method="post">
    <h3>Please signup with FatBull</h3>
    <div class="mb-3">
      <label for="emailaddress" class="form-label">Email address</label>
      <input type="email" name="email" class="form-control" id="emailaddress" placeholder="name@example.com">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" id="password"></input>
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    </div>
    <div class="mb-3">
      <label for="confirmpassword" class="form-label">Confirm Password</label>
      <input type="password" name="password_confirmation" class="form-control" id="confirmpassword"></input>
    </div>
    <div class="row">
      <span class="text-left col-6">
        <input type="submit" value="SignUp" />
      </span>
      <span class="text-right col-6">
        <a href="{{url('login')}}">Already have an account?</a>
      </span>
    </div>
  </form>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
</div>
@include('partials/_footer')