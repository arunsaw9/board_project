@extends('layouts.app')

@section('content')

    <v-container
        fluid
        fill-height
    >
        <v-row
            align="center"
            justify="center"
        >
            <v-col
            cols="12"
            sm="8"
            md="4"
            >
                <v-card class="elevation-12" min-width="400">
                    <v-toolbar
                    @if(config('app.company') == 'ovl')
                        color="blue darken-2"
                    @elseif(config('app.company') == 'opal')
                        color="red darken-2"
                    @elseif(config('app.company') == 'mrpl')
                        color="lime darken-2"
                    @elseif(config('app.company') == 'otpc')
                        color="orange darken-2"
                    @elseif(config('app.company') == 'ompl')
                        color="green darken-2"
                    @elseif(config('app.company') == 'msez')
                        color="green darken-2"
                    @endif
                    dark
                    flat
                    >
                        <v-toolbar-title>Login</v-toolbar-title>
                        <v-spacer></v-spacer>
                    
                    </v-toolbar>
                    <v-card-text>
                        <v-form
                            ref="form"
                            action="/login"
                            method="post"
                            @submit.prevent="login"
                            id="login-form"
                            autocomplete="off"
                        >
                        @csrf
                            <v-text-field
                                label="Username"
                                name="username"
                                prepend-icon="mdi-account"
                                type="number"
                                v-model="user.username"
                                :rules="[v => /[0-9]+/.test(v) || 'Username is not valid']"
                                @error('username') error-messages="Incorrect Captcha"  @enderror 
                                autocomplete="off" 
                                autofocus
                            ></v-text-field>
                            
                            {{-- <div class="mt-2 d-flex justify-content-start" style="margin-left:24px"> --}}
                                {{-- <div id="captcha"></div> --}}
                            {{-- </div> --}}
                            <div class="row ml-4">
                                {{-- <label for="captcha" class="col-md-4 col-form-label text-md-right">{{ __('Captcha') }}</label> --}}
                                <div class="col-12">
                                    <div class="captcha">
                                        <span class="captcha-container" >{!! Captcha::img('flat') !!} </span>
                                        {{-- <button type="button" class="btn btn-secondary"><v-icon id="refresh" dark>mdi-refresh</v-icon></button> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <input placeholder="Enter Captcha" id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" name="captcha" required> --}}
                            <v-text-field
                                label="Enter Captcha"
                                name="captcha"
                                prepend-icon="mdi-numeric"
                                type="number"
                                :rules="[v => /[0-9]+/.test(v) || 'Captcha is not valid']"
                                @error('captcha') error-messages="{{ $message }}"  @enderror 
                                autocomplete="off" 
                            ></v-text-field>

                            {{-- <v-text-field
                                id="password"
                                label="Password"
                                name="password"
                                :type="passwordVisible ? 'text' : 'password'"
                                prepend-icon="mdi-lock"
                                :append-icon="passwordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append="passwordVisible = !passwordVisible"
                                v-model="user.password"
                                :rules="[v => !!v || 'Password cannot be blank']"
                                @error('password') error @enderror
                                autocomplete="current-password" 
                            ></v-text-field> --}}
                            {{-- <v-checkbox v-model="user.remember" label="Remember Me"></v-checkbox> --}}
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="green darken-2"
                            text
                            large
                            type="button"
                            href="/password/reset"
                        > FORGOT PASSWORD </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn 
                            color="primary darken-4" 
                            text 
                            large
                            type="submit"
                            form="login-form"
                            {{-- @click="login" --}}
                        > GET OTP </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>


{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection