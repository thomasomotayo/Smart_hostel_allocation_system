<?php include 'includes/header.php'; ?>
<h2 class="mb-4"><i class="fas fa-building"></i> Live Room Availability</h2>
<p class="text-muted">Grid updates automatically every 5 seconds.</p>
<div id="room-grid" class="row"></div>
<?php include 'includes/footer.php'; ?>
<!-- Load availability.js AFTER jQuery (footer already includes jQuery) -->
<script src="assets/js/availability.js"></script>