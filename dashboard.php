<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="assets/img/Logobgwhite.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Management System - Comprehensive Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .main-content {
            margin-top: 90px;
            margin-left: 20px;
            margin-right: 20px;
            transition: margin-left 0.3s;
        }
        
        .main-content.sidebar-active {
            margin-left: 270px;
        }

        /* Tombol Cari Parkir dan Reservasi */
        .btn-navy {
            background: #2E4A5E; /* Warna biru navbar */
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: normal;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .btn-navy:hover {
            background: #243b53; /* Warna biru gelap saat hover */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .status-reserved {
            background-color: rgba(255, 193, 7, 0.1);
            border-left: 4px solid #FFC107;
        }
        .status-ongoing {
            background-color: rgba(23, 162, 184, 0.1);
            border-left: 4px solid #17A2B8;
        }
        .status-completed {
            background-color: rgba(40, 167, 69, 0.1);
            border-left: 4px solid #28A745;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-badge i {
            margin-right: 4px;
        }
        .parking-layout {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 10px;
            perspective: 1000px;
        }
        .parking-slot {
            aspect-ratio: 2/1;
            border: 2px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: all 0.3s ease;
            position: relative;
            transform-style: preserve-3d;
        }
        .parking-slot-available {
            background-color: #e6f3e6;
            border-color: #4CAF50;
            color: #4CAF50;
        }
        .parking-slot-occupied {
            background-color: #f8d7da;
            border-color: #DC3545;
            color: #DC3545;
            cursor: not-allowed;
        }
        .parking-slot-reserved {
            background-color: #fff3cd;
            border-color: #FFC107;
            color: #FFC107;
        }
        .parking-slot-vip {
            background-color: #f0e6ff;
            border-color: #8A2BE2;
            color: #8A2BE2;
        }
        .parking-slot-motorcycle {
            aspect-ratio: 1/1;
            background-color: #e6f3ff;
            border-color: #007BFF;
            color: #007BFF;
        }
        .parking-slot-selected {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0,123,255,0.5);
            border-color: #007BFF;
            z-index: 10;
        }
        .parking-slot-label {
            position: absolute;
            top: 5px;
            left: 5px;
            font-size: 0.7rem;
            opacity: 0.7;
        }
        .parking-lane {
            grid-column: 1 / -1;
            height: 30px;
            background-color: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #666;
        }
        
        .text-navy {
            color: #2E4A5E;
        }
        
        .vehicle-icon {
            font-size: 1.2rem;
            margin-top: 2px;
        }

        
        
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-header">
        <div class="d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/img/Logobgwhite.png" alt="Parkeer Logo" width="40" class="me-2">
                <span class="fw-bold fs-3 text-navy">Parkeer Admin</span>
            </a>
        </div>
        <div class="d-flex align-items-center">
            <img src="assets/img/profilepic.jpg" alt="Foto Profil" class="profile-img me-2">
            <span class="fw-bold text-navy">Admin</span>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="container-fluid">
            <!-- Header -->
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Parking Management System</h1>
                    <p class="text-gray-600">Centre Point Mall</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search vehicle/ticket" class="border rounded-md px-3 py-2 w-64">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </header>
            
            <!-- Floor Overview - Enhanced version -->
            <div class="mb-8">
                <div class="bg-white shadow-md rounded-lg p-5">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-xl font-semibold">
                            <i class="fas fa-parking text-blue-600 mr-2"></i>Floor 1 Status
                        </h2>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Last updated: 11:30 AM</span>
                            <button class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Main stats with visual indicators -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex-1 text-center p-3 border-r">
                            <p class="text-gray-600 text-sm">Total Slots</p>
                            <p class="text-2xl font-bold">100</p>
                            <p class="text-xs text-gray-500">Mall Capacity: 100%</p>
                        </div>
                        <div class="flex-1 text-center p-3 border-r">
                            <p class="text-gray-600 text-sm">Available</p>
                            <p class="text-2xl font-bold text-green-600">45</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                        </div>
                        <div class="flex-1 text-center p-3">
                            <p class="text-gray-600 text-sm">Occupied</p>
                            <p class="text-2xl font-bold text-red-600">55</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 55%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional parking stats -->
                    <div class="grid grid-cols-4 gap-3 text-center text-sm border-t pt-3">
                        <div>
                            <i class="fas fa-car text-blue-500 mb-1"></i>
                            <p class="font-semibold">38 Cars</p>
                        </div>
                        <div>
                            <i class="fas fa-motorcycle text-green-500 mb-1"></i>
                            <p class="font-semibold">17 Motorcycles</p>
                        </div>
                        <div>
                            <i class="fas fa-clock text-yellow-500 mb-1"></i>
                            <p class="font-semibold">5 Reserved</p>
                        </div>
                        <div>
                            <i class="fas fa-star text-purple-500 mb-1"></i>
                            <p class="font-semibold">4 VIP Parking</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Parking Slot Visualization -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                        Parking Slot Layout - Floor 1
                    </h2>
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 mr-2"></div>
                            <span>Available</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 mr-2"></div>
                            <span>Occupied</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-500 mr-2"></div>
                            <span>Reserved</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4" style="background-color: #8A2BE2;" mr-2></div>
                            <span>VIP</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 mr-2"></div>
                            <span>Motorcycle</span>
                        </div>
                    </div>
                </div>
                
                <!-- Parking Layout -->
                <div class="parking-layout">
                    <!-- Top Lane -->
                    <div class="parking-lane">Entrance</div>

                    <!-- VIP Row -->
                    <div class="parking-slot parking-slot-vip parking-slot-reserved" data-slot="V1">
                        <span class="parking-slot-label">V1</span>
                        <i class="fas fa-star vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-vip parking-slot-available" data-slot="V2">
                        <span class="parking-slot-label">V2</span>
                        <i class="fas fa-star vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-vip parking-slot-occupied" data-slot="V3">
                        <span class="parking-slot-label">V3</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-vip parking-slot-occupied" data-slot="V4">
                        <span class="parking-slot-label">V4</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-vip parking-slot-available" data-slot="V5">
                        <span class="parking-slot-label">V5</span>
                        <i class="fas fa-star vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-vip parking-slot-available" data-slot="V6">
                        <span class="parking-slot-label">V6</span>
                        <i class="fas fa-star vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-vip parking-slot-occupied" data-slot="V7">
                        <span class="parking-slot-label">V7</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-vip parking-slot-available" data-slot="V8">
                        <span class="parking-slot-label">V8</span>
                        <i class="fas fa-star vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-vip parking-slot-available" data-slot="V9">
                        <span class="parking-slot-label">V9</span>
                        <i class="fas fa-star vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-vip parking-slot-available" data-slot="V10">
                        <span class="parking-slot-label">V10</span>
                        <i class="fas fa-star vehicle-icon"></i>
                    </div>

                    <!-- Lane -->
                    <div class="parking-lane">VIP Area</div>

                    <!-- First Row (Row A) -->
                    <div class="parking-slot parking-slot-available" data-slot="A1">
                        <span class="parking-slot-label">A1</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="A2">
                        <span class="parking-slot-label">A2</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-occupied" data-slot="A3">
                        <span class="parking-slot-label">A3</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-reserved" data-slot="A4">
                        <span class="parking-slot-label">A4</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="A5">
                        <span class="parking-slot-label">A5</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="A6">
                        <span class="parking-slot-label">A6</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-occupied" data-slot="A7">
                        <span class="parking-slot-label">A7</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="A8">
                        <span class="parking-slot-label">A8</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-reserved" data-slot="A9">
                        <span class="parking-slot-label">A9</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="A10">
                        <span class="parking-slot-label">A10</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>

                    <!-- Lane -->
                    <div class="parking-lane">Main Aisle</div>

                    <!-- Second Row (Row B) -->
                    <div class="parking-slot parking-slot-available" data-slot="B1">
                        <span class="parking-slot-label">B1</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-occupied" data-slot="B2">
                        <span class="parking-slot-label">B2</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="B3">
                        <span class="parking-slot-label">B3</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-reserved" data-slot="B4">
                        <span class="parking-slot-label">B4</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="B5">
                        <span class="parking-slot-label">B5</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-occupied" data-slot="B6">
                        <span class="parking-slot-label">B6</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="B7">
                        <span class="parking-slot-label">B7</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="B8">
                        <span class="parking-slot-label">B8</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-reserved" data-slot="B9">
                        <span class="parking-slot-label">B9</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>
                    <div class="parking-slot parking-slot-available" data-slot="B10">
                        <span class="parking-slot-label">B10</span>
                        <i class="fas fa-car vehicle-icon"></i>
                    </div>

                    <!-- Lane -->
                    <div class="parking-lane">Motorcycle Area</div>

                    <!-- Motorcycle Row -->
                    <div class="parking-slot parking-slot-motorcycle parking-slot-available" data-slot="M1">
                        <span class="parking-slot-label">M1</span>
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="parking-slot parking-slot-motorcycle parking-slot-available" data-slot="M2">
                        <span class="parking-slot-label">M2</span>
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="parking-slot parking-slot-motorcycle parking-slot-occupied" data-slot="M3">
                        <span class="parking-slot-label">M3</span>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="parking-slot parking-slot-motorcycle parking-slot-available" data-slot="M4">
                        <span class="parking-slot-label">M4</span>
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="parking-slot parking-slot-motorcycle parking-slot-available" data-slot="M5">
                        <span class="parking-slot-label">M5</span>
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="parking-slot parking-slot-motorcycle parking-slot-occupied" data-slot="M6">
                        <span class="parking-slot-label">M6</span>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="parking-slot parking-slot-motorcycle parking-slot-available" data-slot="M7">
                        <span class="parking-slot-label">M7</span>
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="parking-slot parking-slot-motorcycle parking-slot-occupied" data-slot="M8">
                        <span class="parking-slot-label">M8</span>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="parking-slot parking-slot-motorcycle parking-slot-available" data-slot="M9">
                        <span class="parking-slot-label">M9</span>
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="parking-slot parking-slot-motorcycle parking-slot-available" data-slot="M10">
                        <span class="parking-slot-label">M10</span>
                        <i class="fas fa-motorcycle"></i>
                    </div>

                    <!-- Bottom Lane -->
                    <div class="parking-lane">Exit</div>
                </div>

                <!-- Booking Section -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-xl font-semibold mb-4">Booking Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2">Selected Slot</label>
                            <input type="text" id="selectedSlot" readonly class="w-full border rounded-md px-3 py-2 bg-gray-100" placeholder="No slot selected">
                        </div>
                        <div>
                            <label class="block mb-2">Vehicle Type</label>
                            <select class="w-full border rounded-md px-3 py-2" id="vehicleType">
                                <option value="car">Car</option>
                                <option value="suv">SUV</option>
                                <option value="motorcycle">Motorcycle</option>
                                <option value="vip">VIP</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2">Entry Time</label>
                            <input type="datetime-local" class="w-full border rounded-md px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2">Expected Exit Time</label>
                            <input type="datetime-local" class="w-full border rounded-md px-3 py-2">
                        </div>
                    </div>
                    <div class="mt-6 text-center">
                        <button class="btn-navy">
                            Book Slot
                        </button>
                    </div>
                </div>
            </div>
        
            <!-- Advanced Dashboard Layout -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <!-- Active Parking Sessions -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">
                        <i class="fas fa-parking mr-2 text-green-600"></i>Active Parking
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span>Total Active Sessions</span>
                            <span class="font-bold">158</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span>Cars</span>
                            <span class="font-bold text-blue-600">95</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span>Motorcycles</span>
                            <span class="font-bold text-green-600">63</span>
                        </div>
                        <div class="flex justify-between">
                            <span>VIP Vehicles</span>
                            <span class="font-bold text-purple-600">4</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Transaction Log -->
            <div class="bg-white shadow-md rounded-lg p-6 mt-8">
                <h2 class="text-xl font-semibold mb-4">
                    <i class="fas fa-list mr-2 text-gray-600"></i>Detailed Transaction Log
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left">Reservation Status</th>
                                <th class="p-3 text-left">Vehicle No</th>
                                <th class="p-3 text-left">Type</th>
                                <th class="p-3 text-left">Entry Time</th>
                                <th class="p-3 text-left">Exit Time</th>
                                <th class="p-3 text-left">Duration</th>
                                <th class="p-3 text-left">Charge</th>
                                <th class="p-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b status-reserved">
                                <td class="p-3">
                                    <span class="status-badge text-yellow-700" title="Reserved Parking">
                                        <i class="fas fa-clock"></i>Reserved
                                    </span>
                                </td>
                                <td class="p-3">B 1234 XYZ</td>
                                <td class="p-3">Car</td>
                                <td class="p-3">Scheduled: 02:00 PM</td>
                                <td class="p-3">-</td>
                                <td class="p-3">Pending</td>
                                <td class="p-3">Rp 25,000 (Advance)</td>
                                <td class="p-3">
                                    <button class="bg-yellow-500 text-white px-2 py-1 rounded text-xs mr-2">
                                        <i class="fas fa-edit mr-1"></i>Modify
                                    </button>
                                    <button class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                                        <i class="fas fa-times mr-1"></i>Cancel
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b status-ongoing">
                                <td class="p-3">
                                    <span class="status-badge text-info" title="Ongoing Parking">
                                        <i class="fas fa-parking"></i>Ongoing
                                    </span>
                                </td>
                                <td class="p-3">B 5678 ABC</td>
                                <td class="p-3">Motorcycle</td>
                                <td class="p-3">08:15 AM</td>
                                <td class="p-3">-</td>
                                <td class="p-3">3h 45m</td>
                                <td class="p-3">Rp 20,000</td>
                                <td class="p-3">
                                    <button class="bg-blue-500 text-white px-2 py-1 rounded text-xs mr-2">
                                        <i class="fas fa-eye mr-1"></i>Details
                                    </button>
                                    <button class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                        <i class="fas fa-check-circle mr-1"></i>Check Out
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b status-completed">
                                <td class="p-3">
                                    <span class="status-badge text-success" title="Completed Parking">
                                        <i class="fas fa-check-circle"></i>Completed
                                    </span>
                                </td>
                                <td class="p-3">B 9012 DEF</td>
                                <td class="p-3">Car</td>
                                <td class="p-3">06:30 AM</td>
                                <td class="p-3">09:45 AM</td>
                                <td class="p-3">3h 15m</td>
                                <td class="p-3">Rp 45,000</td>
                                <td class="p-3">
                                    <button class="bg-blue-500 text-white px-2 py-1 rounded text-xs mr-2">
                                    <i class="fas fa-print mr-1"></i>Receipt
                                    </button>
                                    <button class="bg-gray-500 text-white px-2 py-1 rounded text-xs">
                                        <i class="fas fa-archive mr-1"></i>Archive
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b status-reserved">
                                <td class="p-3">
                                    <span class="status-badge text-yellow-700" title="Reserved Parking">
                                        <i class="fas fa-clock"></i>Reserved
                                    </span>
                                </td>
                                <td class="p-3">B 3456 GHI</td>
                                <td class="p-3">SUV</td>
                                <td class="p-3">Scheduled: 04:30 PM</td>
                                <td class="p-3">-</td>
                                <td class="p-3">Pending</td>
                                <td class="p-3">Rp 30,000 (Advance)</td>
                                <td class="p-3">
                                    <button class="bg-yellow-500 text-white px-2 py-1 rounded text-xs mr-2">
                                        <i class="fas fa-edit mr-1"></i>Modify
                                    </button>
                                    <button class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                                        <i class="fas fa-times mr-1"></i>Cancel
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select parking slot functionality
        const parkingSlots = document.querySelectorAll('.parking-slot');
        const selectedSlotInput = document.getElementById('selectedSlot');
        
        parkingSlots.forEach(slot => {
            slot.addEventListener('click', function() {
                // Only allow selection of available slots (both VIP and non-VIP)
                if (this.classList.contains('parking-slot-available')) {
                    // Remove selected class from all slots
                    parkingSlots.forEach(s => s.classList.remove('parking-slot-selected'));
                    
                    // Add selected class to clicked slot
                    this.classList.add('parking-slot-selected');
                    
                    // Update selected slot input
                    selectedSlotInput.value = this.getAttribute('data-slot');
                }
            });
        });
    </script>
    <script>
        // Mengambil semua slot VIP
        const vipSlots = document.querySelectorAll('.parking-slot-vip');

        vipSlots.forEach(slot => {
            if (slot.classList.contains('parking-slot-reserved')) {
                // Jika slot VIP sudah direserve
                console.log(`Slot ${slot.getAttribute('data-slot')} sudah direserve.`);
                slot.querySelector('.parking-slot-label').textContent += " (Reserved)"; // Menambahkan label Reserved
            } else {
                // Jika slot VIP tersedia
                console.log(`Slot ${slot.getAttribute('data-slot')} tersedia.`);
            }
        });
    </script>


</body>
</html>