<?php
if (isset($_SESSION['delete_msg'])) {
    $delete_msg = $_SESSION['delete_msg'];
    unset($_SESSION['delete_msg']);
}
?>

<!-- toast container -->
<?php if (!empty($delete_msg)): ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-white">
                <?php echo htmlspecialchars($delete_msg); ?>
                <div class="mt-2 pt-2 border-top">
                    <a href="fn_adminDelete.php?deleteAdminID=<?php echo $_SESSION['deleteAdminID'] ?>"
                        class="btn btn-warning btn-sm">Delete</a>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast"
                        onclick="removeGetURL()">Close</button>
                </div>
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
                delay: 5000,     // Delay in milliseconds (5 seconds)
            });

            // Show the toast
            toast.show();

            // Attach event listener to remove GET parameters when toast hides
            toastEl.addEventListener('hidden.bs.toast', function () {
                removeGetURL();
            });
        }
    });

    function removeGetURL() {
        // Remove the 'deleteAdminID' from the URL
        const url = new URL(window.location.href);
        url.searchParams.delete('deleteAdminID');
        window.history.replaceState(null, '', url.toString());
    }
</script>