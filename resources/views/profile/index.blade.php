@extends('layouts.main')

@section('sidebar')
    @if(auth()->user()->isAdmin)
        @include('partials.adminSidebar')    
    @else
        @include('partials.sidebar')        
    @endif
@endsection


@section('container')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container my-5 mx-3">

            @if (session()->has('success'))
                <div class="alert alert-success col-md-8 p-3 mb-3" role="alert">{{ session('success') }}</div> 
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger col-md-7 p-3 mb-3" role="alert">
                    <h6 class="mb-2">Action Failed!</h6>
                    <p>{{ session('error') }}</p>
                </div> 
            @endif

            @if($errors->any())
                <div class="alert alert-danger col-md-8 p-3 mb-3" role="alert">
                    <h6>Action Failed!</h6>
                    <ul class=" mt-2 mb-0 ms-3">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                    </ul>
                </div> 
            @endif
            
            <div class="position-relative">
                @if (auth()->user()->image)
                    <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Profile Picture" width="200" class="border border-warning-subtle">          
                @else
                    <img src="/image/profile.jpeg" alt="Profile Picture" width="200"  class="border border-warning-subtle">      
                @endif
                
                <form action="/profile/image" method="post" enctype="multipart/form-data" class="row g-3 mt-2">
                    @method('put')
                    @csrf
                    <div class="col-auto">
                        <label for="image" class="form-label me-2 py-1">Upload Image</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control p-1" type="file" id="image" name="image" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary ms-1 p-1">Upload</button>
                    </div>
                </form>
            </div>

            <hr class="mt-3 border border-primary border-3 opacity-50">

            <table class="mt-3">
                <tr >
                    <td class="px-1"><h4>Name</h4></td>
                    <td class="px-2"><h4>:</h4></td>
                    <td><h4>{{ auth()->user()->name }}</h4></td>
                <tr>
                    <td class="px-1"><h4>Email</h4></td>
                    <td class="px-2"><h4>:</h4></td>
                    <td><h4>{{ auth()->user()->email }}</h4></td>
                    <td class="px-3"><button type="button" class="btn btn-warning p-1 border" data-bs-toggle="modal" data-bs-target="#changeEmail">Change Email</button></td>
                </tr>
            </table>
            <div class="modal position-fixed top-50 start-50 fade modal-dialog modal-dialog-centered" id="changeEmail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="/profile/email" method="POST" class="p-2">
                            @method('put')
                            @csrf
                            <div class="modal-header mb-3">
                                <h5 class="modal-title" id="staticBackdropLabel">Change Email</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" autofocus required>
                                    <label for="email">New Email Address</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                    <label for="password">Your Password</label>
                                </div>
                            </div>
                            <div class="modal-footer py-2">
                                <button type="button" class="btn btn-secondary p-1" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary ms-2 p-1">Change</button>
                            </div>
                        </form>            
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-warning mt-3 p-1 border" data-bs-toggle="modal" data-bs-target="#changePw">Change Password</button>
            <div class="modal position-fixed top-50 start-50 fade modal-dialog modal-dialog-centered" id="changePw" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="/profile/pw" method="POST" class="p-2">
                            @method('put')
                            @csrf
                            <div class="modal-header mb-3">
                                <h5 class="modal-title" id="staticBackdropLabel">Change Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating">
                                    <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password" autofocus required>
                                    <label for="old_password">Old Password</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password" required>
                                    <label for="new_password">New Password</label>
                                </div>
                            </div>
                            <div class="modal-footer py-2">
                                <button type="button" class="btn btn-secondary p-1" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary ms-2 p-1">Change</button>
                            </div>
                        </form>            
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection