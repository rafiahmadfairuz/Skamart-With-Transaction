<?php 
if (isset($_SESSION['flash_message'])):
$flash_message = $_SESSION['flash_message'];
?>
    <div class="modal fade" id="ModalHasil" tabindex="-1" aria-labelledby="ModalHasilLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalHasilLabel"><?= htmlspecialchars($flash_message['header']); ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body fw-bold text-center my-4">
                    <?= htmlspecialchars($flash_message['message']); ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('ModalHasil'));
            modal.show();
        });
    </script>
<?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>
