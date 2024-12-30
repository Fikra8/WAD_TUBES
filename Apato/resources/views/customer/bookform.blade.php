<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
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
            width: 30%;
            height: auto;
            margin: 0 auto 20px;
            display: block;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            box-sizing: border-box;
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

        /* Go Back Button Style */
        .btn-secondary {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Go Back Button -->
        <a href="{{ route('rooms.index') }}" class="arrow-btn">
            ← Go Back
        </a>
        <div class="header">
            <h1>{{ $room->name }}</h1>
        </div>

        <div class="room-info">
            <img class="room-image" src="{{ asset($room->image_path) }}" alt="Room Image">
            <p><strong>Room Type:</strong> {{ $room->type }}</p>
            <p><strong>Price:</strong> Rp {{ number_format($room->price, 0, ',', '.') }} per month</p>
            <p>{{ $room->description }}</p>
        </div>

        <div class="form">
            <h2>Book a Room</h2>
            <form action="{{ route('store_booking', $room->id) }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- CSRF protection -->

                <!-- Name -->
                <label class="form-label" for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>

                <!-- E-mail -->
                <label class="form-label" for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="ex: myname@example.com" required>

                <!-- Phone Number -->
                <label class="form-label" for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" placeholder="ex: +62 800000000" required>

                <!-- Date From -->
                <label class="form-label" for="date_from">Date From</label>
                <div style="display: flex; gap: 10px;">
                    <input type="date" id="date_from" name="date_from" required>
                    <input type="time" id="time_from" name="time_from" required>
                </div>

                <!-- Date To -->
                <label class="form-label" for="date_to">Date To</label>
                <div style="display: flex; gap: 10px;">
                    <input type="date" id="date_to" name="date_to" required>
                    <input type="time" id="time_to" name="time_to" required>
                </div>

                <!-- Number of People -->
                <label class="form-label" for="people_count">No. of People</label>
                <input type="number" id="people_count" name="people_count" placeholder="Enter number of people" min="1" required>

                <!-- Comments -->
                <label class="form-label" for="comments">Comments</label>
                <textarea id="comments" name="comments" rows="4" placeholder="Additional comments"></textarea>

                <!-- Payment Proof -->
                <div class="mb-3">
                    <label for="payment_proof" class="form-label">Proof of Payment</label>
                    <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/*" required>
                    <small class="text-muted">Upload a photo of your payment receipt</small>
                </div>

                <!-- Submit Button -->
                <button type="submit">Book Now</button>
            </form>
        </div>

    </div>
</body>
</html>
