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
                <div class="text-center text-5xl mb-8 font-bold">Payment Schedule</div>
                                    
                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left p-3 px-5">Days</th>
                                <th class="text-left p-3 px-5">Interest</th>
                                <th class="text-left p-3 px-5">Current</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedule as $day => $values)
                                <tr class="border-b hover:bg-orange-100">
                                    <td class="p-3 px-5">{{ $day }}</td>
                                    <td class="p-3 px-5">{{ $values['interest'] }}</td>
                                    <td class="p-3 px-5">{{ $values['current'] }}</td>
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
