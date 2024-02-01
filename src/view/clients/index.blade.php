<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Bank</title>
</head>
<body class="bg-gray-100 flex items-center justify-center">

    <div class="container mx-auto px-4">
        <div class="bg-white shadow-md rounded my-6">
            <div class="text-center py-4">
                @include('partials.header')
            </div>

            <div class="px-12 pb-10">
                <div class="text-center text-5xl mb-8 font-bold">Clients</div>

                <!-- Create form -->
                <form action="/controller/clients/store.php" method="post" class="mb-4">
                    <div class="space-y-2">
                        <input type="text" name="surname" placeholder="Surname" required maxlength="45" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="firstname" placeholder="Firstname" required maxlength="45" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="patronymic" placeholder="Patronymic" required maxlength="45" class="border rounded px-3 py-2 mr-2">
                        <label for="birth_date">Birth Date:</label>
                        <input type="date" name="birth_date" required class="border rounded px-3 py-2 mr-2">
                        <label for="gender">Gender:</label>
                        <select name="gender" required class="border rounded px-3 py-2 mr-2">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                        <input type="text" name="passport_series" placeholder="Passport Series" required maxlength="2" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="passport_number" placeholder="Passport Number" required maxlength="7" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="issued_by" placeholder="Issued By" required maxlength="100" class="border rounded px-3 py-2 mr-2">
                        <label for="issue_date">Issue Date:</label>
                        <input type="date" name="issue_date" required class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="id_number" placeholder="Id Number" required maxlength="14" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="place_of_birth" placeholder="Place Of Birth" required maxlength="255" class="border rounded px-3 py-2 mr-2">
                        <label for="city_of_residence">City of residence:</label>
                        <select name="city_of_residence" required class="border rounded px-3 py-2 mr-2">
                            @foreach ($cities as $city)
                                <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="residence_address" placeholder="Residence Address" required maxlength="255" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="home_phone" placeholder="Home Phone" maxlength="9" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="mobile_phone" placeholder="Mobile Phone" maxlength="9" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="place_of_work" placeholder="Place Of Work" maxlength="45" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="position_at_work" placeholder="Position At Work" maxlength="45" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="email" placeholder="Email" maxlength="255" class="border rounded px-3 py-2 mr-2">
                        <label for="registration_city">Registration City:</label>
                        <select name="registration_city" required class="border rounded px-3 py-2 mr-2">
                            @foreach ($cities as $city)
                                <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="marital_status">Marital Status:</label>
                        <select name="marital_status" required class="border rounded px-3 py-2 mr-2">
                            @foreach ($marital_statuses as $marital_status)
                                <option value="{{ $marital_status['id'] }}">{{ $marital_status['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="citizenship">Citizenship:</label>
                        <select name="citizenship" required class="border rounded px-3 py-2 mr-2">
                            @foreach ($countries as $country)
                                <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="disability">Disability:</label>
                        <select name="citizenship" required class="border rounded px-3 py-2 mr-2">
                            @foreach ($disabilities as $disability)
                                <option value="{{ $disability['id'] }}">{{ $disability['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="pensioner">Pensioner:</label>
                        <input type="checkbox" id="pensioner" name="pensioner" value="1">
                        <label for="monthly_income">Monthly Income:</label>
                        <input type="number" id="monthly_income" name="monthly_income" step="100" min="0" class="border rounded px-3 py-2 mr-2">
                    </div>
                    <input type="submit" value="Create New" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>

                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b">
                                @if (isset($clients[0]))
                                    @foreach ($clients[0] as $key => $value)
                                        <th class="text-left p-3 px-5">{{ $key }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr class="border-b hover:bg-orange-100">
                                    @foreach ($client as $key => $value)
                                        @if ($key == 'pensioner')
                                            <td class="p-3 px-5">{{ $value == 1 ? 'Да' : 'Нет' }}</td>
                                        @elseif (is_array($value) && isset($value['url']) && isset($value['text']))
                                            <td class="p-3 px-5"><a href="{{ $value['url'] }}" class="text-gray-500 hover:text-gray-900 hover:underline">{{ $value['text'] }}</a></td>
                                        @elseif (!is_array($value))
                                            <td class="p-3 px-5">{{ $value }}</td>
                                        @endif
                                    @endforeach
                                    <td><button class="edit-button text-green-500 p-3 px-5"><i class="fas fa-edit"></i></button></td>

                                    <!-- Delete form -->
                                    <td class="text-red-500 p-3 px-5">
                                        <!--
                                        <form id="delete-form-{{ $doctor['doctorid'] }}" action="/controllers/doctors/destroy.php" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            <input type="hidden" name="doctorid" value="{{ $doctor['doctorid'] }}">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    -->
                                    </td>                             
                                </tr>

                                <!-- Update form -->
                                <tr class="border-b hidden">
                                    <!--
                                    <form id="edit-form-{{ $doctor['doctorid'] }}" action="/controllers/doctors/update.php" method="post">
                                        @foreach ($doctor as $key => $value)
                                            @if (strpos($key, 'link-') === 0)
                                                <td class="p-3 px-5"></td>
                                            @elseif ($key != 'doctorid')
                                                <td class="p-3 px-5">
                                                    <input type="text" name="{{ $key }}" value="{{ $value }}" class="border-none focus:outline-none focus:ring-0">
                                                </td>
                                            @else
                                                <td class="p-3 px-5">
                                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                                </td>
                                            @endif
                                        @endforeach
                                        <td class="p-3 px-5 text-blue-500 cursor-pointer">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>                    
                                    </form>   
                                -->       
                                </tr>                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/../../js/script.js"></script>

</body>
</html>