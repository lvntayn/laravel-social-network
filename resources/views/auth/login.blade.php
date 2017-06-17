<form role="form" method="POST" action="{{ route('login') }}">
    <input type="hidden" value="login" name="tab" />
    {{ csrf_field() }}

    <h2>Connect with around.kim to people!</h2>



    <div class="row">
        <div class="form-group{{ old('tab') != 'register' && $errors->has('email') ? ' has-error' : '' }} col-md-12">
            <label for="email" class="control-label">E-Mail Address</label>



            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i> </span>
                <input id="email" type="email" class="form-control" placeholder="email@example.com" name="email" value="{{ old('email') }}" required>

            </div>
            @if (old('tab') != 'register' && $errors->has('email'))
                <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
            @endif
        </div>

        <div class="form-group{{ old('tab') != 'register' && $errors->has('password') ? ' has-error' : '' }} col-md-12">
            <label for="password" class="control-label">Password</label>

            <div  class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock-alt"></i> </span>

                <input id="password" type="password" placeholder="*********" class="form-control" name="password" required>


            </div>
            @if (old('tab') != 'register' && $errors->has('password'))
                <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
            @endif
        </div>

        <div class="form-group col-md-12">
            <div class="checkbox checkbox-primary">
                <input id="checkbox2" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="checkbox2">
                    Remember Me
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
                <button type="submit" class="btn btn-primary btn-login">
                    Log In
                </button>

                <div class="clearfix"></div>

                <a class="btn btn-link btn-forgot hidden" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
            </div>
        </div>


        <div class="clearfix"></div>

        <div class="sub-title">
            <hr />
            <span>or</span>
        </div>


        <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
                <button type="submit" class="btn btn-primary btn-facebook">
                    <i class="fa fa-facebook-square"></i> Connect with Facebook
                </button>
            </div>
        </div>



    </div>
</form>