<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="category-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Category Management"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            
                        </div>
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{route('create-category')}}"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New
                                Category</a>
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
                                                Title</th>
                                            <th
                                                class="text-center text-uppercase text-secondary font-weight-bolder ">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary font-weight-bolder ">
                                                Slug</th>
                                            <th class="text-secondary "></th>
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
<script src="{{ asset('assets/js/tables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/tables/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/tables/dataTables.buttons.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">

$(function() {

var table = $('#data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ url('admin/categories') }}",
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'title',
            name: 'title'
        },
        {
            data: 'slug',
            name: 'slug'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ]
});

});
</script>