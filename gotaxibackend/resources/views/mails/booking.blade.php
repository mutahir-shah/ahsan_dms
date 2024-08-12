<h4>You have a new booking request:</h4>
<p>Pickup Person Name: {{ $name }}</p>
<p>Pickup Person Phone: {{ $phone }}</p>
<p>Destination Person Name: {{ $dname ?: 'N/A' }}</p>
<p>Destination Person Phone: {{ $dphone?: 'N/A' }}</p>
<p>Start Address: {{ $sdestination }}</p>
<p>End Address: {{ $edestination }}</p>
<p>Date: {{ date("d-m-Y H:i a", strtotime($date)) }}</p>
<p>Car Type: {{ $car_type }}</p>