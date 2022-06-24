<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <title>Registration</title>
  </head>
  <body>
    <div class="container mt-5">
        <h5>Registration Form</h5>
        <form id="regForm" method="POST" action="{{ route('submit.data') }}" class="needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" class="form-control form-field" id="full_name" placeholder="Enter Full Name" required>
                <div class="invalid-feedback">
                    Full Name is Not Valid.
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control form-field" id="email" placeholder="Enter email" required>
                <div class="invalid-feedback">
                    Invalid Email Format.
                </div>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control form-field" id="phone_number" placeholder="Enter Phone Number" required>
                <div class="invalid-feedback">
                    Invalid Phone Number Format.
                </div>
            </div>
            <div class="form-group">
                <label for="birth_date">Birth Date</label>
                <input type="text" class="form-control form-field" id="birth_date" placeholder="Select Birth Date" required>
                <div class="invalid-feedback">
                    Invalid Birth Date Format.
                </div>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="text" class="form-control form-field" id="age" placeholder="Computed From Birth Date..." disabled required>
                <div class="invalid-feedback">
                    Invalid Age Format.
                </div>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control form-field" id="gender" required>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>
                <div class="invalid-feedback">
                    Invalid Gender Selection.
                </div>
              </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    {{-- Javascript --}}
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#birth_date').datepicker({
                uiLibrary: 'bootstrap4'
            });


            var date_regex = new RegExp("/^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(0[1-9]|1[1-9]|2[1-9])$/");

            $('#birth_date').on('change',function(){
                var today = new Date();
                dateString = $(this).val();
                var birthDate = new Date(dateString);
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                $('#age').val(age);
            });


            $('#regForm').submit(function(e) {
                e.preventDefault();

                $(".form-field").removeClass('is-invalid');

                // perform validation
                var errors = 0;
                // validate name
                if(!/^[a-zA-Z., ]+$/.test($('#full_name').val())){
                    errors+=1;
                    $('#full_name').toggleClass('is-invalid');
                }

                if(!/.+@.+\..+/.test($('#email').val())){
                    errors+=1;
                    $('#email').toggleClass('is-invalid');
                }

                if(!/^(09|\+639)\d{9}$/.test($('#phone_number').val())){
                    errors+=1;
                    $('#phone_number').toggleClass('is-invalid');
                }
                $bdate = $('#birth_date').val();
                if(!$bdate.length){
                    errors+=1;
                    $('#birth_date').toggleClass('is-invalid');
                }
                ageVal = $('#age').val();
                if(!ageVal.length){
                    errors+=1;
                    $('#age').toggleClass('is-invalid');
                }

                if(errors === 0){
                    // submit data to AJAX POST

                    $.ajax({
                        type:'POST',
                        url: "{{ route('submit.data') }}",
                        data: {
                            full_name:$('#full_name').val(),
                            email:$('#email').val(),
                            phone_number:$('#phone_number').val(),
                            birth_date:$('#birth_date').val(),
                            age:$('#age').val(),
                            gender:$('#gender').val()
                        },
                        success: (data) => {
                            alert('Data Saved Successfully!');
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }




            });

        });
    </script>
  </body>
</html>
