function fetchAvailability() {
    $.getJSON('ajax/availability.php', function(rooms) {
        let html = '';
        rooms.forEach(room => {
            let available = room.capacity - room.occupied;
            let cardClass = available > 0 ? 'available' : 'full';
            html += `<div class="col-md-3 col-sm-6 mb-4">
                <div class="availability-card ${cardClass}">
                    <i class="fas fa-door-open fa-2x mb-3"></i>
                    <h4>Room ${room.room_number}</h4>
                    <p><i class="fas fa-building"></i> Floor ${room.floor}</p>
                    <hr>
                    <p><i class="fas fa-user"></i> Occupied: ${room.occupied}/${room.capacity}</p>
                    <h5>Available: <strong>${available}</strong></h5>
                </div>
            </div>`;
        });
        $('#room-grid').html(html);
    });
}
$(document).ready(function() {
    fetchAvailability();
    setInterval(fetchAvailability, 5000);
});