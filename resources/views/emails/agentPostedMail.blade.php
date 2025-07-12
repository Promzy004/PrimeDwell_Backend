<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Property Posted</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <!-- Header -->
        <tr>
            <td style="background-color: #007bff; color: white; text-align: center; padding: 20px;">
                <h2>PrimeDwell</h2>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 30px;">
                <h3>Hello Admin,</h3>
                <p>A new property has just been submitted by an agent. Below are the details:</p>

                <!-- Agent Info -->
                <h4 style="margin-top: 30px;">🔑 Agent Information</h4>
                <table style="width: 100%; margin-bottom: 20px;">
                    <tr><td><strong>Name:</strong></td><td>{{ $property->user->firstname . ' ' . $property->user->lastname }}</td></tr>
                    <tr><td><strong>Email:</strong></td><td>{{ $property->user->email }}</td></tr>
                </table>

                <!-- Property Info -->
                <h4>🏠 Property Details</h4>
                <table style="width: 100%; margin-bottom: 20px;">
                    <tr><td><strong>Title:</strong></td><td>{{ $property->title }}</td></tr>
                    <tr><td><strong>Location:</strong></td><td>{{ $property->location }}</td></tr>
                    <tr><td><strong>Price:</strong></td><td>₦{{ number_format($property->price) }}</td></tr>
                    <tr><td><strong>Description:</strong></td><td>{{ $property->description }}</td></tr>
                </table>

                <!-- Images -->
                @if($property->property_images->count())
                    <h4>📷 Uploaded Images</h4>
                    @foreach($property->property_images as $image)
                        <img src="{{ $image->image_url }}" alt="Property Image" style="width: 100%; max-width: 500px; border-radius: 4px; margin-bottom: 10px;">
                    @endforeach
                @endif

                <!-- Call to Action -->
                <p style="margin-top: 30px;">
                    Please log into your <strong>admin dashboard</strong> to review and approve this listing.
                </p>

                <p>Thank you,<br>The PrimeDwell Team</p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f1f1f1; text-align: center; padding: 15px; font-size: 12px; color: #888;">
                &copy; {{ date('Y') }} PrimeDwell. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
