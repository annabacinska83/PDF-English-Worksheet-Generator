<x-layoutNav>
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col my-5 px-5 d-flex ">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="text-left text-secondary px-3 mb-5">
                            <h5 class="py-3">Access Control</h5>
                            <p class="py-2">Manage users of your worksheet generator and define their access level. Admins can manage the platform, while regular users can create and work with their own worksheets.</p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 px-5">
                <div class="table-responsive rounded-3 overflow-hidden shadow-sm border">
                    <table id="usersTable" class="table m-0 mb-0">
                     <thead class="table-dark">
                     <tr>
                         <th scope="col">#</th>
                         <th scope="col">Full name</th>
                         <th scope="col">Email</th>
                         <th scope="col">Registered on</th>
                         <th scope="col">Role</th>
                         <th scope="col"></th>
                     </tr>
                     </thead>
                     <tbody>
                         @foreach($users as $user)
                             <tr>
                                 <th scope="row">{{ $user['user_id'] }}</th>
                                 <td>{{ $user['name'] }}</td>
                                 <td>{{ $user['email'] }}</td>
                                 <td>{{ $user['created_at'] }}</td>
                                 <td>{{ $user['admin'] == 1 ? 'admin' : 'user' }}</td>
                                 <td>
                                     <form class="m-0 p-0" METHOD="POST" action="{{ route('admin.delete') }}">
                                         @csrf
                                         @method('DELETE')
                                         <input name="id" type="hidden" value="{{ $user['user_id'] }}">
                                         <button class="border-0 bg-transparent">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                 <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                 <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                             </svg>
                                         </button>
                                     </form>
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
                </div>
             </div>
         </div>
    </div>
</x-layoutNav>
