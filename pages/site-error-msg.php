<?php
if(isset($_SESSION['SUCCESS']) && isset($_SESSION['MESSAGE'])){
    if($_SESSION['SUCCESS']=='TRUE'){
        ?>
        <script>
            $(document).ready(function () {
                toastr.success('<?= $_SESSION['MESSAGE'] ?>');
            });
        </script>
    <?php
    }else{
        ?>
        <script>
            $(document).ready(function () {
                toastr.error('<?= $_SESSION['MESSAGE'] ?>');
            });
        </script>
    <?php
    }
    unset($_SESSION['SUCCESS']);
    unset($_SESSION['MESSAGE']);
}
?>