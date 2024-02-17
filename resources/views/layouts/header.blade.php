<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Admin Dashboard</title>
<link rel="shortcut icon" href="{{ asset("assets/img/afindo.png") }}">
<link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset("assets/plugins/bootstrap/css/bootstrap.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins/feather/feather.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins/icons/flags/flags.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins/fontawesome/css/fontawesome.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins/fontawesome/css/all.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins/simpleline/simple-line-icons.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins/alertify/alertify.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins//toastr/toatr.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins/datatables/datatables.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins/select2/css/select2.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/plugins/summernote/summernote-bs4.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset("assets/plugins/daterangepicker/daterangepicker.css") }}">
<link rel="stylesheet" href="{{ asset("assets/dropify/dist/css/dropify.min.css") }}">
<style>
    div.dt-buttons {
        position: relative;
        float: right;
        margin-bottom: 10px;
    }

    .btn-datatabel {
        margin: 2px;
    }

    .table tbody tr:last-child {
        border-color: #dee2e6;
    }

    .filter {
        height: 45px !important;
    }

    @media screen and (min-width: 768px) {

        /* ketika screen width lebih dari 768px */
        .dt-buttons {
            margin-top: -40px;
        }

        div.dataTables_wrapper div.dataTables_paginate {
            margin-top: -46px;
            white-space: nowrap;
            text-align: right;
        }
    }

    #input-search {
        height: 45px;
    }

    /* Gaya umum untuk pagination */
    .dataTables_wrapper .dataTables_paginate {
        float: right;
        margin-top: 10px;
    }

    /* Gaya untuk setiap elemen pagination (angka dan tombol) */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 0 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    /* Gaya untuk angka aktif */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #007bff;
        color: #fff;
    }

    /* Gaya untuk tombol "Next" dan "Previous" */
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #eee;
    }

    /* Gaya untuk angka tidak dapat diklik pada pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        pointer-events: none;
        color: #ccc;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 0px solid #ccc;
        border-radius: 10px;
        margin: 3px;
        padding: 0px;
        cursor: pointer;
    }

    /* .page-item.active .page-link {
        background-color: #3d5ee1;
        border-color: #3d5ee1;
        border-radius: inherit;
    } */
    /* .sidebar-menu>ul>li{
        width: calc(100%-30px);
    } */
    .sidebar-menu li.active>a {
        /* background-color: #fff; */
        background-color: #f7f7fa;
        color: #3d5ee1;
        position: relative;
        margin: 0 -15px;
        padding-left: 30px;
    }

    .sidebar-menu li.active>a::after {
        width: 20px;
        content: "";
        height:200%;

        /* vertical-align: middle; */
        position: absolute;
        right: 0;
        top: -50%;
        background: #f7f7fa;
        /* background: #3d5ee1; */
        -webkit-transition: all .25s;
        -ms-transition: all .25s;
        transition: all .25s;
        border-radius: 0 0px 0px ; 
    }

    .sidebar-menu li.active>a:hover {
        /* background-color: #fff; */
        background-color: #f7f7fa;
        /* color: #3d5ee1;
        position: relative;
        margin: 0 -15px;
        padding-left: 30px; */
    }

    .sidebar-menu li.active>div.out-circle{
        height: 40px;
        width: 40px;
        top: -40px;
        background-color: #fff;
        border-radius: 0% 0% 50% 50%;
        right: -15px;
        position: absolute;
        /* clip-path: circle(50%); */
        /* z-index: inherit; */
    }

    .sidebar-menu li.active>div.out-circle::after{
        content: "";
        height: 40px;
        width: 40px;
        top: calc(100% + 50px);
        background-color: #fff;
        border-radius:  50% 50% 0% 0%;
        right: 0px;
        position: absolute;
        /* z-index: inherit; */
    }

   

    .sidebar-menu>ul>li>a:hover {
        background-color: #fff;
        color: #3d5ee1;
        margin: 0 -15px;
        padding-left: 30px;
        border-radius: 40px;
    }
    
</style>
