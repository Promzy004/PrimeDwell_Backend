<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Message from Interested Buyer</title>
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
                <h3>Hello {{ $property->user->firstname . ' ' . $property->user->lastname }},</h3>

                <p>
                    A potential buyer has shown interest in your property 
                    <strong>“{{ $property->title }}”</strong>
                    and sent the following message:
                </p>

                <blockquote style="margin: 20px 0; padding: 15px; background-color: #f8f8f8; border-left: 4px solid #28a745;">
                    {{ $buyer_datas['buyer_message']}}
                </blockquote>

                <p><strong>Buyer Details:</strong></p>
                <ul>
                    <li><strong>Name:</strong> {{ $buyer_datas['buyer_name'] }}</li>
                    <li><strong>Email:</strong> {{ $buyer_datas['buyer_email'] }}</li>
                </ul>

                {{-- @if(isset($propertyLink))
                    <p>You can view the property here:  
                        <a href="{{ $propertyLink }}" target="_blank" style="color: #007bff;">
                            View Listing
                        </a>
                    </p>
                @endif --}}

                <p style="margin-top: 30px;">Please reach out to the buyer to continue the conversation.</p>

                <p>Best regards,<br>The PrimeDwell Team</p>
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
