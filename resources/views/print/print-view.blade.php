<!DOCTYPE html>
<html>

<head>
    <title>User List - Warehouse Harem Hospital (Print)</title>
    <style>

      .clearfix{
        display: flex;
        justify-content: space-between;
        height: 80px;

      }
        /* Define your print-specific styles here */
        .clearfix1:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm;
  border:1px solid black; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}


table td {
  text-align: center;
  padding: 5px 20px;
  border-right: 1px solid black;
  border-bottom: 1px solid black;
  border-left: 1px solid black;

  border-top: 1px solid black;
  
}

table td:last-child(){
  border: none !important;
}

table th {
  padding: 5px 20px;
  color: #000000;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;       
  font-weight: bolder;
  border-bottom: 1px solid black;

}



table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 15px;
}
    </style>
</head>
<header class="clearfix" style="position: relative;">
  
  <div id="project" style="position: absolute; left: 0; margin-left: 10px">
    <div><span>cCompany</span> Harem Hospital</div>
    <div><span>CLIENT</span> Users</div>
    <div><span>ADDRESS</span> jaday 60 matre</div>
    <div><span>EMAIL</span> <a href="mailto:john@example.com">haremhospital@gmail.com</a></div>
    <div><span>DATE</span> August 17, 2015</div>
  </div>
  <div id="logo" style="position: absolute; left: 50%; transform: translateX(-50%);">
    <img src="{{ asset('assets/img/harem.jpg') }}">
  </div>


  <div id="company" class="clearfix1" style="position: absolute; right:  0; margin-right: 10px">
    <div>Company Name</div>
    <div>455 Foggy Heights,<br /> AZ 85004, US</div>
    <div>(602) 519-0450</div>
    <div><a href="mailto:company@example.com">company@example.com</a></div>
  </div>
    </header>


<body>
    <h1>User List - Warehouse Harem Hospital (Print)</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created_On</th>
                <th>Status</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->created_at}}</td>
                    <td>
                      @if ($user->is_enabled == 1)
                          Enabled
                      @else
                          Disabled
                      @endif
                  </td>
                    <td>{{ $user->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
      // Open the print dialog when the page loads
      window.onload = function() {
          window.print();
      };

      // Automatically redirect after printing
      window.onafterprint = function() {
          window.history.back(); // Go back to the previous page
      };
      </script>
</body>

</html>
