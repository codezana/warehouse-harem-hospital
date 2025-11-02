<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/harem.jpg') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">



    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

 
</head>
<body>
    <h5 style="text-align: center;margin: auto">User List - Warehouse Harem Hospital (PDF)</h5>

    <div class="table-responsive">
        <table class="table  datanew">
            <thead>
                <tr>
                   
                    <th>Profile</th>
                    <th>User name </th>
                    <th>Phone</th>
                    <th>email</th>
                    <th>role</th>
                    <th>Created On</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user )
                    
      
                <tr>

                    <td class="productimgname">
                        <a href="javascript:void(0);" class="product-img">
                            <img src="assets/img/customer/customer1.jpg" alt="product">
                        </a>
                    </td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }} </td>
                    <td>{{ $user->status }}</td>
                    <td>{{ $user->formatted_created_at }}</td>


                    <td>
                        @if ($user->is_enabled)
                        <a href="{{ route('toggleStatus', ['id' => $user->id]) }}" class="bg-lightgreen badges">Enable</a>

                        @else
                        <a href="{{ route('toggleStatus', ['id' => $user->id]) }}" class="bg-lightred badges">Disable</a>

                        @endif
                    </td>
                  
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
