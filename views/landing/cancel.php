<?php

use yii\helpers\Url;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancellation & Refund Policy</title>
    <meta name="description" content="Learn about our cancellation and refund policy">
    <meta name="author" content="Kalanzi Ibrahim">
    <link rel="icon" type="image/jpg" href="<?=Url::to(['web/images/logo.png'])?>"
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2684c6;
            --secondary-color: #f5f9fd;
            --text-color: #333333;
            --light-gray: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            padding-bottom: 80px;
            background-color: #f5f5f5;
        }

        .header-banner {
            background-color: var(--primary-color);
            width: 100%;
            padding: 60px 0 80px;
            margin-bottom: -50px;
            text-align: center;
        }

        .header-content {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            max-width: 600px;
            width: 100%;
            height: auto;
            margin: 0 auto 20px;
            display: block;
        }

        .policy-container {
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 40px;
            margin-top: -20px;
            padding-top: 20px;
            padding-bottom: 40px;
        }

        h2 {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 24px;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        h3 {
            color: var(--primary-color);
            font-weight: 500;
            font-size: 18px;
            margin-top: 25px;
        }

        p {
            margin-bottom: 15px;
        }

        ul, ol {
            margin-bottom: 20px;
            padding-left: 20px;
        }

        li {
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        th {
            background-color: var(--primary-color);
            color: white;
            text-align: left;
            padding: 12px 15px;
            font-weight: 500;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        tr:nth-child(even) {
            background-color: var(--secondary-color);
        }

        .note-box {
            background-color: var(--light-gray);
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            margin: 20px 0;
            font-size: 15px;
        }

        .divider {
            border-top: 1px dashed #d1d1d1;
            margin: 30px 0;
        }

        .contact-info {
            background-color: var(--secondary-color);
            padding: 20px;
            border-radius: 6px;
            margin-top: 30px;
        }

        a {
            color: var(--primary-color);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        strong {
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .policy-container {
                padding: 25px 15px;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
<div class="header-banner">
    <div class="header-content">
        <img src="<?=Url::to(['web/images/maqam-travels-logo.png'])?>" alt="Maqam Travels Logo" class="logo">
    </div>
</div>

<div class="policy-container">
    <p class="policy-update"><strong>Last Updated: 13 May 2025</strong></p>

    <h2>1. Introduction</h2>
    <p>This Cancellation & Refund Policy outlines the terms and conditions regarding cancellations and refunds for bookings made through <strong>Maqam Travels</strong>. By using our services, you agree to abide by the terms stated in this policy.</p>

    <h2>2. Cancellation Policy</h2>

    <h3>2.1 Cancellation Procedure</h3>
    <ul>
        <li>A formal cancellation request must be submitted in writing or via email to <a href="mailto:refund@maqamtravels.com">refund@maqamtravels.com</a>.</li>
        <li>Processing time: Within 14 business days after cancellation approval.</li>
        <li>Refunds will be made via the original payment method or bank transfer.</li>
    </ul>

    <h3>2.2 Cancellation Charges</h3>
    <table>
        <tr>
            <th>Cancellation Stage</th>
            <th>Cancellation Charges</th>
        </tr>
        <tr>
            <td>Payments below UGX 1,000,000</td>
            <td>5% Transaction Fee</td>
        </tr>
        <tr>
            <td>After Booking & Before Visa Approval</td>
            <td>
                UGX 200,000 (Umrah Administrative Charges)<br>
                UGX 350,000 (Hajj Administrative Charges)
            </td>
        </tr>
        <tr>
            <td>After Visa Approval</td>
            <td>Visa Fee (non-refundable)</td>
        </tr>
        <tr>
            <td>Less than 30 days before tour departure</td>
            <td>50% of the package cost</td>
        </tr>
        <tr>
            <td>Less than 15 days before tour departure</td>
            <td>75% of the package cost</td>
        </tr>
        <tr>
            <td>Less than 7 days before tour departure</td>
            <td>100% of the package cost</td>
        </tr>
        <tr>
            <td>Flight, Hotel & transport once already booked</td>
            <td>100% Non-Refundable once booked</td>
        </tr>
    </table>

    <div class="note-box">
        <strong>Note:</strong> The above charges are in addition to any third-party supplier penalties.
    </div>

    <h3>2.3 Exceptions for Refunds</h3>
    <p>Partial refunds may be considered under the following circumstances:</p>
    <ul>
        <li>Death of the traveler (official death certificate required).</li>
        <li>Hospitalization preventing travel (hospital-issued medical certificate required; general practitioner letters are not accepted).</li>
        <li>Visa rejection by Saudi authorities, subject to deductions for processing fees and administrative costs.</li>
    </ul>
    <p>Refund approvals for exceptional cases are at the sole discretion of <strong>Maqam Travels</strong> and service providers.</p>

    <h3>2.4 Cancellation by Maqam Travels</h3>
    <p>If <strong>Maqam Travels</strong> cancels a booking due to unforeseen circumstances, a full refund will be issued to the user.</p>
    <p>In cases where the service provider (e.g., airline, hotel, or Authorities) cancels services, refunds will be processed as per the provider's refund policy.</p>

    <div class="divider"></div>

    <h2>3. Payment Policy</h2>

    <h3>3.1 Umrah & Holiday Packages</h3>
    <ul>
        <li><strong>1st Payment:</strong> UGX 1,000,000 per person at the time of booking.</li>
        <li><strong>Final Payment:</strong> Balance due 21 days before departure.</li>
    </ul>

    <h3>3.2 Hajj Packages</h3>
    <ul>
        <li><strong>1st Payment:</strong> UGX 5,000,000 per person at the time of booking.</li>
        <li><strong>Final Payment:</strong> 45 days before departure.</li>
    </ul>
    <p><strong>Visa issuance:</strong> 30% of the remaining amount before Hajj Visa issuance.</p>

    <div class="divider"></div>

    <h2>4. Refund Policy</h2>
    <ul>
        <li>Refunds are processed within 14 business days after the cancellation request is approved.</li>
        <li>Refunds will be made via the original payment method or bank transfer.</li>
        <li>Failure to appear at the scheduled departure time and location will be treated as a no-show. No refunds or rescheduling will be permitted.</li>
        <li>If there are any excess payments, <strong>Maqam Travels</strong> will issue a <strong>Credit Note</strong> valid for future bookings.</li>
        <li>If the customer chooses not to utilize the Credit Note, they may request a refund by Mobile Money or bank transfer.</li>
        <li>Electronic refunds (via bank transfer) are processed on the <strong>10th of every month</strong>.</li>
    </ul>

    <div class="divider"></div>

    <h2>5. Visa Refusal Policy</h2>
    <p>In case of visa refusal by the embassy, <strong>the amount paid for visa fees is non refundable</strong>.</p>

    <div class="divider"></div>

    <h2>6. Force Majeure & Unforeseen Events</h2>
    <p><strong>Maqam Travels</strong> shall not be liable for cancellations or modifications due to force majeure events, including but not limited to:</p>
    <ul>
        <li>Natural disasters (earthquakes, floods, hurricanes, etc.)</li>
        <li>Political instability, war, or civil unrest</li>
        <li>Government travel restrictions or lockdowns</li>
        <li>Airline strikes or transportation disruptions</li>
    </ul>
    <p>In such cases, refunds will be processed as per the policies of the relevant service providers.</p>

    <div class="divider"></div>

    <h2>7. Contact Information</h2>
    <div class="contact-info">
        <p>For any cancellation or refund-related inquiries, please contact us at:</p>
        <p><strong>Maqam Travels</strong><br>
            Email: <a href="mailto:refund@maqamtravels.com">refund@maqamtravels.com</a><br>
            Phone: <a href="tel:+256709741486">+256 709 741486</a></p>
    </div>

    <p style="margin-top: 40px; font-style: italic;">By booking with <strong>Maqam Travels</strong>, users acknowledge that they have read, understood, and agreed to this <strong>Cancellation & Refund Policy</strong>.</p>
</div>
</body>
</html>
