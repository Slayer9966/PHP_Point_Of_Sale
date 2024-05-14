@extends('superAdminNav')
@section('content')

<div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
            
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-12 latest-update-tracking">
    <!-- modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                <form method="POST" action="{{ route('addcashier') }}" >
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label"> Name</label>
                            <x-text-input class="form-control"  id="name"  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />

                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Email</label>
                            <x-text-input class="form-control"  id="email"  type="email" name="email" :value="old('email')" required autocomplete="username" />

                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <x-text-input class="form-control"  id="password" 
                            type="password"
                            name="password"
                            required autocomplete="new-password" />                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Confrim Password</label>
                            <x-text-input class="form-control"  id="password_confirmation" 
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Unique Password</label>
                            <x-text-input class="form-control"  id="unique_password" 
                            type="password"
                            name="unique" required  />                        </div>
                      


                             

                            <input type="submit" value="{{ __('Register') }}">
                    </form>
                </div>


            </div>

        </div>
    </div>
</div>    
   
    <!-- modal -->

    <!-- modal for password chage -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                <form method="POST" action="{{ route('updateuser') }}" >
                        @csrf
                        

                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Name</label>
                            <x-text-input class="form-control"  id="name1" 
                            type="text"
                            name="name1"
                            required autocomplete="new-password" readonly/>                        </div>
                            <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Email</label>
                           <input type="text" id="em" readonly class="form-control">                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">New Password</label>
                            <x-text-input class="form-control"  id="password1" 
                            type="password"
                            name="password"
                            required autocomplete="new-password" />                        </div>
                            <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Your Unique Password</label>
                            <x-text-input class="form-control"  id="password3" 
                            type="password"
                            name="un"
                            required autocomplete="new-password" />                        </div>
                      
                           

                             

                            <button class="btn btn-primary" type="submit">Change</button>
                    </form>
                </div>


            </div>

        </div>
    </div>
</div>    
    <!-- odal for password change -->
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1"
                data-bs-whatever="@mdo">
           <i class="fa-solid fa-user-plus"></i>
           </button>
           <br>
           <br>
                           
<div class="card">
                    
                        <div class="card-header latest-update-heading d-flex justify-content-between">
                            <h4 class="latest-update-heading-title text-bold-500">ALL USERS</h4>

                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Login</th>
                                         <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($users as $item)
                                    @if($item->id !== auth()->id())
                                    <tr>

<td>{{$item->name}}</td>
<td>{{$item->email}}</td>
<td>{{$item->Text_Password}}

</td>
<td>    <a href="{{ route('loginuser', ['id' => $item->id]) }}" class="btn btn-primary">Login</a>
</td>
<td>
    <pre><button style="background-color:transparent;border:none;" class="update " value="{{$item->id}}" data-bs-toggle="modal"data-bs-target="#exampleModal"><i class="fa-regular fa-pen-to-square"></i></button><a href="{{route('deleteuser',['id' => $item->id])}}"><button style="background-color:transparent;border:none;" class="delete "><i class="fa-regular fa-trash-can"></i></button></a></pre>
</td>


</tr>
    @endif
                                   

                                    @endforeach
                                    
                                </tbody>

                            </table>


                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
</div>
</div>




</div>
<script>
$(document).on('click', '.update', function (e) {
        e.preventDefault()
        var id = $(this).val()
        $('#exampleModal').modal('show');
        $.ajax({
            type: "GET",
            url: "/edit2/" + id,
            success: function (response) {

                if (response.status == 404) {
                    $('#success_messege').html("");
                    $('#success_messege').addClass('alert alert-danger');
                    $('#success_messege').text(response.messege);
                    console.log("eor")
                }
                else {
                    $('#id').val(response.User.id);
                    $('#name1').val(response.User.name);
                    $('#em').val(response.User.email);
                    console.log(response); // Check the entire response object
console.log(response.User); // Check the User object
console.log(response.User.email);
                    
                   

                    
                }
            }
        })
    })
</script>
@endsection