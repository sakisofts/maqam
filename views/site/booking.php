<?php ?>
<!-- Example booking content that matches the image -->
<div class="booking-header">
    <h2>Bookings</h2>
</div>

<div class="table-controls">
    <div>
        Show
        <select>
            <option>10</option>
            <option>25</option>
            <option>50</option>
            <option>100</option>
        </select>
        entries
    </div>

    <div>
        Filter by:
        <select>
            <option>None</option>
            <option>Umrah</option>
            <option>Hajj</option>
            <option>Others</option>
        </select>
    </div>

    <div>
        Search:
        <input type="text" placeholder="Search...">
    </div>

    <button class="add-booking-btn">Add Booking</button>
</div>

<table class="booking-table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Created</th>
        <th>Booking Type</th>
        <th>Status</th>
        <th>Payment</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Mafo Shafik</td>
        <td style="color:#e53935">256705050633</td>
        <td style="color:#e53935">mafoshafik@gmail.com</td>
        <td>11/06/2024</td>
        <td>Umrah</td>
        <td><span class="status-badge approved">Approved</span></td>
        <td><span class="payment-badge complete">Complete</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <tr>
        <td>Kasirye Nasif Nalumoso</td>
        <td style="color:#e53935">256702565026</td>
        <td style="color:#e53935">Kasiryen@gmail.com</td>
        <td>21/04/2024</td>
        <td>Hajj</td>
        <td><span class="status-badge approved">Approved</span></td>
        <td><span class="payment-badge complete">Complete</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <tr>
        <td>Kasirye Shamim</td>
        <td style="color:#e53935">256759859859</td>
        <td style="color:#e53935">Kasirye.Shamim19@gmail.com</td>
        <td>10/01/2024</td>
        <td>Umrah</td>
        <td><span class="status-badge approved">Approved</span></td>
        <td><span class="payment-badge complete">Complete</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <tr>
        <td>Kalanzi Ibrahim</td>
        <td style="color:#e53935">256777076153</td>
        <td style="color:#e53935">Kalanzi.Ibrahim4@gmail.com</td>
        <td>22/06/2024</td>
        <td>Umrah</td>
        <td><span class="status-badge pending">Pending</span></td>
        <td><span class="payment-badge ongoing">On going</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <tr>
        <td>Mustafah Muswab</td>
        <td style="color:#e53935">256770530495</td>
        <td style="color:#e53935">Mustafah.Muswab@gmail.com</td>
        <td>17/07/2024</td>
        <td>Umrah</td>
        <td><span class="status-badge cancelled">Cancelled</span></td>
        <td><span class="payment-badge refund">Re-fund</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <tr>
        <td>Kasule Abdulrahman</td>
        <td style="color:#e53935">96656497537</td>
        <td style="color:#e53935">Kasule.Abdul9@gmail.com</td>
        <td>27/01/2024</td>
        <td>Umrah</td>
        <td><span class="status-badge cancelled">Cancelled</span></td>
        <td><span class="payment-badge unfinished">Unfinished</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <tr>
        <td>Ssekikubo Yasin</td>
        <td style="color:#e53935">256740827009</td>
        <td style="color:#e53935">ssekikuboyasin@gmail.com</td>
        <td>06/02/2024</td>
        <td>Others</td>
        <td><span class="status-badge approved">Approved</span></td>
        <td><span class="payment-badge complete">Complete</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <tr>
        <td>Kanyama Faisal</td>
        <td style="color:#e53935">256757808110</td>
        <td style="color:#e53935">Faisal200@gmail.com</td>
        <td>30/02/2024</td>
        <td>Hajj</td>
        <td><span class="status-badge pending">Pending</span></td>
        <td><span class="payment-badge ongoing">On going</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <tr>
        <td>Kabugo Braida</td>
        <td style="color:#e53935">256701479188</td>
        <td style="color:#e53935">Kabugo.Braida1@gmail.com</td>
        <td>22/05/2024</td>
        <td>Umrah</td>
        <td><span class="status-badge pending">Pending</span></td>
        <td><span class="payment-badge ongoing">On going</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <tr>
        <td>Nalukwago Shifrah</td>
        <td style="color:#e53935">256751814044</td>
        <td style="color:#e53935">Shifrah7@gmail.com</td>
        <td>10/07/2024</td>
        <td>Others</td>
        <td><span class="status-badge pending">Pending</span></td>
        <td><span class="payment-badge ongoing">On going</span></td>
        <td>
            <button class="action-btn"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    </tbody>
</table>

<div class="table-info">
    Showing 1 to 10 of 33 entries
</div>

<div class="pagination">
    <a href="#">Previous</a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">Next</a>
</div>
