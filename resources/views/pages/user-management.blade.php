<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            
                        </div>
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{route('create-user')}}"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New
                                User</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="data-table" class="table table-striped table-bordered table-responsive"
                                cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary font-weight-bolder ">
                                                ID
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary font-weight-bolder  ps-2">
                                                first name</th>
                                            <th
                                                class="text-center text-uppercase text-secondary font-weight-bolder ">
                                                last name</th>
                                            <th
                                                class="text-center text-uppercase text-secondary font-weight-bolder ">
                                                email</th>
                                            <th
                                                class="text-center text-uppercase text-secondary font-weight-bolder ">
                                                phone
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary font-weight-bolder ">
                                              Created At
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary font-weight-bolder ">
                                                Action
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

</x-layout>
<script src="{{ asset('assets') }}/js/core/jquery.min.js"></script>
<script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
<script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/tables/jquery.dataTables.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset('assets/js/tables/dataTables.bootstrap4.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset('assets/js/tables/dataTables.buttons.min.js') }}"  type="text/javascript"></script>

<script type="text/javascript">


$(document).ready(function() {

    $('#data-table').DataTable({    
    processing: true,
    serverSide: true,
    ajax: "{{ url('admin/users') }}",
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'first_name',
            name: 'first_name'
        },
        {
            data: 'last_name',
            name: 'last_name'
        },
        {
            data: 'email',
            name: 'email'
        },
        {
            data: 'phone',
            name: 'phone'
        },
        {
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ]
});
})

</script>