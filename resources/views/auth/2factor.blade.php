@extends('layouts.app')

@section('content')

    @if(config('app.env') == 'production')
        <div class="alert alert-info text-center">
            OTP has been send to your registered mobile number {{ substr_replace( $user->mobile, "XXXXX", 3,5 ) }}
        </div>
    @else
        <div class="alert alert-danger text-center">
            OTP feature is disabled during testing. Please use {{ $user->otp }} as the OTP.
        </div>
    @endif

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
                        <v-toolbar-title>Two Factor Authentication</v-toolbar-title>
                        <v-spacer></v-spacer>
                    
                    </v-toolbar>
                    <v-card-text>
                        <v-form
                            ref="otpform"
                            action="/login"
                            method="post"
                            @submit.prevent="encryptPassword()"
                            id="login-form"
                            autocomplete="off"
                        >
                        @csrf
                        @method('PATCH')
                            <input type="hidden" name="username" value="{{ $user->username }}">
                            <input type="hidden" id="g_token" name="_g-token">
                            <v-text-field
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
                                autocomplete="off" 
                            ></v-text-field>
                            <v-text-field
                                id="otp"
                                label="Six digit OTP"
                                name="otp"
                                prepend-icon="mdi-counter"
                                {{-- type="number" --}}
                                v-model="user.otp"
                                :rules="[v => /^[0-9]{6}$/.test(v) || 'OTP is not valid']"
                                @error('otp') error-messages="{{ $message }}"  @enderror 
                                autocomplete="off"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        {{-- <v-btn 
                            color="green" 
                            text 
                            large
                            type="button"
                            @click="resendOtp"
                        > RESEND OTP </v-btn> --}}
                        <v-btn 
                            color="primary darken-4"
                            text 
                            large
                            type="submit"
                            form="login-form"
                            {{-- @click="login" --}}
                        > LOGIN </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>

@endsection