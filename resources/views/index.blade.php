<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./temp/assets/css/index.css">
   <style>
    strong{
      color:white;
    }
   </style>
</head>
@error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
<body>
<div class="wrapper">
      <div class="title-text">
        <div class="title login">Login Form</div>
        <div class="title signup">Signup Form</div>
      </div>
      <div class="form-container">
        <div class="slide-controls">
          <input type="radio" name="slide" id="login" checked>
          <input type="radio" name="slide" id="signup">
          <label for="login" class="slide login">Login</label>
          <label for="signup" class="slide signup">Signup</label>
          <div class="slider-tab"></div>
        </div>
        <div class="form-inner">
          <form method="POST" action="{{ route('login') }}" class="login">
          @csrf  
          <div class="field">
          <x-text-input placeholder="Email" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>
            <div class="field">
            <x-text-input placeholder="Password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            </div>
           
            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="  {{ __('Login') }}">
            </div>
            
          </form>
          <form method="POST" action="{{ route('register') }}" class="signup">
         @csrf
         <div class="field">
         <x-text-input placeholder="Name" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>  
          <div class="field">
          <x-text-input placeholder="Email" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>
            <div class="field">
            <x-text-input placeholder="Password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />            </div>
            <div class="field">
            <x-text-input placeholder="Confirm Password" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />            </div>
            <div class="field">
            <x-text-input placeholder="Unique Password" id="unique_password" class="block mt-1 w-full"
                            type="password"
                            name="unique" required  />
            </div>
            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="{{ __('Register') }}">
            </div>
          </form>
        </div>
      </div>
    </div>

</body>
<script src="./temp/assets/js/index.js"></script>
</html>