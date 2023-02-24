<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
// if (isset($_GET["line"])) {
//     // $fnc->line_notify_msg($_GET["line"]);
// }
?>
<script type="text/javascript">
    <?php
    if (isset($_GET["alert"]) && isset($_GET["title"]) && isset($_GET["msg"])) {
        // echo 'swal("' . $_GET["title"] . '", "' . $_GET["msg"] . '", "' . $_GET["alert"] . '");';
        echo "swal.fire({
            position: 'center',
            icon: '" . $_GET["alert"] . "',
            title: '" . $_GET["title"] . "',
            text: '" . $_GET["msg"] . "',
            showConfirmButton: false,
            timer: 1500
          });";    
        //   $fnc->line_notify_msg();      
    }
    ?>

    function match_approve_confirmation(mid) {
        Swal.fire({
            title: 'Are you sure?',
            text: "คุณต้องการยืนยันแมทซ์แข่งขันนี้ !",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Match Approved!',
                    'กำลังยืนยันแมทซ์แข่งขัน.',
                    'success'
                ).then(function() { window.location = "../db_mgt.php?p=match&act=matchsanctionapprove&mid=" + mid});
            }
        })
    }

    function matchsanction_delete_confirmation(mid) {
        Swal.fire({
            title: 'Are you sure?',
            text: "คุณต้องการลบแมทซ์ที่ขอจัดไว้รายการนี้ !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Match Deleting!',
                    'กำลังลบแมทซ์แข่งขัน.',
                    'success'
                ).then(function() { window.location = "../db_mgt.php?p=match&act=matchsanctiondelete&mid=" + mid});
            }
        })
    }

    function match_delete_confirmation(mid) {
        Swal.fire({
            title: 'Are you sure?',
            text: "คุณต้องการลบแมทซ์แข่งขันนี้ !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Match Deleting!',
                    'กำลังลบแมทซ์แข่งขัน.',
                    'success'
                ).then(function() { window.location = "../db_mgt.php?p=match&act=matchdelete&mid=" + mid});
            }
        })
    }
    
    function pwd_reset_confirmation(soid, new_pwd) {
        Swal.fire({
            title: 'Are you sure?',
            text: "คุณต้องการรีเซ็ทรหัสผ่าน ด้วย" + new_pwd + " ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Reseting Password !',
                    'กำลังเปลี่ยนรหัสผ่านเป็น' + new_pwd + '.',
                    'success'
                ).then(function() { window.location = "../db_mgt.php?p=so&act=pwdreset&soid=" + soid + "&method=" + new_pwd});
            }
        })
    }
</script>