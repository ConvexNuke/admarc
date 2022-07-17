<!-- plugins:js -->
<script src="../assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="../assets/vendors/chartjs/Chart.min.js"></script>
<script src="../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="../assets/js/material.js"></script>
<script src="../assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="../assets/js/sweetalert2.js"></script>

<script src="../assets/js/dashboard.js"></script>
<!-- End custom js for this page-->
<script src="../assets/js/js.js"></script>
<script src="../assets/datatable/datatables.min.js"></script>
<script src="../assets/js/popper.min.js"></script>

<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

<script type="application/javascript">

    $(document).ready(function () {
        //notification variables
        var placementFrom = "top";
        var placementAlign = "right";
        var style = "withicon";
        var content = {};


        var table = $('table').DataTable({
            columnDefs: [
                {bSortable: true, targets: []}
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv'
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [],
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false


        });


    });

    function showUserProfileModal() {
        $('#user_profile_modal').modal('toggle')
    }

</script>

