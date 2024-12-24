<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Optional: Link to CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book a Room</h2>
        <form action="{{ route('rooms.book') }}" method="POST">
            @csrf <!-- CSRF protection -->
            <!-- Name -->
            <label class="form-label" for="first_name">Name</label>
            <div style="display: flex; gap: 10px;">
                <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
                <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
            </div>

            <!-- E-mail -->
            <label class="form-label" for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="ex: myname@example.com" required>

            <!-- Phone Number -->
            <label class="form-label" for="phone_number">Phone Number</label>
            <input type="tel" id="phone_number" name="phone_number" placeholder="(000) 000-0000" required>

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

            <!-- Submit Button -->
            <button type="submit">Book Now</button>
        </form>
    </div>
</body>
</html>
