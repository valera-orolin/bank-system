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
                <div class="text-center text-5xl mb-8 font-bold">Currencies</div>

                <!-- Create form -->
                <form action="/controller/currencies/store.php" method="post" class="mb-4">
                    <div class="space-y-2">
                        <input type="text" name="name" placeholder="Name" required maxlength="45" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="symbol" placeholder="Symbol" required maxlength="3" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="exchange_rate" placeholder="Exchange Rate" required class="border rounded px-3 py-2 mr-2">
                    </div>
                    <input type="submit" value="Create New" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>

                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b">
                                @if (isset($currencies[0]))
                                    @foreach ($currencies[0] as $key => $value)
                                        <th class="text-left p-3 px-5">{{ $key }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($currencies as $currency)
                                <tr class="border-b hover:bg-orange-100">
                                    @foreach ($currency as $key => $value)
                                        @if (!is_array($value))
                                            <td class="p-3 px-5">{{ $value }}</td>
                                        @endif
                                    @endforeach
                                    <td><button class="edit-button text-green-500 p-3 px-5"><i class="fas fa-edit"></i></button></td>

                                    <!-- Delete form -->
                                    <td class="text-red-500 p-3 px-5">
                                        <form id="delete-form-{{ $currency['id'] }}" action="/controller/currencies/destroy.php" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            <input type="hidden" name="id" value="{{ $currency['id'] }}">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>                             
                                </tr>

                                <!-- Update form -->
                                <tr class="border-b hidden bg-blue-100">
                                    <form id="edit-form-{{ $currency['id'] }}" action="/controller/currencies/update.php" method="post">
                                        <td class="p-3 px-5">
                                            <input type="hidden" name="id" value="{{ $currency['id'] }}" class="border-none focus:outline-none focus:ring-0">
                                        </td>

                                        <td class="p-3 px-5"><input value="{{ $currency['name'] }}" type="text" name="name" placeholder="Name" required maxlength="45" class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                        <td class="p-3 px-5"><input value="{{ $currency['symbol'] }}" type="text" name="symbol" placeholder="Symbol" required maxlength="3" class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                        <td class="p-3 px-5"><input value="{{ $currency['exchange_rate'] }}" type="text" name="exchange_rate" placeholder="Exchange Rate" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>

                                        <td class="bg-blue-100 p-3 px-5 text-blue-500 cursor-pointer">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>       
                                        <td class="p-3 px-5"></td>             
                                    </form>   
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