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
                <div class="text-center text-5xl mb-8 font-bold">Accounts</div>

                <!-- Create form -->
                <form action="/controller/accounts/store.php" onsubmit="return confirm('ATTENTION! YOU ARE TRYING TO TAMPER WITH SENSITIVE DATA!');" method="post" class="mb-4">
                    <div class="space-y-2">
                        <input type="text" name="number" placeholder="Number" required maxlength="13" class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="code" placeholder="Code" required maxlength="4" class="border rounded px-3 py-2 mr-2">
                        <label for="activity">Activity:</label>
                        <select name="activity" required class="border rounded px-3 py-2 mr-2">
                            <option value="active">active</option>
                            <option value="passive">passive</option>
                        </select>
                        <input type="text" name="debit" placeholder="Debit" required class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="credit" placeholder="Credit" required class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="balance" placeholder="Balance" required class="border rounded px-3 py-2 mr-2">
                        <label for="client">Client:</label>
                        <select name="client" class="border rounded px-3 py-2 mr-2">
                            <option value="">null</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client['id'] }}">{{ $client['id_number'] }}</option>
                            @endforeach
                        </select>
                        <label for="currency">Currency:</label>
                        <select name="currency" required class="border rounded px-3 py-2 mr-2">
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency['id'] }}">{{ $currency['symbol'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="submit" value="Create New" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>
                

                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b">
                                @if (isset($accounts[0]))
                                    @foreach ($accounts[0] as $key => $value)
                                        <th class="text-left p-3 px-5">{{ $key }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                                <tr class="border-b hover:bg-orange-100">
                                    @foreach ($account as $key => $value)
                                        @if ($key == 'client' && $value['text'] == null)
                                            <td class="p-3 px-5 text-gray-500">null</td>
                                        @elseif (is_array($value) && isset($value['url']) && isset($value['text']))
                                            <td class="p-3 px-5 text-gray-500">{{ $value['text'] }}</td>
                                        @elseif (!is_array($value))
                                            <td class="p-3 px-5">{{ $value }}</td>
                                        @endif
                                    @endforeach
                                    <td><button class="edit-button text-green-500 p-3 px-5"><i class="fas fa-edit"></i></button></td>
                
                                    <!-- Delete form -->
                                    <td class="text-red-500 p-3 px-5">
                                        <form id="delete-form-{{ $account['id'] }}" action="/controller/accounts/destroy.php" method="post" onsubmit="return confirm('ATTENTION! YOU ARE TRYING TO TAMPER WITH SENSITIVE DATA! Are you sure you want to delete this record?');">
                                            <input type="hidden" name="id" value="{{ $account['id'] }}">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>                             
                                </tr>

                                <!-- Update form -->
                                <tr class="border-b hidden bg-blue-100">
                                    <form id="edit-form-{{ $account['id'] }}" action="/controller/accounts/update.php" onsubmit="return confirm('ATTENTION! YOU ARE TRYING TO TAMPER WITH SENSITIVE DATA!');" method="post">
                                        <td class="p-3 px-5">
                                            <input type="hidden" name="id" value="{{ $account['id'] }}" class="border-none focus:outline-none focus:ring-0">
                                        </td>
                                
                                        <td class="p-3 px-5"><input value="{{ $account['number'] }}" type="text" name="number" placeholder="Number" required maxlength="13" class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                
                                        <td class="p-3 px-5"><input value="{{ $account['code'] }}" type="text" name="code" placeholder="Code" required maxlength="4" class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                
                                        <td class="p-3 px-5">
                                            <select name="activity" required class="bg-blue-100 border rounded px-3 py-2 mr-2 focus:outline-none focus:ring-0">
                                                <option value="active" {{ $account['activity'] == 'active' ? 'selected' : '' }}>active</option>
                                                <option value="passive" {{ $account['activity'] == 'passive' ? 'selected' : '' }}>passive</option>
                                            </select>
                                        </td>
                                
                                        <td class="p-3 px-5"><input value="{{ $account['debit'] }}" type="text" name="debit" placeholder="Debit" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                
                                        <td class="p-3 px-5"><input value="{{ $account['credit'] }}" type="text" name="credit" placeholder="Credit" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                
                                        <td class="p-3 px-5"><input value="{{ $account['balance'] }}" type="text" name="balance" placeholder="Balance" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                
                                        <td class="p-3 px-5">
                                            <select name="client" class="bg-blue-100 border rounded px-3 py-2 mr-2 focus:outline-none focus:ring-0">
                                                <option value="">null</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client['id'] }}" {{ $account['client']['id'] == $client['id'] ? 'selected' : '' }}>{{ $client['id_number'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                
                                        <td class="p-3 px-5">
                                            <select name="currency" required class="bg-blue-100 border rounded px-3 py-2 mr-2 focus:outline-none focus:ring-0">
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency['id'] }}" {{ $account['currency']['id'] == $currency['id'] ? 'selected' : '' }}>{{ $currency['symbol'] }}</option>
                                                @endforeach
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