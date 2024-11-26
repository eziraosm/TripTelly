<?php
if (isset($_SESSION['delete_msg'])) {
    $delete_msg = $_SESSION['delete_msg'];
    unset($_SESSION['delete_msg']);
}

if (isset($_SESSION['deleteAdminID'])) {
    $deleteID = $_SESSION['deleteAdminID'];
    $fnDeletePage = "fn_accountDelete.php?deleteAdminID=";
} elseif (isset($_SESSION['deleteCustomerID'])) {
    $deleteID = $_SESSION['deleteCustomerID'];
    $fnDeletePage = "fn_accountDelete.php?deleteCustomerID=";
}
?>

<!-- toast container -->
<?php if (!empty($delete_msg)): ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-white">
                <?php echo htmlspecialchars($delete_msg); ?>
                <div class="mt-2 pt-2 border-top">
                    <a href="<?php echo $fnDeletePage . $deleteID ?>"
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
        // Create a new URL object and clear all query parameters
        const url = new URL(window.location.href);
        url.search = ''; // Clear the query string
        window.history.replaceState(null, '', url.toString());
    }
</script>