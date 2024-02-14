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
                <div class="text-center text-5xl mb-8 font-bold">Deposit Types</div>

                <!-- Create form -->
                <form action="/controller/deposit_types/store.php" method="post" class="mb-4">
                    <div class="space-y-2">
                        <input type="text" name="name" placeholder="Name" required maxlength="45" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="rate" placeholder="Rate" required class="border rounded px-3 py-2 mr-2">
                        <label for="currency">Currency:</label>
                        <select name="currency" required class="border rounded px-3 py-2 mr-2">
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency['id'] }}">{{ $currency['symbol'] }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="min_amount" placeholder="Minimum Amount" required class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="period" placeholder="Period" required class="border rounded px-3 py-2 mr-2">
                        <label for="revocation">Revocation:</label>
                        <select name="revocation" required class="border rounded px-3 py-2 mr-2">
                            <option value="revocable">revocable</option>
                            <option value="irrevocable">irrevocable</option>
                        </select>
                    </div>
                    <input type="submit" value="Create New" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>                

                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b">
                                @if (isset($deposit_types[0]))
                                    @foreach ($deposit_types[0] as $key => $value)
                                        <th class="text-left p-3 px-5">{{ $key }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deposit_types as $deposit_type)
                                <tr class="border-b hover:bg-orange-100">
                                    @foreach ($deposit_type as $key => $value)
                                        @if (is_array($value) && isset($value['url']) && isset($value['text']))
                                            <td class="p-3 px-5 text-gray-500">{{ $value['text'] }}</td>
                                        @elseif (!is_array($value))
                                            <td class="p-3 px-5">{{ $value }}</td>
                                        @endif
                                    @endforeach
                                    <td><button class="edit-button text-green-500 p-3 px-5"><i class="fas fa-edit"></i></button></td>

                                    <!-- Delete form -->
                                    <td class="text-red-500 p-3 px-5">
                                        <form id="delete-form-{{ $deposit_type['id'] }}" action="/controller/deposit_types/destroy.php" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            <input type="hidden" name="id" value="{{ $deposit_type['id'] }}">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>                             
                                </tr>

                                <!-- Update form -->
                                <tr class="border-b hidden bg-blue-100">
                                    <form id="edit-form-{{ $deposit_type['id'] }}" action="/controller/deposit_types/update.php" onsubmit="return confirm('ATTENTION! YOU ARE TRYING TO TAMPER WITH SENSITIVE DATA!');" method="post">
                                        <td class="p-3 px-5">
                                            <input type="hidden" name="id" value="{{ $deposit_type['id'] }}" class="border-none focus:outline-none focus:ring-0">
                                        </td>

                                        <td class="p-3 px-5"><input value="{{ $deposit_type['name'] }}" type="text" name="name" placeholder="Name" required maxlength="45" class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>

                                        <td class="p-3 px-5"><input value="{{ $deposit_type['rate'] }}" type="text" name="rate" placeholder="Rate" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>

                                        <!-- Currency select -->
                                        <td class="p-3 px-5">
                                            <select name="currency" required class="bg-blue-100 border rounded px-3 py-2 mr-2 focus:outline-none focus:ring-0">
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency['id'] }}" {{ $deposit_type['currency']['id'] == $currency['id'] ? 'selected' : '' }}>{{ $currency['symbol'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="p-3 px-5"><input value="{{ $deposit_type['min_amount'] }}" type="text" name="min_amount" placeholder="Minimum Amount" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                        
                                        <td class="p-3 px-5"><input value="{{ $deposit_type['period'] }}" type="text" name="period" placeholder="Period" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>

                                        <!-- Revocation select -->
                                        <td class="p-3 px-5">
                                            <select name="revocation" required class="bg-blue-100 border rounded px-3 py-2 mr-2 focus:outline-none focus:ring-0">
                                                <option value="revocable" {{ $deposit_type['revocation'] == 'revocable' ? 'selected' : '' }}>revocable</option>
                                                <option value="irrevocable" {{ $deposit_type['revocation'] == 'irrevocable' ? 'selected' : '' }}>irrevocable</option>
                                            </select>
                                        </td>

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