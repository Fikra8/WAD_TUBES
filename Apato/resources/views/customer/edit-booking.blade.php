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

        <form action="{{ route('booking.update', $bookings->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <input type="text" id="room_id" class="form-control" value="{{ $bookings->room->name }}" readonly style="background-color: #f0f0f0; color: #666;">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $bookings->name }}" required>
            </div>

            <div class="mb-3">
                <label for="date_from" class="form-label">Date From</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ $bookings->date_from }}" required>
            </div>

            <div class="mb-3">
                <label for="date_to" class="form-label">Date To</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ $bookings->date_to }}" required>
            </div>

            <div class="mb-3">
                <label for="people_count" class="form-label">Number of People</label>
                <input type="number" name="people_count" id="people_count" class="form-control" value="{{ $bookings->people_count }}" min="1" required>
            </div>

            <div class="mb-3">
                <label for="comments" class="form-label">Comments</label>
                <textarea name="comments" id="comments" class="form-control" rows="4">{{ $bookings->comments }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Booking</button>
        </form>
    </div>

</body>
</html>
