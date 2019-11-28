$(document).ready(function () {
    $('#dtOrderExample').DataTable({
    "order": [[ 3, "desc" ]]
    });
    $('.dataTables_length').addClass('bs-select');
    });

    function datesSorter(a, b) {
        if (new Date(a) < new Date(b)) return 1;
        if (new Date(a) > new Date(b)) return -1;
        return 0;
      }