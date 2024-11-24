<?php

$toastMessage = '';
$toastClass = '';

if (isset($_SESSION['success_msg'])) {
    $toastMessage = $_SESSION['success_msg'];
    $toastClass = 'bg-success';
    unset($_SESSION['success_msg']);
} elseif (isset($_SESSION['error_msg'])) {
    $toastMessage = $_SESSION['error_msg'];
    $toastClass = 'bg-danger';
    unset($_SESSION['error_msg']);
}

?>

<!-- toast container -->
<?php if (!empty($toastMessage)): ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast <?php echo $toastClass; ?>" role="alert" aria-live="assertive" aria-atomic="true"
            data-autohide="false">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" style="color: whitesmoke;">
                <?php echo htmlspecialchars($toastMessage); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var toastEl = document.getElementById('liveToast');
        if (toastEl) {
            // Create a Bootstrap Toast instance
            var toast = new bootstrap.Toast(toastEl, {
                animation: true, // Enable fade animations
                autohide: true,  // Automatically hide after a delay
            });

            // Show the toast
            toast.show();
        }
    });

</script>