<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Apply the same font family globally */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #333;
        }

        .room-image {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .form {
            margin-top: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensures padding doesn't overflow the container */
            font-family: inherit; /* Ensure font consistency for inputs and textarea */
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .room-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .room-info p {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url('/booking-history') }}" class="arrow-btn">
                ← Go Back
        </a>
        <h1>Edit Booking</h1>

        <form action="{{ route('booking.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <input type="text" id="room_id" class="form-control" value="{{ $booking->room->name }}" readonly style="background-color: #f0f0f0; color: #666;">
            </div>

            <div class="mb-3">
                <label for="check_in_date" class="form-label">Check-in Date</label>
                <input type="date" name="check_in_date" id="check_in_date" class="form-control" value="{{ $booking->check_in_date }}" required>
            </div>

            <div class="mb-3">
                <label for="duration_months" class="form-label">Duration (months)</label>
                <input type="number" name="duration_months" id="duration_months" class="form-control" value="{{ $booking->duration_months }}" min="1" required>
                <small class="text-muted">Monthly rate: Rp {{ number_format($booking->room->price, 0, ',', '.') }}</small>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="4">{{ $booking->notes }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" class="form-control" value="{{ ucfirst($booking->status) }}" readonly style="background-color: #f0f0f0; color: #666;">
            </div>

            <div class="mb-3">
                <label class="form-label">Total Price</label>
                <input type="text" class="form-control" value="Rp {{ number_format($booking->total_price, 0, ',', '.') }}" readonly style="background-color: #f0f0f0; color: #666;">
            </div>

            <button type="submit" class="btn btn-primary">Update Booking</button>
        </form>
    </div>

</body>
</html>
