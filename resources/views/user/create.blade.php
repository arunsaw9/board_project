@extends('layouts.app')

@section('content')
    
    <div class="container mt-2">

        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-primary"> <v-icon color="primary">mdi-account-plus</v-icon> Create User</h3>

                <form action="/user" method="post">
                @csrf 
                    <div class="row">
                        <div class="col-6">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label for="designation">Designation</label>
                            <input type="text" name="designation" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="username">Login Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        {{-- <div class="col-6">
                            <label for="password">Default Password</label>
                            <input type="text" value="Board@123!" class="form-control" disabled>
                        </div> --}}
                        <div class="col-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label for="mobile">Mobile No</label>
                            <input type="text" name="mobile" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="invitee">Invitee</option>
                                {{-- <option value="special">Special Invitee</option> --}}
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">Create</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection