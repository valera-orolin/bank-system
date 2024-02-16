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
                <div class="text-center text-5xl mb-8 font-bold">Credits</div>

                <!-- Create form -->
                <form action="/controller/credits/store.php" method="post" class="mb-4">
                    <div class="space-y-2">
                        <label for="credit_type">Credit Type:</label>
                        <select name="credit_type" required class="border rounded px-3 py-2 mr-2">
                            @foreach ($creditTypes as $creditType)
                                <option value="{{ $creditType['id'] }}">{{ $creditType['name'] }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="start_date" placeholder="Start Date" required class="border rounded px-3 py-2 mr-2">
                        <input type="text" name="period" placeholder="Period" required class="border rounded px-3 py-2 mr-2">
                        <label for="client">Client:</label>
                        <select name="client" required class="border rounded px-3 py-2 mr-2">
                            @foreach ($clients as $client)
                                <option value="{{ $client['id'] }}">{{ $client['id_number'] }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="amount" placeholder="Amount" required class="border rounded px-3 py-2 mr-2">
                    </div>
                    <input type="submit" value="Create New" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                </form>
                                    
                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b">
                                @if (isset($credits[0]))
                                    @foreach ($credits[0] as $key => $value)
                                        <th class="text-left p-3 px-5">{{ $key }}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($credits as $credit)
                                <tr class="border-b hover:bg-orange-100">
                                    @foreach ($credit as $key => $value)
                                        @if ($key == 'client' && $value['text'] == null)
                                            <td class="p-3 px-5 text-gray-500">null</td>
                                        @elseif ($key == 'payment_schedule')
                                            <td class="p-3 px-5 text-gray-500 font-bold"><a href="{{ $value['url'] }}">{{ $value['text'] }}</a></td>
                                        @elseif (is_array($value) && isset($value['url']) && isset($value['text']))
                                            <td class="p-3 px-5 text-gray-500">{{ $value['text'] }}</td>
                                        @elseif (!is_array($value))
                                            <td class="p-3 px-5">{{ $value }}</td>
                                        @endif
                                    @endforeach
                                    <td><button class="edit-button text-green-500 p-3 px-5"><i class="fas fa-edit"></i></button></td>
                
                                    <!-- Delete form -->
                                    <td class="text-red-500 p-3 px-5">
                                        <form id="delete-form-{{ $credit['id'] }}" action="/controller/credits/destroy.php" method="post" onsubmit="return confirm('ATTENTION! YOU ARE TRYING TO TAMPER WITH SENSITIVE DATA! Are you sure you want to delete this record?');">
                                            <input type="hidden" name="id" value="{{ $credit['id'] }}">
                                            <button type="submit" class="bg-transparent border-none">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>                             
                                </tr>

                                <!-- Update form -->
                                <tr class="border-b hidden bg-blue-100">
                                    <form id="edit-form-{{ $credit['id'] }}" action="/controller/credits/update.php" onsubmit="return confirm('ATTENTION! YOU ARE TRYING TO TAMPER WITH SENSITIVE DATA!');" method="post">
                                        <td class="p-3 px-5">
                                            <input type="hidden" name="id" value="{{ $credit['id'] }}" class="border-none focus:outline-none focus:ring-0">
                                        </td>
                                
                                        <td class="p-3 px-5">
                                            <select name="credit_type" required class="bg-blue-100 border rounded px-3 py-2 mr-2 focus:outline-none focus:ring-0">
                                                @foreach ($creditTypes as $creditType)
                                                    <option value="{{ $creditType['id'] }}" {{ $credit['credit_type']['id'] == $creditType['id'] ? 'selected' : '' }}>{{ $creditType['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                
                                        <td class="p-3 px-5"><input value="{{ $credit['start_date'] }}" type="date" name="start_date" placeholder="Start Date" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                
                                        <td class="p-3 px-5"><input value="{{ $credit['period'] }}" type="text" name="period" placeholder="Period" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>

                                        <td class="p-3 px-5">
                                            <select name="client" required class="bg-blue-100 border rounded px-3 py-2 mr-2 focus:outline-none focus:ring-0">
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client['id'] }}" {{ $credit['client']['id'] == $client['id'] ? 'selected' : '' }}>{{ $client['id_number'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                
                                        <td class="p-3 px-5">
                                            <select name="current_account" required class="bg-blue-100 border rounded px-3 py-2 mr-2 focus:outline-none focus:ring-0">
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account['id'] }}" {{ $credit['current_account']['id'] == $account['id'] ? 'selected' : '' }}>{{ $account['number'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                
                                        <td class="p-3 px-5">
                                            <select name="interest_account" required class="bg-blue-100 border rounded px-3 py-2 mr-2 focus:outline-none focus:ring-0">
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account['id'] }}" {{ $credit['interest_account']['id'] == $account['id'] ? 'selected' : '' }}>{{ $account['number'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                
                                        <td class="p-3 px-5"><input value="{{ $credit['amount'] }}" type="text" name="amount" placeholder="Amount" required class="bg-blue-100 border-none focus:outline-none focus:ring-0"></td>
                                
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